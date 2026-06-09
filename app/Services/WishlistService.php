<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class WishlistService
{
    /**
     * Check if user is authenticated
     */
    private function isAuthenticated(): bool
    {
        return auth('web')->check();
    }

    /**
     * Get or create a wishlist for the authenticated user
     */
    private function getOrCreateAuthWishlist(): Wishlist
    {
        return Wishlist::firstOrCreate(['user_id' => auth('web')->id()]);
    }

    /**
     * Get all wishlist items for the current user/guest
     */
    public function getWishlistData(): Collection
    {
        if ($this->isAuthenticated()) {
            $wishlist = $this->getOrCreateAuthWishlist();

            return $wishlist->items()->with('product.collection', 'product.primaryImage', 'product.variants')->get();
        }

        return $this->getSessionWishlistItems();
    }

    /**
     * Get wishlist items from session for guests
     */
    private function getSessionWishlistItems(): Collection
    {
        $wishlist = session('wishlist', []);
        $items = [];

        foreach ($wishlist as $productId) {
            $product = Product::with('collection', 'primaryImage', 'variants')->find($productId);
            if ($product) {
                $items[] = (object) [
                    'product' => $product,
                    'product_id' => $product->id,
                    'created_at' => null,
                ];
            }
        }

        return collect($items);
    }

    /**
     * Add/remove product from wishlist (toggle)
     */
    public function toggle(int $productId): string
    {
        Product::findOrFail($productId);

        if ($this->isAuthenticated()) {
            return $this->toggleAuthWishlist($productId);
        }

        return $this->toggleSessionWishlist($productId);
    }

    /**
     * Toggle wishlist for authenticated user
     */
    private function toggleAuthWishlist(int $productId): string
    {
        $wishlist = $this->getOrCreateAuthWishlist();
        $exists = $wishlist->items()->where('product_id', $productId)->exists();

        if ($exists) {
            $wishlist->items()->where('product_id', $productId)->delete();

            return 'removed';
        }

        $wishlist->items()->create(['product_id' => $productId]);

        return 'added';
    }

    /**
     * Toggle wishlist for guest
     */
    private function toggleSessionWishlist(int $productId): string
    {
        $wishlist = session('wishlist', []);

        if (in_array($productId, $wishlist)) {
            $wishlist = array_diff($wishlist, [$productId]);
            session(['wishlist' => array_values($wishlist)]);

            return 'removed';
        }

        $wishlist[] = $productId;
        session(['wishlist' => $wishlist]);

        return 'added';
    }

    /**
     * Add product to wishlist
     */
    public function add(int $productId): void
    {
        Product::findOrFail($productId);

        if ($this->isAuthenticated()) {
            $wishlist = $this->getOrCreateAuthWishlist();
            $wishlist->items()->firstOrCreate(['product_id' => $productId]);
        } else {
            $this->addToSession($productId);
        }
    }

    /**
     * Add product to guest wishlist
     */
    private function addToSession(int $productId): void
    {
        $wishlist = session('wishlist', []);
        if (! in_array($productId, $wishlist)) {
            $wishlist[] = $productId;
            session(['wishlist' => $wishlist]);
        }
    }

    /**
     * Remove product from wishlist
     */
    public function remove(int $productId): bool
    {
        if ($this->isAuthenticated()) {
            $wishlist = $this->getOrCreateAuthWishlist();

            return $wishlist->items()->where('product_id', $productId)->delete() > 0;
        }

        return $this->removeFromSession($productId);
    }

    /**
     * Remove product from guest wishlist
     */
    private function removeFromSession(int $productId): bool
    {
        $wishlist = session('wishlist', []);
        if (in_array($productId, $wishlist)) {
            $wishlist = array_diff($wishlist, [$productId]);
            session(['wishlist' => array_values($wishlist)]);

            return true;
        }

        return false;
    }

    /**
     * Check if product is in wishlist
     */
    public function isInWishlist(int $productId): bool
    {
        if ($this->isAuthenticated()) {
            $wishlist = $this->getOrCreateAuthWishlist();

            return $wishlist->items()->where('product_id', $productId)->exists();
        }

        return in_array($productId, session('wishlist', []));
    }

    /**
     * Get wishlist count
     */
    public function count(): int
    {
        return $this->getWishlistData()->count();
    }

    /**
     * Clear wishlist
     */
    public function clear(): bool
    {
        if ($this->isAuthenticated()) {
            $wishlist = $this->getOrCreateAuthWishlist();

            return $wishlist->items()->delete() > 0;
        }

        session(['wishlist' => []]);

        return true;
    }
}
