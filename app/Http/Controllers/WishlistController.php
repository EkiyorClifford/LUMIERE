<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\WishlistService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(
        private WishlistService $wishlistService,
    ) {}

    /**
     * Show the wishlist page
     */
    public function index()
    {
        $items = $this->wishlistService->getWishlistData();

        // Get recommended products for "You may also love" section
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
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $action = $this->wishlistService->toggle((int) $request->product_id);

        if ($request->ajax() || $request->wantsJson()) {
            $count = $this->wishlistService->count();

            return response()->json(['success' => true, 'action' => $action, 'count' => $count]);
        }

        return redirect()->back()->with('success', 'Wishlist updated');
    }

    /**
     * Remove product from wishlist (force remove, not toggle)
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $this->wishlistService->remove((int) $request->product_id);

        if ($request->ajax() || $request->wantsJson()) {
            $count = $this->wishlistService->count();

            return response()->json(['success' => true, 'count' => $count]);
        }

        return redirect()->back()->with('success', 'Product removed from wishlist');
    }

    /**
     * API endpoint to get current wishlist count
     */
    public function count()
    {
        $count = $this->wishlistService->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Get wishlist data (for backward compatibility)
     */
    public function getWishlistData()
    {
        return $this->wishlistService->getWishlistData();
    }
}
