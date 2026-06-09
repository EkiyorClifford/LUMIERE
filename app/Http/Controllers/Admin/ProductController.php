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

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->with(['collection', 'primaryImage'])
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
        $product->load(['collection', 'primaryImage']);
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
            'image' => ['nullable', 'image', 'max:4096'],
            'additional_images' => ['nullable', 'array'],
            'additional_images.*' => ['image', 'max:4096'],
        ]);
    }

    private function storePrimaryImage(Request $request, Product $product): void
    {
        if (! $request->hasFile('image')) {
            return;
        }

        $path = $request->file('image')->store('products', 'public');

        $product->images()->update(['is_primary' => false]);
        $product->images()->create([
            'image_path' => $path,
            'is_primary' => true,
            'sort_order' => 0,
        ]);
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

        $sortOrder = $product->images()->max('sort_order') ?? 0;

        foreach ($files as $image) {
            $path = $image->store('products', 'public');
            $sortOrder++;

            $product->images()->create([
                'image_path' => $path,
                'is_primary' => false,
                'sort_order' => $sortOrder,
            ]);
        }
    }

    private function processExistingImages(Request $request, Product $product): void
    {
        // Delete selected images
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
}
