@extends('layouts.app')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1 class="profile-title">My Orders</h1>
        <p class="profile-subtitle">View and track your LUMIÈRE orders</p>
    </div>

    @if($orders->count() > 0)
        <div class="orders-grid">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3 class="order-number">{{ $order->order_number }}</h3>
                            <p class="order-date">{{ $order->created_at->format('F j, Y') }}</p>
                        </div>
                        <div class="order-status">
                            <span class="status-badge status-{{ $order->order_status }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </div>
                    </div>

                    <div class="order-items">
                        @foreach($order->items->take(2) as $item)
                            <div class="order-item">
                                @if($item->product && $item->product->images->first())
                                    <img src="{{ $item->product->images->first()->image_url }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="item-image">
                                @else
                                    <div class="item-image placeholder">
                                        <i class="fa-regular fa-image"></i>
                                    </div>
                                @endif
                                <div class="item-details">
                                    <h4>{{ $item->product->name }}</h4>
                                    @if($item->variant)
                                        <p class="item-variant">{{ $item->variant->name }}</p>
                                    @endif
                                    <p class="item-quantity">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="item-price">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </div>
                            </div>
                        @endforeach
                        
                        @if($order->items->count() > 2)
                            <div class="more-items">
                                +{{ $order->items->count() - 2 }} more item(s)
                            </div>
                        @endif
                    </div>

                    <div class="order-footer">
                        <div class="order-total">
                            <span class="total-label">Total:</span>
                            <span class="total-amount">${{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="order-actions">
                            <button class="btn-view-order" onclick="toggleOrderDetails('order-details-{{ $order->id }}')">
                                View Details
                            </button>
                            @if($order->shipment && $order->shipment->tracking_number)
                                <a href="#" class="btn-track">Track Order</a>
                            @endif
                        </div>
                    </div>

                    <!-- Hidden Order Details -->
                    <div class="order-details" id="order-details-{{ $order->id }}" style="display: none;">
                        <div class="details-section">
                            <h4>Order Items</h4>
                            @foreach($order->items as $item)
                                <div class="detail-item">
                                    <div class="detail-item-info">
                                        <h5>{{ $item->product->name }}</h5>
                                        @if($item->variant)
                                            <p>{{ $item->variant->name }}</p>
                                        @endif
                                        <p>Quantity: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="detail-item-price">
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="details-section">
                            <h4>Shipping Information</h4>
                            <p>
                                <strong>{{ $order->shipping_full_name }}</strong><br>
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                                {{ $order->shipping_country }}
                            </p>
                        </div>

                        <div class="details-section">
                            <h4>Payment Information</h4>
                            <p>
                                Payment Method: {{ ucfirst($order->payment->payment_method ?? 'Card') }}<br>
                                Status: {{ ucfirst($order->payment->status ?? 'Pending') }}
                            </p>
                        </div>

                        @if($order->shipment)
                            <div class="details-section">
                                <h4>Tracking Information</h4>
                                <p>
                                    Status: {{ ucfirst($order->shipment->status) }}<br>
                                    @if($order->shipment->tracking_number)
                                        Tracking Number: {{ $order->shipment->tracking_number }}<br>
                                    @endif
                                    Estimated Delivery: {{ $order->shipment->estimated_delivery->format('F j, Y') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-regular fa-box-open"></i>
            </div>
            <h2>No Orders Yet</h2>
            <p>You haven't placed any orders yet. Start shopping to see your order history here.</p>
            <a href="{{ route('shop') }}" class="btn-primary">Start Shopping</a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
:root {
    --gold: #C9A84C;
    --gold-light: #E8C97A;
    --gold-dim: rgba(201,168,76,0.12);
    --cream: #F9F6F0;
    --ivory: #F2EDE4;
    --charcoal: #1C1C1C;
    --warm-gray: #8A8580;
    --border: rgba(28,28,28,0.10);
    --border-md: rgba(28,28,28,0.14);
}

.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

.profile-header {
    text-align: center;
    margin-bottom: 48px;
}

.profile-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    color: var(--charcoal);
    margin-bottom: 8px;
}

.profile-subtitle {
    color: var(--warm-gray);
    font-size: 1.1rem;
    margin: 0;
}

.orders-grid {
    display: grid;
    gap: 32px;
}

.order-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 32px;
    border-bottom: 1px solid var(--border);
    background: var(--ivory);
}

.order-number {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    color: var(--charcoal);
    margin: 0 0 4px 0;
}

.order-date {
    color: var(--warm-gray);
    font-size: 0.9rem;
    margin: 0;
}

.status-badge {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    letter-spacing: 0.05em;
}

.status-pending {
    background: var(--gold-dim);
    color: var(--gold);
}

.status-confirmed {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
}

.status-processing {
    background: rgba(52, 152, 219, 0.1);
    color: #3498db;
}

.status-shipped {
    background: rgba(155, 89, 182, 0.1);
    color: #9b59b6;
}

.status-delivered {
    background: rgba(46, 204, 113, 0.1);
    color: #2ecc71;
}

.order-items {
    padding: 24px 32px;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 16px;
}

.order-item:last-child {
    margin-bottom: 0;
}

.item-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
}

.item-image.placeholder {
    background: var(--ivory);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--warm-gray);
    font-size: 1.2rem;
}

