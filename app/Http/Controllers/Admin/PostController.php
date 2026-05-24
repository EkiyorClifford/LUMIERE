<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->with('category')
            ->latest()
            ->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = PostCategory::query()->orderBy('name')->get();

        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['featured_image'] = $request->file('featured_image')?->store('posts', 'public') ?? '';
        $validated['is_published'] = $request->boolean('publish');
        $validated['published_at'] = $request->boolean('publish') ? now() : null;

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('status', 'Post created.');
    }

    public function edit(Post $post): View
    {
        $categories = PostCategory::query()->orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $this->validatedData($request, $post);
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('publish');
        $validated['published_at'] = $request->boolean('publish') ? ($post->published_at ?? now()) : null;

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('status', 'Post updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Post deleted.');
    }

    /**
     * @return array{title: string, slug: string|null, post_category_id: int|null, volume_label: string|null, excerpt: string, content: string}
     */
    private function validatedData(Request $request, ?Post $post = null): array
    {
        $postId = $post?->id ?? 'NULL';

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,'.$postId],
            'post_category_id' => ['nullable', 'exists:post_categories,id'],
            'volume_label' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['required', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => [$post ? 'nullable' : 'required', 'image', 'max:4096'],
            'publish' => ['nullable', 'boolean'],
        ]);
    }
}
