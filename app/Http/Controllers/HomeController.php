<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(): View
    {
        if (! Schema::hasTable('products')) {
            return view('welcome', [
                'featuredProducts' => collect(),
            ]);
        }

        $featuredProducts = Product::query()
            ->with(['collection', 'media', 'primaryImage'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        return view('welcome', [
            'featuredProducts' => $featuredProducts,
        ]);
    }

    public function atelier(): View
    {
        return view('atelier');
    }
}
