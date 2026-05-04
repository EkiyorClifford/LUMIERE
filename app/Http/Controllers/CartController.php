<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function isAuthenticated()
    {
        return Auth::check();
    }

    private function getCartData()
    {
        if ($this->isAuthenticated()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            return $cart->items()->with('product', 'variant')->get();
        } else {
            $cart = session('cart', []);
            $items = [];
            foreach ($cart as $key => $item) {
                $product = Product::find($item['product_id']);
                $variant = $item['variant_id'] ? ProductVariant::find($item['variant_id']) : null;
                $items[] = (object) [
                    'id' => $key,
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $item['quantity'],
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                ];
            }

            return $items;
        }
    }

    private function addToSession($productId, $variantId, $quantity)
    {
        $cart = session('cart', []);
        $key = $productId.'-'.($variantId ?? '');
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
            ];
        }
        session(['cart' => $cart]);
    }

    private function removeFromSession($productId, $variantId)
    {
        $cart = session('cart', []);
        $key = $productId.'-'.($variantId ?? '');
        unset($cart[$key]);
        session(['cart' => $cart]);
    }

    private function updateSession($productId, $variantId, $quantity)
    {
        $cart = session('cart', []);
        $key = $productId.'-'.($variantId ?? '');
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
        }
        session(['cart' => $cart]);
    }

    public function index(Request $request)
    {
        $items = $this->getCartData();
        if ($request->wantsJson()) {
            return response()->json(['items' => $items]);
        }

        return view('cart.index', compact('items'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($this->isAuthenticated()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $item = $cart->items()->where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)->first();
            if ($item) {
                $item->increment('quantity', $request->quantity);
            } else {
                $cart->items()->create($request->only(['product_id', 'variant_id', 'quantity']));
            }
        } else {
            $this->addToSession($request->product_id, $request->variant_id, $request->quantity);
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Item added to cart']);
        }

        return redirect()->back()->with('success', 'Item added to cart');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        if ($this->isAuthenticated()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cart->items()->where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)->delete();
        } else {
            $this->removeFromSession($request->product_id, $request->variant_id);
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Item removed from cart']);
        }

        return redirect()->back()->with('success', 'Item removed');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($this->isAuthenticated()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $item = $cart->items()->where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)->first();
            if ($item) {
                $item->update(['quantity' => $request->quantity]);
            }
        } else {
            $this->updateSession($request->product_id, $request->variant_id, $request->quantity);
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Cart updated']);
        }

        return redirect()->back()->with('success', 'Cart updated');
    }
}
