<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Product;
use App\Services\CartService;
use App\Services\CollectionContentService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CollectionPageController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private CollectionContentService $contentService,
    ) {}

    /**
     * Show a single luxury editorial collection lookbook.
     */
    public function show(string $slug): View
    {
        if (! Schema::hasTable('collections')) {
            abort(404);
        }

        // 1. Fetch collection along with pre-loaded Spatie media assets
        $collection = Collection::query()
            ->with(['media'])
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        // 2. Fetch associated products to prevent N+1 queries in product grids
        $products = Product::query()
            ->with(['collection', 'images', 'media', 'primaryImage'])
            ->where('is_active', true)
            ->where('collection_id', $collection->id)
            ->orderBy('sort_order')
            ->get();

        $cartCount = $this->cartService->cartCount();
        $content = $this->contentService->getBySlug($collection->slug);

        // 3. Build legacy fallback content state
        $pageContent = [
            'eyebrow' => strtoupper($collection->name).' COLLECTION',
            'tagline' => 'A curated expression of Lumière craftsmanship.',
            'hero_copy' => $collection->description,
            'story_heading' => 'Crafted with intention',
            'story_body' => $collection->description,
            'trust_points' => ['Handcrafted', 'Ethically sourced', 'Lifetime care'],
            'cta_heading' => 'Need a private recommendation?',
            'hero_image' => $collection->cover_image ?: 'images/diamond_bracelet_paris_night.png',
        ];

        if ($content) {
            $pageContent = [
                'eyebrow' => strtoupper($content->title).' COLLECTION',
                'tagline' => $content->title,
                'hero_copy' => Str::of($content->description)->stripTags()->toString(),
                'story_heading' => $content->title,
                'story_body' => $content->description,
                'trust_points' => ['Handcrafted', 'Ethically sourced', 'Lifetime care'],
                'cta_heading' => $content->meta_description ?: 'Need a private recommendation?',
                'hero_image' => $content->image_url ?: ($collection->cover_image ?: 'images/diamond_bracelet_paris_night.png'),
            ];
        }

        // 4. HYBRID FALLBACK: Convert legacy records to dynamic layout structures on the fly
        $sections = $collection->section_order;

        if (empty($sections)) {
            $sections = [
                [
                    'type' => 'hero',
                    'layout' => 'full-cover',
                    'title' => $pageContent['eyebrow'],
                    'subtitle' => $pageContent['tagline'],
                    'legacy_image' => $pageContent['hero_image'], // Used if no Spatie ID exists yet
                ],
                [
                    'type' => 'story-block',
                    'layout' => 'split-narrative',
                    'heading' => $pageContent['story_heading'],
                    'text' => $pageContent['story_body'],
                    'alignment' => 'left',
                ],
                [
                    'type' => 'product-grid',
                    'layout' => 'editorial-feed',
                ],
            ];

            // Cast back to object/array format to align perfectly with the rendering loop
            $collection->section_order = $sections;
        }

        return view('collection_show', [
            'collection' => $collection,
            'products' => $products,
            'cartCount' => $cartCount,
            'pageContent' => $pageContent,
            'collectionContent' => $content,
        ]);
    }
}
