<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Services\CartService;
use App\Services\WishlistService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private WishlistService $wishlistService,
    ) {}

    /**
     * Show the main shop page with all products and filters.
     */
    public function index(Request $request, ?string $category = null): View
    {
        if (! Schema::hasTable('products') || ! Schema::hasTable('categories')) {
            return view('shop', [
                'activeCategory' => $category,
                'categories' => collect(),
                'collections' => collect(),
                'products' => collect(),
                'filters' => [],
                'cartCount' => 0,
            ]);
        }

        $filters = $request->only(['category', 'collection', 'price_min', 'price_max', 'search']);
        $activeCategory = $filters['category'] ?? $category;

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $collections = Collection::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $activeCollection = $collections->firstWhere('slug', $filters['collection'] ?? null);

        $products = Product::query()
            ->with(['collection', 'primaryImage', 'images'])
            ->where('is_active', true)
            ->when($activeCategory, fn ($query) => $query->where('category', $activeCategory))
            ->when($activeCollection, fn ($query) => $query->where('collection_id', $activeCollection->id))
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($filters['price_min'] ?? null, fn ($query, $price) => $query->where('price', '>=', $price))
            ->when($filters['price_max'] ?? null, fn ($query, $price) => $query->where('price', '<=', $price))
            ->orderBy('sort_order')
            ->get();

        $cartCount = $this->cartService->cartCount();

        return view('shop', [
            'activeCategory' => $activeCategory,
            'categories' => $categories,
            'collections' => $collections,
            'filters' => $filters,
            'products' => $products,
            'cartCount' => $cartCount,
        ]);
    }

    /**
     * Show individual product detail page.
     */
    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load([
            'attributes',
            'collection',
            'images',
            'reviews.user',
            'variants',
        ]);

        $relatedProducts = Product::query()
            ->with('primaryImage')
            ->where('is_active', true)
            ->whereKeyNot($product->id)
            ->where(function ($query) use ($product): void {
                $query->where('collection_id', $product->collection_id)
                    ->orWhere('category', $product->category);
            })
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $items = $this->cartService->getCartData();
        $cartCount = count($items);

        $wishlistItems = $this->wishlistService->getWishlistData();
        $wishlistCount = $wishlistItems->count();
        $isWishlisted = $this->wishlistService->isInWishlist($product->id);

        return view('product_detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'cartCount' => $cartCount,
            'wishlistCount' => $wishlistCount,
            'isWishlisted' => $isWishlisted,
        ]);
    }

    /**
     * Show all collections page.
     */
    public function collections(): View
    {
        if (! Schema::hasTable('collections')) {
            return view('collections', [
                'collections' => collect(),
            ]);
        }

        $collections = Collection::query()
            ->with(['products' => fn ($query) => $query->where('is_active', true)->with('primaryImage')])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('collections', [
            'collections' => $collections,
        ]);
    }
}
