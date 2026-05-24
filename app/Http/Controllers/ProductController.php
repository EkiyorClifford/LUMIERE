<?php

namespace App\Http\Controllers;

// I'm importing the models I need for product listings and details
// Category and Collection for filtering/navigation
// Product for the main product queries
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
// View contract for type hints and Request for handling input
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
// Schema to check if tables exist before querying (prevents errors in fresh installs)
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    /**
     * Curated collection page content keyed by collection slug.
     */
    private const COLLECTION_PAGE_CONTENT = [
        'leclat' => [
            'eyebrow' => 'DIAMOND COLLECTION',
            'tagline' => 'Brilliance captured in motion.',
            'hero_copy' => 'Flawless diamonds chosen for fire, precision-set in 18k gold.',
            'story_heading' => 'A study in light',
            'story_body' => 'L\'Éclat celebrates the architecture of brilliance. Each piece is designed to move with light, balancing clean geometry with quiet opulence for evenings that deserve presence.',
            'trust_points' => ['Ethically sourced stones', 'Hand-set craftsmanship', 'Lifetime care'],
            'cta_heading' => 'Need help choosing your diamond silhouette?',
        ],
        'lor' => [
            'eyebrow' => 'GOLD COLLECTION',
            'tagline' => 'Sculpted warmth, forever wearable.',
            'hero_copy' => 'Fluid forms in 18k and 22k gold, crafted for everyday luxury.',
            'story_heading' => 'The language of gold',
            'story_body' => 'L\'Or is warmth translated into form. From polished cuffs to tactile textures, each creation is built for layering, daily ritual, and timeless confidence.',
            'trust_points' => ['18k/22k craftsmanship', 'Hand-finished surfaces', 'Paris atelier finishing'],
            'cta_heading' => 'Build your gold stack with an expert',
        ],
        'la-perle' => [
            'eyebrow' => 'PEARL COLLECTION',
            'tagline' => 'The ocean\'s quiet luxury.',
            'hero_copy' => 'South Sea and Akoya pearls selected for luster, tone, and harmony.',
            'story_heading' => 'Soft light, refined presence',
            'story_body' => 'La Perle explores subtle radiance through carefully matched pearls and clean gold settings. Modern proportions preserve the softness of classic pearl jewelry.',
            'trust_points' => ['Responsible farm sourcing', 'Matched by hand', 'Care guide included'],
            'cta_heading' => 'Unsure which pearl tone suits you?',
        ],
    ];

    /**
     * Show the main shop page with all products and filters
     * I'm handling category filtering via URL parameter and query string filters
     * The category parameter comes from the route, other filters from ?query=params
     */
    public function index(Request $request, ?string $category = null): View
    {
        // Safety check - if tables don't exist yet (fresh install), show empty shop
        // This prevents 500 errors during setup/migration
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

        // Grab all the filter parameters from the query string
        // category, collection, and price range filters
        $filters = $request->only(['category', 'collection', 'price_min', 'price_max', 'search']);

        // Active category can come from either the URL route or query param
        // Query param takes precedence for consistency with other filters
        $activeCategory = $filters['category'] ?? $category;

        // Get all active categories for the filter sidebar
        // Ordered by sort_order so I control the display sequence
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Same for collections - these are like curated product groups
        $collections = Collection::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Find the active collection if one was selected in the filters
        // Using firstWhere() to get the first match or null
        $activeCollection = $collections->firstWhere('slug', $filters['collection'] ?? null);

        // Build the products query with all the filters
        // Eager loading collection and primaryImage to avoid N+1 queries
        $products = Product::query()
            ->with(['collection', 'primaryImage', 'images']) // Load relationships in one query
            ->where('is_active', true) // Only show active products

            // Apply category filter if one is selected
            ->when($activeCategory, fn ($query) => $query->where('category', $activeCategory))

            // Apply collection filter if one is selected
            ->when($activeCollection, fn ($query) => $query->where('collection_id', $activeCollection->id))

            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })

            // Price range filters - minimum and maximum
            ->when($filters['price_min'] ?? null, fn ($query, $price) => $query->where('price', '>=', $price))
            ->when($filters['price_max'] ?? null, fn ($query, $price) => $query->where('price', '<=', $price))

            // Order by sort_order so I control the product display sequence
            ->orderBy('sort_order')
            ->get();

        // Get cart count for the header badge
        $cartController = new CartController;
        $cartCount = $cartController->cartCount();

        // Pass all the data to the shop view
        // The view needs: current filters, all categories/collections for navigation, and the filtered products
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
     * Show individual product detail page
     * Using route model binding so Laravel automatically finds the product by slug
     * I'm loading all the relationships needed for the page in one go
     */
    public function show(Product $product): View
    {
        // Don't show inactive products - return 404 if someone tries to access them
        abort_unless($product->is_active, 404);

        // Load all the relationships needed for the product detail page
        // This prevents N+1 queries and ensures all data is available in the view
        $product->load([
            'attributes',      // Product specs like metal type, stone size, etc.
            'collection',       // Which collection this belongs to
            'images',           // All product images for gallery
            'reviews.user',     // Reviews with the user who wrote them
            'variants',         // Size options, metal variants, etc.
        ]);

        // Get related products for the "you may also like" section
        // I'm finding products that are either in the same collection or same category
        // This gives customers relevant suggestions without being too obvious
        $relatedProducts = Product::query()
            ->with('primaryImage') // Need the image for the related products grid
            ->where('is_active', true) // Only show active products
            ->whereKeyNot($product->id) // Exclude the current product
            ->where(function ($query) use ($product): void {
                // Either same collection OR same category
                // This gives us a good mix of related items
                $query->where('collection_id', $product->collection_id)
                    ->orWhere('category', $product->category);
            })
            ->orderBy('sort_order') // Respect my manual ordering
            ->limit(4) // Only need 4 for the grid
            ->get();

        // I need to show cart and wishlist counts in the header
        // Even though these are handled by JS, I'm setting the initial values
        // This prevents the count badges from showing 0 on page load

        // Get cart data for the cart count badge
        $cartController = new CartController;
        $items = $cartController->getCartData();
        $cartCount = count($items);

        // Get wishlist data for both count and to check if current product is wishlisted
        $wishlistController = new WishlistController;
        $wishlistItems = $wishlistController->getWishlistData();
        $wishlistCount = $wishlistItems->count();

        // Check if the current product is in the user's wishlist
        // This lets me show the heart icon as filled or outline on page load
        $isWishlisted = $wishlistItems->contains('product_id', $product->id);

        // Pass everything to the product detail view
        // The view needs: the product, related products, cart/wishlist counts, and wishlist status
        return view('product_detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'cartCount' => $cartCount,
            'wishlistCount' => $wishlistCount,
            'isWishlisted' => $isWishlisted,
        ]);
    }

    /**
     * Show all collections page
     * This is like a category page but for curated collections
     */
    public function collections(): View
    {
        // Safety check again - if collections table doesn't exist, show empty page
        if (! Schema::hasTable('collections')) {
            return view('collections', [
                'collections' => collect(),
            ]);
        }

        // Get all active collections with their products
        // I'm eager loading only active products with their primary images
        // This gives me everything I need for the collections grid in one query
        $collections = Collection::query()
            ->with(['products' => fn ($query) => $query->where('is_active', true)->with('primaryImage'),
            ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Pass the collections to the collections view
        return view('collections', [
            'collections' => $collections,
        ]);
    }

    /**
     * Show a single collection with all its products
     * This reuses the shop view but with a collection filter pre-applied
     */
    public function showCollection(string $slug): View
    {
        // Find the collection by slug, or 404 if not found
        // Only return active collections
        $collection = Collection::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        // Get all products in this collection
        // Eager loading the same relationships as in the main shop page
        $products = Product::query()
            ->with(['collection', 'primaryImage', 'images'])
            ->where('is_active', true)
            ->where('collection_id', $collection->id)
            ->orderBy('sort_order')
            ->get();

        // Get cart count for the header badge
        $cartController = new CartController;
        $cartCount = $cartController->cartCount();

        $pageContent = self::COLLECTION_PAGE_CONTENT[$collection->slug] ?? [
            'eyebrow' => strtoupper($collection->name).' COLLECTION',
            'tagline' => 'A curated expression of Lumière craftsmanship.',
            'hero_copy' => $collection->description,
            'story_heading' => 'Crafted with intention',
            'story_body' => $collection->description,
            'trust_points' => ['Handcrafted', 'Ethically sourced', 'Lifetime care'],
            'cta_heading' => 'Need a private recommendation?',
        ];

        return view('collection_show', [
            'collection' => $collection,
            'products' => $products,
            'cartCount' => $cartCount,
            'pageContent' => $pageContent,
        ]);
    }
}
