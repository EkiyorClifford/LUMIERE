<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        $collections = Collection::query()
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.collections.index', compact('collections'));
    }
}
