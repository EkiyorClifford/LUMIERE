@extends('layouts.app')

@section('content')
<div class="checkout-success-container">
    <div class="success-inner">
        <!-- Success Icon -->
        <div class="success-icon">
            <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="40" cy="40" r="38" fill="none" stroke="#C9A84C" stroke-width="0.8" stroke-dasharray="3 4"/>
                <circle cx="40" cy="40" r="30" fill="#C9A84C" opacity="0.08"/>
                <circle cx="40" cy="40" r="22" fill="none" stroke="#C9A84C" stroke-width="0.6"/>
                <text x="40" y="37" text-anchor="middle" font-family="Cormorant Garamond, serif" font-size="9" fill="#C9A84C" letter-spacing="2" font-style="italic">LUMIÈRE</text>
                <path d="M29 45 L36 52 L52 36" stroke="#C9A84C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" opacity="0.8"/>
            </svg>
        </div>

        <!-- Success Message -->
        <div class="success-content">
            <span class="success-eyebrow">ORDER CONFIRMED</span>
            <h1 class="success-title">Merci,<br>Your Piece Awaits</h1>
            <div class="success-rule"></div>
            <p class="success-body">
                Your order has been received and our atelier is preparing it with care.<br>
                A confirmation has been sent to your email address.
            </p>
            <div class="order-reference">
                ORDER REFERENCE &nbsp;·&nbsp; <strong>{{ $order->order_number }}</strong>
            </div>
        </div>

        <!-- Order Details -->
        <div class="order-details">
            <h3 class="details-title">Order Summary</h3>
            
            <div class="order-items">
                @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="item-info">
                            <div class="item-name">{{ $item->product->name }}</div>
                            @if($item->variant)
                                <div class="item-variant">{{ $item->variant->name }}</div>
                            @endif
                            <div class="item-quantity">Quantity: {{ $item->quantity }}</div>
                        </div>
                        <div class="item-price">
                            ${{ number_format($item->price * $item->quantity, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="order-totals">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->total / 1.08, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Shipping</span>
                    <span>FREE</span>
                </div>
                <div class="total-row">
                    <span>Tax</span>
                    <span>${{ number_format($order->total - ($order->total / 1.08), 2) }}</span>
                </div>
                <div class="total-row grand">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <div class="shipping-info">
                <h4>Shipping Information</h4>
                <p>
                    <strong>{{ $order->shipping_full_name }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                    {{ $order->shipping_country }}
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="success-actions">
            <a href="{{ route('home') }}" class="btn-primary">RETURN TO LUMIÈRE</a>
            <a href="{{ route('profile.orders') }}" class="btn-secondary">VIEW MY ORDERS</a>
        </div>

        <!-- Next Steps -->
        <div class="next-steps">
            <h3>What's Next?</h3>
            <div class="steps-list">
                <div class="step-item">
                    <div class="step-icon">
                        <i class="fa-solid fa-hammer"></i>
                    </div>
                    <div class="step-content">
                        <h4>Artisan Preparation</h4>
                        <p>Our atelier is carefully preparing your piece with exceptional attention to detail.</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-icon">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <div class="step-content">
                        <h4>Quality Assurance</h4>
                        <p>Each piece undergoes rigorous quality control before packaging.</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-icon">
                        <i class="fa-solid fa-truck"></i>
                    </div>
                    <div class="step-content">
                        <h4>Secure Delivery</h4>
                        <p>Your order will be shipped within 7-10 business days with tracking information.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

.checkout-success-container {
    min-height: 100vh;
    background: var(--cream);
    padding: 60px 20px;
}

.success-inner {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.success-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 40px;
    animation: sealPop 0.6s cubic-bezier(0.34,1.56,0.64,1) 0.4s both;
}

@keyframes sealPop {
    from { transform: scale(0) rotate(-20deg); opacity: 0; }
    to   { transform: scale(1) rotate(0); opacity: 1; }
}

.success-eyebrow {
    font-size: 0.7rem;
    letter-spacing: 0.35em;
    color: var(--gold);
    font-weight: 300;
    display: block;
    margin-bottom: 16px;
}

.success-title {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-weight: 300;
    font-size: 3.2rem;
    line-height: 1.15;
    color: var(--charcoal);
    margin-bottom: 20px;
}

.success-rule {
    width: 60px;
    height: 1px;
    background: var(--gold);
    margin: 0 auto 24px;
}

.success-body {
    font-size: 1rem;
    color: var(--warm-gray);
    font-weight: 300;
    line-height: 1.7;
    margin-bottom: 32px;
    letter-spacing: 0.02em;
}

.order-reference {
    display: inline-block;
    background: var(--ivory);
    padding: 12px 24px;
    font-size: 0.7rem;
    letter-spacing: 0.2em;
    color: var(--charcoal);
    margin-bottom: 48px;
    font-weight: 300;
    border-radius: 4px;
}

.order-reference strong { 
    color: var(--gold); 
    font-weight: 400; 
}

.order-details {
    background: white;
    padding: 40px;
    border-radius: 12px;
    text-align: left;
    margin-bottom: 40px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.details-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    color: var(--charcoal);
    margin-bottom: 24px;
    text-align: center;
}

.order-items {
    margin-bottom: 32px;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 16px 0;
    border-bottom: 1px solid var(--border);
}

.order-item:last-child {
    border-bottom: none;
}

.item-name {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: var(--charcoal);
    margin-bottom: 4px;
}

.item-variant {
    font-size: 0.9rem;
    color: var(--warm-gray);
    margin-bottom: 2px;
}

.item-quantity {
    font-size: 0.85rem;
    color: var(--warm-gray);
}

.item-price {
    font-size: 1rem;
    color: var(--charcoal);
    font-weight: 300;
}

.order-totals {
    border-top: 1px solid var(--border);
    padding-top: 20px;
    margin-bottom: 24px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 0.95rem;
}

.total-row.grand {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 400;
    padding-top: 12px;
    border-top: 2px solid var(--gold);
    margin-top: 8px;
}

.shipping-info h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: var(--charcoal);
    margin-bottom: 12px;
}

.shipping-info p {
    color: var(--warm-gray);
    line-height: 1.6;
    font-size: 0.95rem;
}

.success-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    margin-bottom: 48px;
    flex-wrap: wrap;
}

.btn-primary, .btn-secondary {
    padding: 16px 32px;
    font-family: 'Jost', sans-serif;
    font-size: 0.7rem;
    letter-spacing: 0.24em;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s;
    cursor: pointer;
    display: inline-block;
}

.btn-primary {
    background: var(--gold);
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #A8862E;
    transform: translateY(-1px);
}

.btn-secondary {
    background: transparent;
    color: var(--charcoal);
    border: 1px solid var(--border-md);
}

.btn-secondary:hover {
    background: var(--charcoal);
    color: white;
}

.next-steps {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.next-steps h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    color: var(--charcoal);
    margin-bottom: 32px;
    text-align: center;
}

.steps-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 32px;
}

.step-item {
    text-align: center;
}

.step-icon {
    width: 60px;
    height: 60px;
    background: var(--gold-dim);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 1.2rem;
    color: var(--gold);
}

.step-content h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: var(--charcoal);
    margin-bottom: 8px;
}

.step-content p {
    color: var(--warm-gray);
    font-size: 0.9rem;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .success-title {
        font-size: 2.4rem;
    }
    
    .order-details {
        padding: 24px;
    }
    
    .success-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-primary, .btn-secondary {
        width: 100%;
        max-width: 300px;
    }
    
    .steps-list {
        grid-template-columns: 1fr;
        gap: 24px;
    }
}
</style>
@endpush