.item-details {
    flex: 1;
}

.item-details h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: var(--charcoal);
    margin: 0 0 4px 0;
}

.item-variant, .item-quantity {
    color: var(--warm-gray);
    font-size: 0.85rem;
    margin: 2px 0;
}

.item-price {
    font-size: 1rem;
    color: var(--charcoal);
    font-weight: 300;
}

.more-items {
    color: var(--warm-gray);
    font-size: 0.85rem;
    font-style: italic;
    text-align: center;
    padding: 8px 0;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 32px;
    border-top: 1px solid var(--border);
    background: var(--ivory);
}

.order-total {
    display: flex;
    align-items: center;
    gap: 8px;
}

.total-label {
    color: var(--warm-gray);
    font-size: 0.9rem;
}

.total-amount {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    color: var(--charcoal);
    font-weight: 400;
}

.order-actions {
    display: flex;
    gap: 12px;
}

.btn-view-order, .btn-track {
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-family: 'Jost', sans-serif;
    letter-spacing: 0.05em;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
}

.btn-view-order {
    background: var(--charcoal);
    color: white;
}

.btn-view-order:hover {
    background: #2C2C2C;
}

.btn-track {
    background: transparent;
    color: var(--gold);
    border: 1px solid var(--gold);
}

.btn-track:hover {
    background: var(--gold);
    color: white;
}

.order-details {
    padding: 32px;
    border-top: 1px solid var(--border);
    background: var(--cream);
}

.details-section {
    margin-bottom: 32px;
}

.details-section:last-child {
    margin-bottom: 0;
}

.details-section h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    color: var(--charcoal);
    margin-bottom: 16px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item-info h5 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: var(--charcoal);
    margin: 0 0 4px 0;
}

.detail-item-info p {
    color: var(--warm-gray);
    font-size: 0.85rem;
    margin: 2px 0;
}

.detail-item-price {
    font-size: 1rem;
    color: var(--charcoal);
    font-weight: 300;
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-icon {
    font-size: 4rem;
    color: var(--warm-gray);
    margin-bottom: 24px;
}

.empty-state h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    color: var(--charcoal);
    margin-bottom: 12px;
}

.empty-state p {
    color: var(--warm-gray);
    font-size: 1.1rem;
    margin-bottom: 32px;
}

.btn-primary {
    display: inline-block;
    background: var(--gold);
    color: white;
    padding: 16px 32px;
    border-radius: 6px;
    text-decoration: none;
    font-family: 'Jost', sans-serif;
    font-size: 0.9rem;
    letter-spacing: 0.1em;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #A8862E;
    transform: translateY(-1px);
}

.pagination {
    margin-top: 48px;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .profile-container {
        padding: 40px 16px;
    }
    
    .profile-title {
        font-size: 2rem;
    }
    
    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
        padding: 20px;
    }
    
    .order-items {
        padding: 20px;
    }
    
    .order-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
        padding: 20px;
    }
    
    .order-actions {
        width: 100%;
    }
    
    .btn-view-order, .btn-track {
        flex: 1;
        text-align: center;
    }
    
    .order-details {
        padding: 20px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function toggleOrderDetails(elementId) {
    const details = document.getElementById(elementId);
    const button = event.target;
    
    if (details.style.display === 'none') {
        details.style.display = 'block';
        button.textContent = 'Hide Details';
    } else {
        details.style.display = 'none';
        button.textContent = 'View Details';
    }
}
</script>
@endpush
