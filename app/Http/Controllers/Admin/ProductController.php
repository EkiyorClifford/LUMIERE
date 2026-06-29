<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->with(['collection', 'media', 'primaryImage'])
            ->latest()
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $collections = Collection::query()->orderBy('name')->get();
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.create', compact('collections', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $product = Product::create($validated);
        $this->storePrimaryImage($request, $product);
        $this->storeAdditionalImages($request, $product);

        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product): View
    {
        $product->load(['collection', 'images', 'media', 'primaryImage']);
        $collections = Collection::query()->orderBy('name')->get();
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'collections', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validatedData($request, $product);
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $product->update($validated);
        $this->processExistingImages($request, $product);
        $this->storePrimaryImage($request, $product);
        $this->storeAdditionalImages($request, $product);

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->update(['is_active' => false]);

        return redirect()->route('admin.products.index')->with('status', 'Product disabled.');
    }

    public function toggleActive(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        if (! $request->expectsJson()) {
            return back()->with('status', $product->is_active ? 'Product activated.' : 'Product disabled.');
        }

        return response()->json([
            'ok' => true,
            'is_active' => (bool) $product->is_active,
            'label' => $product->is_active ? 'Active' : 'Disabled',
        ]);
    }

    /**
     * @return array{name: string, slug: string|null, collection_id: int|null, category: string, description: string|null, price: numeric, sort_order: int}
     */
    private function validatedData(Request $request, ?Product $product = null): array
    {
        $productId = $product?->id ?? 'NULL';

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,'.$productId],
            'collection_id' => ['nullable', 'exists:collections,id'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:51200'],
            'additional_images' => ['nullable', 'array'],
            'additional_images.*' => ['image', 'max:51200'],
        ]);
    }

    private function storePrimaryImage(Request $request, Product $product): void
    {
        if (! $request->hasFile('image')) {
            return;
        }

        $this->clearPrimaryMedia($product);

        $product
            ->addMedia($request->file('image'))
            ->withCustomProperties(['primary' => true])
            ->setOrder($this->nextMediaSortOrder($product))
            ->toMediaCollection(Product::ProductImagesCollection);
    }

    private function storeAdditionalImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('additional_images')) {
            return;
        }

        $files = array_values(array_filter((array) $request->file('additional_images')));

        if (empty($files)) {
            return;
        }

        $sortOrder = $this->nextMediaSortOrder($product) - 1;

        foreach ($files as $image) {
            $sortOrder++;

            $product
                ->addMedia($image)
                ->withCustomProperties(['primary' => false])
                ->setOrder($sortOrder)
                ->toMediaCollection(Product::ProductImagesCollection);
        }
    }

    private function processExistingImages(Request $request, Product $product): void
    {
        $this->processExistingMedia($request, $product);
        $this->processExistingLegacyImages($request, $product);
        $this->ensurePrimaryMedia($product);
    }

    private function processExistingMedia(Request $request, Product $product): void
    {
        foreach ((array) $request->input('delete_media', []) as $mediaId) {
            $this->findProductMedia($product, (int) $mediaId)?->delete();
        }

        foreach ((array) $request->file('replace_media', []) as $mediaId => $file) {
            if (! $file) {
                continue;
            }

            $media = $this->findProductMedia($product, (int) $mediaId);
            if (! $media) {
                continue;
            }

            $sortOrder = $media->order_column;
            $customProperties = $media->custom_properties;
            $media->delete();

            $product
                ->addMedia($file)
                ->withCustomProperties($customProperties)
                ->setOrder($sortOrder)
                ->toMediaCollection(Product::ProductImagesCollection);
        }

        if ($primaryMediaId = $request->integer('primary_media_id')) {
            $this->markMediaAsPrimary($product, $primaryMediaId);
        }
    }

    private function processExistingLegacyImages(Request $request, Product $product): void
    {
        foreach ((array) $request->input('delete_images', []) as $imageId) {
            $image = $product->images()->whereKey($imageId)->first();
            if (! $image) {
                continue;
            }

            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Replace selected image files
        foreach ((array) $request->file('replace_images', []) as $imageId => $file) {
            if (! $file) {
                continue;
            }

            $image = $product->images()->whereKey($imageId)->first();
            if (! $image) {
                continue;
            }

            Storage::disk('public')->delete($image->image_path);
            $image->update(['image_path' => $file->store('products', 'public')]);
        }

        // Promote selected existing image to primary
        $primaryImageId = $request->input('primary_image_id');
        if ($primaryImageId) {
            $primaryImage = $product->images()->whereKey($primaryImageId)->first();
            if ($primaryImage) {
                $product->images()->update(['is_primary' => false]);
                $primaryImage->update(['is_primary' => true, 'sort_order' => 0]);
            }
        }
    }

    private function nextMediaSortOrder(Product $product): int
    {
        return ((int) $product->getMedia(Product::ProductImagesCollection)->max('order_column')) + 1;
    }

    private function clearPrimaryMedia(Product $product): void
    {
        $product->getMedia(Product::ProductImagesCollection)->each(function (Media $media): void {
            $media->setCustomProperty('primary', false)->save();
        });
    }

    private function markMediaAsPrimary(Product $product, int $mediaId): void
    {
        $media = $this->findProductMedia($product, $mediaId);
        if (! $media) {
            return;
        }

        $this->clearPrimaryMedia($product);
        $media->setCustomProperty('primary', true)->save();
    }

    private function ensurePrimaryMedia(Product $product): void
    {
        $media = $product->getMedia(Product::ProductImagesCollection);
        if ($media->isEmpty() || $media->contains(fn (Media $media): bool => (bool) $media->getCustomProperty('primary', false))) {
            return;
        }

        $media->first()?->setCustomProperty('primary', true)->save();
    }

    private function findProductMedia(Product $product, int $mediaId): ?Media
    {
        return $product
            ->getMedia(Product::ProductImagesCollection)
            ->first(fn (Media $media): bool => $media->id === $mediaId);
    }
}
