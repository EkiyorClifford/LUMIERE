<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'posts' => Post::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function products()
    {
        $products = Product::with('category', 'collection')->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function orders()
    {
        $orders = Order::with('user')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function posts()
    {
        $posts = Post::with('category')->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }
}
