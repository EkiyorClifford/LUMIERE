<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $categories = PostCategory::all();
        $featured = $posts->count() > 0 ? $posts->first() : null;

        return view('editorial', compact('posts', 'categories', 'featured'));
    }

    public function show($slug)
    {
        $post = Post::with(['category', 'comments' => function ($query) {
            $query->where('is_approved', true)->orderBy('created_at', 'desc');
        }])
            ->where('slug', $slug)
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $relatedPosts = Post::with('category')
            ->where('post_category_id', $post->post_category_id)
            ->where('id', '!=', $post->id)
            ->where('published_at', '<=', now())
            ->take(3)
            ->get();

        return view('post-detail', compact('post', 'relatedPosts'));
    }

    public function category($slug)
    {
        $category = PostCategory::where('slug', $slug)->firstOrFail();

        $posts = Post::with('category')
            ->where('post_category_id', $category->id)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $categories = PostCategory::all();
        $featured = $posts->count() > 0 ? $posts->first() : null;

        return view('editorial', compact('posts', 'categories', 'category', 'featured'));
    }
}
