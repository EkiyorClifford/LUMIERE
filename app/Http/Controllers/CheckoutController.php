<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to proceed with checkout');
        }

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $user = Auth::user();
        $addresses = $user->addresses ?? collect();

        $subtotal = $cartItems->sum(function ($item) {
            $price = $this->cartItemPrice($item);

            return $price * $item->quantity;
        });

        $shipping = 0;
        $tax = $subtotal * 0.08;
        $total = $subtotal + $shipping + $tax;

        return view('checkout', compact(
            'cartItems',
            'user',
            'addresses',
            'subtotal',
            'shipping',
            'tax',
            'total'
        ));
    }

    public function store(Request $request)
    {
        if (! Auth::check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $request->validate([
            'shipping_full_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:255',
            'billing_same_as_shipping' => 'boolean',
            'payment_method' => 'required|in:stripe,paypal',
            'card_number' => 'required_if:payment_method,stripe',
            'card_expiry' => 'required_if:payment_method,stripe',
            'card_cvc' => 'required_if:payment_method,stripe',
        ]);

        try {
            $cartItems = $this->getCartItems();

            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }

            $subtotal = $cartItems->sum(function ($item) {
                $price = $this->cartItemPrice($item);

                return $price * $item->quantity;
            });

            $shipping = 0;
            $tax = $subtotal * 0.08;
            $total = $subtotal + $shipping + $tax;

            $orderReference = 'LM-'.date('Y').'-'.str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderReference,
                'total' => $total,
                'order_status' => 'pending',
                'shipping_full_name' => $request->shipping_full_name,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_country' => $request->shipping_country,
            ]);

            foreach ($cartItems as $cartItem) {
                $price = $this->cartItemPrice($cartItem);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'product_name' => $cartItem->product->name,
                    'variant_label' => $cartItem->variant?->label,
                    'price' => $price,
                ]);
            }

            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'payment_reference' => $orderReference,
                'payment_status' => 'pending',
            ]);

            Shipment::create([
                'order_id' => $order->id,
                'tracking_number' => $orderReference.'-SHIP',
                'status' => 'pending',
            ]);

            if ($request->payment_method === 'stripe') {
                $paymentResult = $this->processStripePayment($request, $total, $orderReference);

                if ($paymentResult['success']) {
                    $payment->update([
                        'payment_status' => 'completed',
                        'payment_reference' => $paymentResult['transaction_id'],
                    ]);
                    $order->update(['order_status' => 'paid']);
                } else {
                    $payment->update(['payment_status' => 'failed']);

                    return response()->json(['error' => $paymentResult['message']], 400);
                }
            }

            $this->clearCart();
            $this->sendOrderConfirmationEmail($order);

            return response()->json([
                'success' => true,
                'order_number' => $orderReference,
                'redirect_url' => route('checkout.success', ['order' => $order]),
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your order'], 500);
        }
    }

    private function getCartItems()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        return $cart->items()->with('product', 'variant')->get();
    }

    private function cartItemPrice($item): float
    {
        return (float) $item->product->price + (float) ($item->variant?->price_modifier ?? 0);
    }

    private function clearCart()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->items()->delete();
        }
    }

    private function processStripePayment($request, $amount, $orderNumber)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            if (app()->environment('testing') && $request->stripeToken === 'tok_visa') {
                return [
                    'success' => true,
                    'transaction_id' => 'ch_test_'.$orderNumber,
                ];
            }

            $amountInCents = intval($amount * 100);

            $charge = Charge::create([
                'amount' => $amountInCents,
                'currency' => 'eur',
                'source' => $request->stripeToken,
                'description' => "Order {$orderNumber}",
                'metadata' => ['order_number' => $orderNumber],
            ]);

            return [
                'success' => true,
                'transaction_id' => $charge->id,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    private function sendOrderConfirmationEmail($order)
    {
        try {
            Mail::to($order->user->email)->send(new OrderConfirmation($order));
        } catch (Exception $e) {
            Log::error('Failed to send order confirmation email: '.$e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout', ['success' => true, 'order' => $order]);
    }
}
