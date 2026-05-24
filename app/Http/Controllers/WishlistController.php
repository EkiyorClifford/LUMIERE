<?php

namespace App\Http\Controllers;

// I need these models for wishlist operations
// Product for product details, Wishlist for the user's wishlist container
use App\Models\Product;
use App\Models\Wishlist;
// Request for handling input, Auth for user authentication
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Helper method to check if user is logged in
     * Just like in CartController, I'm using this to decide between database vs session storage
     */
    private function isAuthenticated()
    {
        return Auth::check();
    }

    /**
     * Get all wishlist items for the current user/guest
     * Similar to CartController but simpler - wishlist only stores product IDs
     * I'm loading product relationships needed for the wishlist page display
     */
    public function getWishlistData()
    {
        if ($this->isAuthenticated()) {
            // For logged-in users, get wishlist from database
            $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);

            // Eager load all product data needed for wishlist display
            // Collection for navigation, primaryImage for thumbnails, variants for options
            return $wishlist->items()->with('product.collection', 'product.primaryImage', 'product.variants')->get();
        } else {
            // For guests, wishlist is just an array of product IDs in session
            $wishlist = session('wishlist', []);
            $items = [];

            // Load full product data for each wishlist item
            foreach ($wishlist as $productId) {
                $product = Product::with('collection', 'primaryImage', 'variants')->find($productId);
                if ($product) {
                    // Create object with same structure as database wishlist items
                    $items[] = (object) [
                        'product' => $product,
                        'product_id' => $product->id,
                        'created_at' => null, // Session items don't have timestamps
                    ];
                }
            }

            return collect($items);
        }
    }

    /**
     * Add product to guest wishlist (session storage)
     * Much simpler than cart - just storing product IDs in an array
     * Check if already exists to prevent duplicates
     */
    private function addToSession($productId)
    {
        $wishlist = session('wishlist', []);
        if (! in_array($productId, $wishlist)) {
            $wishlist[] = $productId;
            session(['wishlist' => $wishlist]);
        }
    }

    /**
     * Remove product from guest wishlist (session storage)
     * Using array_diff to remove the product and re-indexing with array_values
     */
    private function removeFromSession($productId)
    {
        $wishlist = session('wishlist', []);
        $wishlist = array_diff($wishlist, [$productId]);
        session(['wishlist' => array_values($wishlist)]);
    }

    /**
     * Show the wishlist page
     * Just loads all wishlist items and passes them to the view
     */
    public function index()
    {
        $items = $this->getWishlistData();

        // Get recommended products for "You may also love" section
        // Get random active products with primary images, excluding wishlist items
        $wishlistProductIds = $items->pluck('product_id')->toArray();
        $recommendedProducts = Product::query()
            ->with('collection', 'primaryImage')
            ->where('is_active', true)
            ->whereNotIn('id', $wishlistProductIds)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('wishlist', compact('items', 'recommendedProducts'));
    }

    /**
     * Add/remove product from wishlist (toggle functionality)
     * This method handles both adding and removing based on current state
     * If product is already in wishlist, it removes it (toggle behavior)
     * Returns JSON with action type for JavaScript UI updates
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if ($this->isAuthenticated()) {
            // For logged-in users, check if product already exists in wishlist
            $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);
            $exists = $wishlist->items()->where('product_id', $request->product_id)->exists();

            if ($exists) {
                // Product exists - remove it (toggle off)
                $wishlist->items()->where('product_id', $request->product_id)->delete();
                $action = 'removed';
            } else {
                // Product doesn't exist - add it (toggle on)
                $wishlist->items()->create(['product_id' => $request->product_id]);
                $action = 'added';
            }
        } else {
            // For guests, handle the same toggle logic in session
            $wishlist = session('wishlist', []);
            if (in_array($request->product_id, $wishlist)) {
                // Remove from session wishlist
                $wishlist = array_diff($wishlist, [$request->product_id]);
                session(['wishlist' => array_values($wishlist)]);
                $action = 'removed';
            } else {
                // Add to session wishlist
                $wishlist[] = $request->product_id;
                session(['wishlist' => $wishlist]);
                $action = 'added';
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            // For AJAX requests, return the action type and new count
            // This lets JavaScript update the UI correctly (heart icon, badge count)
            $count = $this->getWishlistData()->count();

            return response()->json(['success' => true, 'action' => $action, 'count' => $count]);
        }

        // For normal requests, redirect back with success message
        return redirect()->back()->with('success', 'Wishlist updated');
    }

    /**
     * Remove product from wishlist (force remove, not toggle)
     * This is different from add() - it always removes, doesn't check state
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if ($this->isAuthenticated()) {
            // Remove from database wishlist
            $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);
            $wishlist->items()->where('product_id', $request->product_id)->delete();
        } else {
            // Remove from session wishlist
            $this->removeFromSession($request->product_id);
        }

        if ($request->ajax() || $request->wantsJson()) {
            // Return new count for badge update
            $count = $this->getWishlistData()->count();

            return response()->json(['success' => true, 'count' => $count]);
        }

        return redirect()->back()->with('success', 'Product removed from wishlist');
    }

    /**
     * API endpoint to get current wishlist count
     * Similar to CartController's getCartCount() method
     * Called by JavaScript to update the wishlist badge
     */
    public function count()
    {
        $count = $this->getWishlistData()->count();

        return response()->json(['count' => $count]);
    }
}
