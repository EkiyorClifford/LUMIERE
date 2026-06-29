<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::sum('total'),
            'total_users' => User::count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'published_posts' => Post::whereNotNull('published_at')->count(),
        ];

        $recentOrders = Order::query()
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        $topProducts = Product::query()
            ->with(['collection', 'media', 'primaryImage'])
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}
