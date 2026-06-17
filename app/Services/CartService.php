<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;

class CartService
{
    /**
     * Check if user is authenticated
     */
    private function isAuthenticated(): bool
    {
        return auth('web')->check();
    }

    /**
     * Get or create a cart for the authenticated user
     */
    private function getOrCreateAuthCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth('web')->id()]);
    }

    /**
     * Get all cart items for the current user/guest
     */
    public function getCartData(): Collection
    {
        if ($this->isAuthenticated()) {
            $cart = $this->getOrCreateAuthCart();

            return $cart->items()->with('product.primaryImage', 'variant')->get();
        }

        return $this->getSessionCartItems();
    }

    /**
     * Get cart items from session for guests
     */
    private function getSessionCartItems(): Collection
    {
        $cart = session('cart', []);
        if (! is_iterable($cart)) {
            $cart = [];
        }

        $cartItems = collect($cart);
        $products = Product::query()
            ->with('primaryImage')
            ->whereIn('id', $cartItems->pluck('product_id')->filter()->unique())
            ->get()
            ->keyBy('id');

        $variants = ProductVariant::query()
            ->whereIn('id', $cartItems->pluck('variant_id')->filter()->unique())
            ->get()
            ->keyBy('id');

        $items = [];
        foreach ($cartItems as $key => $item) {
            $items[] = (object) [
                'id' => $key,
                'product' => $products->get($item['product_id']),
                'variant' => $item['variant_id'] ? $variants->get($item['variant_id']) : null,
                'quantity' => $item['quantity'],
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
            ];
        }

        return collect($items);
    }

    /**
     * Calculate total number of items in cart
     */
    public function cartCount(): int
    {
        return (int) $this->getCartData()->sum(fn ($item) => $item->quantity ?? 1);
    }

    /**
     * Add item to cart
     */
    public function add(int $productId, ?int $variantId, int $quantity): void
    {
        $product = Product::findOrFail($productId);
        abort_if(! $product->is_active, 422, 'This product is no longer available.');

        if ($this->isAuthenticated()) {
            $this->addToAuthCart($productId, $variantId, $quantity);
        } else {
            $this->addToSession($productId, $variantId, $quantity);
        }
    }

    /**
     * Add item to authenticated user's cart
     */
    private function addToAuthCart(int $productId, ?int $variantId, int $quantity): void
    {
        $cart = $this->getOrCreateAuthCart();

        $item = $cart->items()
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }
    }

    /**
     * Add item to guest cart (session storage)
     */
    private function addToSession(int $productId, ?int $variantId, int $quantity): void
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

    /**
     * Remove item from cart
     */
    public function remove(int $productId, ?int $variantId): bool
    {
        if ($this->isAuthenticated()) {
            return $this->removeFromAuthCart($productId, $variantId);
        }

        return $this->removeFromSession($productId, $variantId);
    }

    /**
     * Remove item from authenticated user's cart
     */
    private function removeFromAuthCart(int $productId, ?int $variantId): bool
    {
        $cart = $this->getOrCreateAuthCart();

        return $cart->items()
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->delete() > 0;
    }

    /**
     * Remove item from guest cart (session storage)
     */
    private function removeFromSession(int $productId, ?int $variantId): bool
    {
        $cart = session('cart', []);
        $key = $productId.'-'.($variantId ?? '');

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['cart' => $cart]);

            return true;
        }

        return false;
    }

    /**
     * Update item quantity in cart
     */
    public function updateQuantity(int $productId, ?int $variantId, int $quantity): void
    {
        if ($this->isAuthenticated()) {
            $this->updateAuthQuantity($productId, $variantId, $quantity);
        } else {
            $this->updateSessionQuantity($productId, $variantId, $quantity);
        }
    }

    /**
     * Update quantity in authenticated user's cart
     */
    private function updateAuthQuantity(int $productId, ?int $variantId, int $quantity): void
    {
        $cart = $this->getOrCreateAuthCart();
        $item = $cart->items()
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        if (! $item) {
            return;
        }

        if ($quantity <= 0) {
            $item->delete();
        } else {
            $item->update(['quantity' => $quantity]);
        }
    }

    /**
     * Update quantity in guest cart (session storage)
     */
    private function updateSessionQuantity(int $productId, ?int $variantId, int $quantity): void
    {
        $cart = session('cart', []);
        $key = $productId.'-'.($variantId ?? '');

        if (isset($cart[$key])) {
            if ($quantity <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = $quantity;
            }
            session(['cart' => $cart]);
        }
    }

    /**
     * Clear cart
     */
    public function clear(): bool
    {
        if ($this->isAuthenticated()) {
            $cart = $this->getOrCreateAuthCart();

            return $cart->items()->delete() > 0;
        }

        session(['cart' => []]);

        return true;
    }

    /**
     * Ensure guest cart exists in session
     */
    public function ensureGuestCart(): void
    {
        if (! $this->isAuthenticated() && ! session('cart')) {
            session(['cart' => []]);
        }
    }
}
