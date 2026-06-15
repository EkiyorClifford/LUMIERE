<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use App\Services\WishlistService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private WishlistService $wishlistService,
    ) {}

    /**
     * Show the cart page
     */
    public function index(Request $request)
    {
        $items = $this->cartService->getCartData();
        if ($request->wantsJson()) {
            return response()->json(['items' => $items]);
        }

        return view('cart.index', compact('items'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->add(
            (int) $request->product_id,
            $request->variant_id ? (int) $request->variant_id : null,
            (int) $request->quantity
        );

        if ($request->ajax() || $request->wantsJson()) {
            $count = $this->cartService->cartCount();

            return response()->json([
                'success' => true,
                'count' => $count,
                'cart_count' => $count,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart');
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
        ]);

        $this->cartService->remove(
            (int) $request->product_id,
            $request->variant_id ? (int) $request->variant_id : null
        );

        if ($request->ajax() || $request->wantsJson()) {
            $count = $this->cartService->cartCount();

            return response()->json([
                'success' => true,
                'count' => $count,
                'cart_count' => $count,
            ]);
        }

        return redirect()->back()->with('success', 'Product removed from cart');
    }

    /**
     * Update item quantity in cart
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $this->cartService->updateQuantity(
            (int) $request->product_id,
            $request->variant_id ? (int) $request->variant_id : null,
            (int) $request->quantity
        );

        if ($request->ajax() || $request->wantsJson()) {
            $count = $this->cartService->cartCount();

            return response()->json([
                'success' => true,
                'count' => $count,
                'cart_count' => $count,
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated');
    }

    /**
     * Update cart item quantity via route parameter
     */
    public function updateQuantity(Request $request, int $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        if ($this->isAuthenticated()) {
            $cart = auth('web')->user()->cart()->first();
            abort_if(! $cart, 404, 'Cart not found');

            $cartItem = $cart->items()->findOrFail($item);
            $this->cartService->updateQuantity(
                $cartItem->product_id,
                $cartItem->variant_id,
                (int) $request->quantity
            );
        } else {
            // For guests, extract product_id and variant_id from request
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'nullable|integer|exists:product_variants,id',
            ]);

            $this->cartService->updateQuantity(
                (int) $request->product_id,
                $request->variant_id ? (int) $request->variant_id : null,
                (int) $request->quantity
            );
        }

        if ($request->ajax() || $request->wantsJson()) {
            $count = $this->cartService->cartCount();

            return response()->json([
                'success' => true,
                'count' => $count,
                'cart_count' => $count,
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated');
    }

    /**
     * Check if user is authenticated
     */
    private function isAuthenticated(): bool
    {
        return auth('web')->check();
    }

    /**
     * Delete cart item via route parameter
     */
    public function destroy(Request $request, int $item)
    {
        if ($this->isAuthenticated()) {
            $cart = auth('web')->user()->cart()->first();
            abort_if(! $cart, 404, 'Cart not found');
            $cart->items()->findOrFail($item)->delete();
        } else {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'nullable|integer|exists:product_variants,id',
            ]);

            $this->cartService->remove(
                (int) $request->product_id,
                $request->variant_id ? (int) $request->variant_id : null
            );
        }

        if ($request->ajax() || $request->wantsJson()) {
            $count = $this->cartService->cartCount();

            return response()->json([
                'success' => true,
                'count' => $count,
                'cart_count' => $count,
            ]);
        }

        return redirect()->back()->with('success', 'Product removed from cart');
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $this->cartService->clear();

        return redirect()->back()->with('success', 'Cart cleared');
    }

    /**
     * Home page method - loads cart and wishlist data for the welcome page
     */
    public function home()
    {
        // Ensure guest cart exists in session
        $this->cartService->ensureGuestCart();

        $items = $this->cartService->getCartData();
        $cartCount = $this->cartService->cartCount();
        $wishlistCount = $this->wishlistService->count();

        // Get featured products for the bestsellers section
        $featuredProducts = Product::query()
            ->with('collection', 'primaryImage')
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('welcome', compact('cartCount', 'items', 'wishlistCount', 'featuredProducts'));
    }

    /**
     * Get cart count (for backward compatibility)
     */
    public function cartCount(): int
    {
        return $this->cartService->cartCount();
    }

    /**
     * Get cart count via API route
     */
    public function getCartCount()
    {
        $count = $this->cartService->cartCount();

        return response()->json([
            'count' => $count,
            'cart_count' => $count,
        ]);
    }

    /**
     * Get cart data (for backward compatibility)
     */
    public function getCartData()
    {
        return $this->cartService->getCartData();
    }
}
