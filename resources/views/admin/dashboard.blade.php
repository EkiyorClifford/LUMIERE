{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'LUMIÈRE — Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <p class="stat-label">TOTAL PRODUCTS</p>
            <p class="stat-value">{{ number_format($stats['total_products']) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">TOTAL ORDERS</p>
            <p class="stat-value">{{ number_format($stats['total_orders']) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">TOTAL REVENUE</p>
            <p class="stat-value">${{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">CLIENTS</p>
            <p class="stat-value">{{ number_format($stats['total_users']) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">PENDING ORDERS</p>
            <p class="stat-value">{{ number_format($stats['pending_orders']) }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">PUBLISHED POSTS</p>
            <p class="stat-value">{{ number_format($stats['published_posts']) }}</p>
        </div>
    </div>

    <div class="two-col">
        <div class="card">
            <div class="card-head">
                <h2 class="card-title">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">VIEW ALL</a>
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>ORDER</th>
                            <th>CLIENT</th>
                            <th>TOTAL</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                            <tr>
                                <td>{{ $order->order_number ?? '#'.$order->id }}</td>
                                <td>{{ $order->user?->name ?? 'Guest' }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>{{ ucfirst($order->order_status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">NO ORDERS YET</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <h2 class="card-title">Top Products</h2>
                <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">VIEW ALL</a>
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>COLLECTION</th>
                            <th>ORDERS</th>
                            <th>PRICE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->collection?->name ?? 'Unassigned' }}</td>
                                <td>{{ $product->order_items_count }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">NO PRODUCTS YET</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
