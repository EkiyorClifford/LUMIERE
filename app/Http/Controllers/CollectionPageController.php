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
     * Show a single collection page with its featured story and products.
     *
     * The page stays data-driven: the base `collections` table supplies the
     * collection record, while `collection_contents` can override the editorial
     * copy and hero image when content exists for the same slug.
     */
    public function show(string $slug): View
    {
        if (! Schema::hasTable('collections')) {
            abort(404);
        }

        $collection = Collection::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $products = Product::query()
            ->with(['collection', 'primaryImage', 'images'])
            ->where('is_active', true)
            ->where('collection_id', $collection->id)
            ->orderBy('sort_order')
            ->get();

        $cartCount = $this->cartService->cartCount();
        $content = $this->contentService->getBySlug($collection->slug);

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
                'trust_points' => [
                    'Handcrafted',
                    'Ethically sourced',
                    'Lifetime care',
                ],
                'cta_heading' => $content->meta_description ?: 'Need a private recommendation?',
                'hero_image' => $content->image_url ?: ($collection->cover_image ?: 'images/diamond_bracelet_paris_night.png'),
            ];
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
