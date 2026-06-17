<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionContent;
use App\Services\CollectionContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CollectionContentController extends Controller
{
    public function __construct(
        private CollectionContentService $contentService,
    ) {}

    public function index(): View
    {
        $contents = CollectionContent::orderBy('slug')->get();

        return view('admin.collection-contents.index', compact('contents'));
    }

    public function create(): View
    {
        return view('admin.collection-contents.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:collection_contents,slug',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'image' => 'nullable|image|max:4096',
            'meta_description' => 'nullable|string|max:160',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['description'] = $this->sanitizeRichText($validated['description']);
        $validated['image_url'] = $this->uploadedImageUrl($request) ?? ($validated['image_url'] ?? null);
        unset($validated['image']);

        $this->contentService->createOrUpdate($validated);

        return redirect()->route('admin.collection-contents.index')
            ->with('success', 'Collection content created successfully.');
    }

    public function edit(CollectionContent $collectionContent): View
    {
        return view('admin.collection-contents.edit', ['content' => $collectionContent]);
    }

    public function update(Request $request, CollectionContent $collectionContent): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'image' => 'nullable|image|max:4096',
            'meta_description' => 'nullable|string|max:160',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['description'] = $this->sanitizeRichText($validated['description']);

        if ($uploadedImageUrl = $this->uploadedImageUrl($request)) {
            $this->deleteStoredImage($collectionContent->image_url);
            $validated['image_url'] = $uploadedImageUrl;
        }

        unset($validated['image']);

        $collectionContent->update($validated);

        return redirect()->route('admin.collection-contents.index')
            ->with('success', 'Collection content updated successfully.');
    }

    public function destroy(CollectionContent $collectionContent): RedirectResponse
    {
        $this->deleteStoredImage($collectionContent->image_url);
        $collectionContent->delete();

        return redirect()->route('admin.collection-contents.index')
            ->with('success', 'Collection content deleted successfully.');
    }

    public function toggleActive(CollectionContent $collectionContent): RedirectResponse
    {
        $this->contentService->toggleActive($collectionContent->slug);

        return redirect()->back()->with('success', 'Collection status updated.');
    }

    private function uploadedImageUrl(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        return Storage::disk('public')->url(
            $request->file('image')->store('collection-contents', 'public')
        );
    }

    private function deleteStoredImage(?string $imageUrl): void
    {
        if (! $imageUrl || ! str_starts_with($imageUrl, '/storage/')) {
            return;
        }

        Storage::disk('public')->delete(substr($imageUrl, strlen('/storage/')));
    }

    private function sanitizeRichText(string $value): string
    {
        return strip_tags($value, '<p><br><strong><b><em><i><ul><ol><li><a><h2><h3><blockquote>');
    }
}
