<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionContent;
use App\Services\CollectionContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'meta_description' => 'nullable|string|max:160',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

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
            'meta_description' => 'nullable|string|max:160',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $collectionContent->update($validated);

        return redirect()->route('admin.collection-contents.index')
            ->with('success', 'Collection content updated successfully.');
    }

    public function destroy(CollectionContent $collectionContent): RedirectResponse
    {
        $collectionContent->delete();

        return redirect()->route('admin.collection-contents.index')
            ->with('success', 'Collection content deleted successfully.');
    }

    public function toggleActive(CollectionContent $collectionContent): RedirectResponse
    {
        $this->contentService->toggleActive($collectionContent->slug);

        return redirect()->back()->with('success', 'Collection status updated.');
    }
}
