@extends('layouts.app')

@section('content')
<div class="checkout-layout">
    <!-- Left Panel - Form -->
    <div class="form-panel">
        <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <!-- Step 1: Contact Information -->
            <div class="acc-section">
                <div class="acc-header">
                    <div class="acc-left">
                        <div class="acc-num active">1</div>
                        <div>
                            <div class="acc-title active">Contact Information</div>
                        </div>
                    </div>
                </div>
                <div class="acc-body open">
                    <div class="acc-body-inner">
                        <div class="grid-2">
                            <div class="field-group">
                                <label class="field-label">FIRST NAME *</label>
                                <div class="field-wrap">
                                    <input type="text" name="shipping_full_name" class="lux-input" value="{{ Auth::user()->name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="field-label">EMAIL *</label>
                                <div class="field-wrap">
                                    <input type="email" class="lux-input" value="{{ Auth::user()->email ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Shipping Address -->
            <div class="acc-section">
                <div class="acc-header">
                    <div class="acc-left">
                        <div class="acc-num">2</div>
                        <div>
                            <div class="acc-title">Shipping Address</div>
                        </div>
                    </div>
                </div>
                <div class="acc-body">
                    <div class="acc-body-inner">
                        <div class="field-group">
                            <label class="field-label">ADDRESS *</label>
                            <div class="field-wrap">
                                <input type="text" name="shipping_address" class="lux-input" placeholder="123 Main St" required>
                            </div>
                        </div>
                        
                        <div class="grid-3">
                            <div class="field-group">
                                <label class="field-label">CITY *</label>
                                <div class="field-wrap">
                                    <input type="text" name="shipping_city" class="lux-input" placeholder="New York" required>
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="field-label">STATE *</label>
                                <div class="field-wrap">
                                    <input type="text" name="shipping_state" class="lux-input" placeholder="NY" required>
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="field-label">ZIP CODE *</label>
                                <div class="field-wrap">
                                    <input type="text" name="shipping_postal_code" class="lux-input" placeholder="10001" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field-group">
                            <label class="field-label">COUNTRY *</label>
                            <div class="field-wrap">
                                <select name="shipping_country" class="lux-select" required>
                                    <option value="">Select Country</option>
                                    <option value="US" selected>United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="UK">United Kingdom</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Payment -->
            <div class="acc-section">
                <div class="acc-header">
                    <div class="acc-left">
                        <div class="acc-num">3</div>
                        <div>
                            <div class="acc-title">Payment Method</div>
                        </div>
                    </div>
                </div>
                <div class="acc-body">
                    <div class="acc-body-inner">
                        <div class="pay-tabs">
                            <button type="button" class="pay-tab active" data-method="stripe">
                                <i class="fa-brands fa-cc-stripe"></i>
                                Credit Card
                            </button>
                            <button type="button" class="pay-tab" data-method="paypal">
                                <i class="fa-brands fa-paypal"></i>
                                PayPal
                            </button>
                        </div>

                        <div id="stripe-payment">
                            <div class="card-visual-wrap">
                                <div class="card-visual" id="card-visual">
                                    <div class="card-face card-front">
                                        <div class="card-chip"></div>
                                        <div class="card-number-disp" id="card-display">•••• •••• •••• ••••</div>
                                        <div class="card-bottom">
                                            <div>
                                                <div class="card-holder-label">CARD HOLDER</div>
                                                <div class="card-holder-name" id="holder-display">{{ Auth::user()->name ?? 'YOUR NAME' }}</div>
                                            </div>
                                            <div class="card-brand-logo">LUMIÈRE</div>
                                        </div>
                                    </div>
                                    <div class="card-face card-back">
                                        <div class="cvv-strip"></div>
                                        <div class="cvv-box">
                                            <span class="cvv-label">CVV</span>
                                            <span class="cvv-val" id="cvv-display">•••</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field-group">
                                <label class="field-label">CARD NUMBER *</label>
                                <div class="field-wrap">
                                    <i class="fa-regular fa-credit-card"></i>
                                    <input type="text" name="card_number" class="lux-input card-num-field" placeholder="1234 5678 9012 3456" maxlength="19" required>
                                </div>
                            </div>
                            
                            <div class="grid-2">
                                <div class="field-group">
                                    <label class="field-label">EXPIRY DATE *</label>
                                    <div class="field-wrap">
                                        <i class="fa-regular fa-calendar"></i>
                                        <input type="text" name="card_expiry" class="lux-input" placeholder="MM/YY" maxlength="5" required>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">CVC *</label>
                                    <div class="field-wrap">
                                        <i class="fa-solid fa-lock"></i>
                                        <input type="text" name="card_cvc" class="lux-input" placeholder="123" maxlength="4" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="paypal-payment" style="display: none;">
                            <div style="text-align: center; padding: 40px; border: 1px solid var(--border-md); border-radius: 8px;">
                                <i class="fa-brands fa-paypal" style="font-size: 3rem; color: var(--gold); margin-bottom: 16px;"></i>
                                <p style="color: var(--warm-gray); font-size: 0.9rem;">You will be redirected to PayPal to complete your payment.</p>
                            </div>
                        </div>

                        <input type="hidden" name="payment_method" value="stripe" id="payment-method">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-continue">
                <span>PLACE ORDER</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
    </div>

    <!-- Right Panel - Order Summary -->
    <div class="order-panel">
        <h3 class="order-title">Order Summary</h3>
        
        <div class="order-items">
            @foreach($cartItems as $item)
                <div class="order-item">
                    <div class="item-img-wrap">
                        @if($item->product && $item->product->images->first())
                            <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product->name }}" class="item-img">
                        @else
                            <div class="item-img" style="background: var(--ivory); display: flex; align-items: center; justify-content: center;">
                                <i class="fa-regular fa-image" style="color: var(--warm-gray);"></i>
                            </div>
                        @endif
                        <div class="item-qty">{{ $item->quantity }}</div>
                    </div>
                    <div>
                        <div class="item-name">{{ $item->product?->name ?? 'Product' }}</div>
                        @if($item->variant)
                            <div class="item-variant">{{ $item->variant->name }}</div>
                        @endif
                    </div>
                    <div class="item-price">
                        ${{ number_format(($item->variant?->price ?? $item->product?->price ?? 0) * $item->quantity, 2) }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="promo-wrap">
            <input type="text" class="promo-input" placeholder="Promo code">
            <button class="promo-btn">APPLY</button>
        </div>
        <div class="promo-success">Promo code applied!</div>

        <div class="totals">
            <div class="total-row">
                <span class="total-label">SUBTOTAL</span>
                <span class="total-value">${{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="total-row">
                <span class="total-label">SHIPPING</span>
                <span class="total-value">FREE</span>
            </div>
            <div class="total-row">
                <span class="total-label">TAX</span>
                <span class="total-value">${{ number_format($tax, 2) }}</span>
            </div>
            <div class="total-row grand">
                <span class="total-label">TOTAL</span>
                <span class="total-value">${{ number_format($total, 2) }}</span>
            </div>
        </div>

        <div class="trust-badges">
            <div class="trust-badge">
                <i class="fa-solid fa-lock"></i>
                <span>SECURE</span>
            </div>
            <div class="trust-badge">
                <i class="fa-solid fa-truck"></i>
                <span>FREE SHIPPING</span>
            </div>
            <div class="trust-badge">
                <i class="fa-solid fa-rotate-left"></i>
                <span>30-DAY RETURNS</span>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Overlay -->
<div id="confirmation" style="display: none;">
    <div class="confirm-inner">
        <div class="confirm-seal">
            <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="40" cy="40" r="38" fill="none" stroke="#C9A84C" stroke-width="0.8" stroke-dasharray="3 4"/>
                <circle cx="40" cy="40" r="30" fill="#C9A84C" opacity="0.08"/>
                <circle cx="40" cy="40" r="22" fill="none" stroke="#C9A84C" stroke-width="0.6"/>
                <text x="40" y="37" text-anchor="middle" font-family="Cormorant Garamond, serif" font-size="9" fill="#C9A84C" letter-spacing="2" font-style="italic">LUMIÈRE</text>
                <path d="M29 45 L36 52 L52 36" stroke="#C9A84C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" opacity="0.8"/>
            </svg>
        </div>
        <span class="confirm-eyebrow">ORDER CONFIRMED</span>
        <h2 class="confirm-title">Merci,<br>your piece awaits</h2>
        <div class="confirm-rule"></div>
        <p class="confirm-body">
            Your order has been received and our atelier is preparing it with care.<br>
            A confirmation has been sent to your email address.
        </p>
        <div class="confirm-order-ref">
            ORDER REFERENCE &nbsp;·&nbsp; <strong id="order-ref">LM-2026-0847</strong>
        </div>
        <div class="confirm-actions">
            <a href="{{ route('home') }}" class="btn-outline-dark">RETURN TO LUMIÈRE</a>
            <a href="#" class="btn-outline-dark" style="background:var(--gold);color:#fff;border-color:var(--gold);">TRACK MY ORDER</a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Checkout styles from the original template */
:root {
    --gold:       #C9A84C;
    --gold-light: #E8C97A;
    --gold-dim:   rgba(201,168,76,0.12);
    --cream:      #F9F6F0;
    --ivory:      #F2EDE4;
    --charcoal:   #1C1C1C;
    --mid:        #2C2C2C;
    --warm-gray:  #8A8580;
    --border:     rgba(28,28,28,0.10);
    --border-md:  rgba(28,28,28,0.14);
}

.checkout-layout {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 0;
    max-width: 1180px;
    margin: 40px auto;
    min-height: calc(100vh - 200px);
}

@media (max-width: 960px) {
    .checkout-layout { 
        grid-template-columns: 1fr; 
        gap: 20px;
    }
    .order-panel { order: -1; }
}

.form-panel {
    padding: 40px;
    border-right: 1px solid var(--border);
}

@media (max-width: 960px) {
    .form-panel { 
        padding: 24px; 
        border-right: none;
        border-bottom: 1px solid var(--border);
    }
}

.acc-section {
    border-bottom: 1px solid var(--border);
    overflow: hidden;
}

.acc-section:first-of-type { border-top: 1px solid var(--border); }

.acc-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 22px 0;
    cursor: pointer;
}

.acc-left { display: flex; align-items: center; gap: 16px; }

.acc-num {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    border: 1px solid var(--border-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.62rem;
    font-weight: 400;
    color: rgba(28,28,28,0.4);
    transition: all 0.3s;
}

.acc-num.active {
    background: var(--charcoal);
    border-color: var(--charcoal);
    color: #fff;
}

.acc-title {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 400;
    color: rgba(28,28,28,0.35);
    transition: color 0.3s;
}

.acc-title.active { color: var(--charcoal); }

.acc-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s cubic-bezier(0.4,0,0.2,1);
}

.acc-body.open { max-height: 1000px; }
.acc-body-inner { padding-bottom: 32px; }

.field-group { margin-bottom: 24px; }
.field-label {
    display: block;
    font-size: 0.58rem;
    letter-spacing: 0.28em;
    color: rgba(28,28,28,0.4);
    margin-bottom: 9px;
    font-weight: 300;
}
.field-wrap {
    position: relative;
    display: flex;
    align-items: center;
    border-bottom: 1px solid var(--border-md);
    transition: border-color 0.3s;
}
.field-wrap:focus-within { border-bottom-color: var(--gold); }
.field-wrap i {
    color: rgba(28,28,28,0.25);
    font-size: 0.72rem;
    margin-right: 11px;
    transition: color 0.3s;
}
.field-wrap:focus-within i { color: var(--gold); }
.lux-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    padding: 10px 0;
    font-family: 'Jost', sans-serif;
    font-size: 0.84rem;
    font-weight: 300;
    color: var(--charcoal);
    letter-spacing: 0.03em;
}
.lux-select {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    padding: 10px 0;
    font-family: 'Jost', sans-serif;
    font-size: 0.84rem;
    font-weight: 300;
    color: var(--charcoal);
    -webkit-appearance: none;
    cursor: pointer;
}

.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }

.pay-tabs { display: flex; gap: 10px; margin-bottom: 24px; }
.pay-tab {
    flex: 1;
    padding: 11px 10px;
    border: 1px solid var(--border-md);
    background: transparent;
    cursor: pointer;
    font-family: 'Jost', sans-serif;
    font-size: 0.62rem;
    letter-spacing: 0.18em;
    color: rgba(28,28,28,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    transition: all 0.25s;
}
.pay-tab.active {
    border-color: var(--charcoal);
    color: var(--charcoal);
    background: rgba(28,28,28,0.03);
}

.btn-continue {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 36px;
    background: var(--gold);
    color: #fff;
    border: none;
    font-family: 'Jost', sans-serif;
    font-size: 0.64rem;
    letter-spacing: 0.28em;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 20px;
    width: 100%;
}

.btn-continue:hover {
    background: #A8862E;
    transform: translateY(-1px);
}

.order-panel {
    background: var(--ivory);
    padding: 40px;
    position: sticky;
    top: 100px;
    height: fit-content;
}

@media (max-width: 960px) {
    .order-panel { 
        position: static; 
        padding: 24px;
    }
}

.order-title {
    font-family: 'Playfair Display', serif;
    font-size: 0.95rem;
    letter-spacing: 0.12em;
    font-weight: 400;
    color: var(--charcoal);
    margin-bottom: 28px;
}

.order-items { display: flex; flex-direction: column; gap: 18px; margin-bottom: 28px; }
.order-item { display: flex; gap: 14px; align-items: center; }
.item-img-wrap {
    position: relative;
    flex-shrink: 0;
}
.item-img {
    width: 64px;
    height: 64px;
    object-fit: cover;
    display: block;
    border-radius: 4px;
}
.item-qty {
    position: absolute;
    top: -7px;
    right: -7px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--charcoal);
    color: #fff;
    font-size: 0.58rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 400;
}
.item-name {
    font-family: 'Playfair Display', serif;
    font-size: 0.82rem;
    font-weight: 400;
    color: var(--charcoal);
    margin-bottom: 3px;
}
.item-variant { font-size: 0.65rem; color: var(--warm-gray); font-weight: 300; letter-spacing: 0.06em; }
.item-price { margin-left: auto; font-size: 0.82rem; color: var(--charcoal); font-weight: 300; white-space: nowrap; }

.promo-wrap {
    display: flex;
    gap: 0;
    border-bottom: 1px solid var(--border-md);
    margin-bottom: 24px;
}
.promo-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    padding: 10px 0;
    font-family: 'Jost', sans-serif;
    font-size: 0.78rem;
    font-weight: 300;
    color: var(--charcoal);
    letter-spacing: 0.04em;
}
.promo-btn {
    background: none;
    border: none;
    font-family: 'Jost', sans-serif;
    font-size: 0.6rem;
    letter-spacing: 0.22em;
    color: var(--gold);
    cursor: pointer;
    padding-left: 12px;
    transition: opacity 0.2s;
}
.promo-btn:hover { opacity: 0.7; }

.totals { margin-top: auto; }
.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 0;
    border-bottom: 1px solid var(--border);
}
.total-row:last-child { border-bottom: none; }
.total-label { font-size: 0.68rem; letter-spacing: 0.1em; color: var(--warm-gray); font-weight: 300; }
.total-value { font-size: 0.78rem; color: var(--charcoal); font-weight: 300; }
.total-row.grand .total-label { font-family: 'Playfair Display', serif; color: var(--charcoal); font-size: 0.9rem; letter-spacing: 0.04em; font-weight: 400; }
.total-row.grand .total-value { font-family: 'Playfair Display', serif; font-size: 1.1rem; color: var(--charcoal); font-weight: 400; }

.trust-badges {
    display: flex;
    justify-content: center;
    gap: 18px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
}
.trust-badge {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.58rem;
    letter-spacing: 0.12em;
    color: rgba(28,28,28,0.35);
    font-weight: 300;
}
.trust-badge i { color: var(--gold); font-size: 0.72rem; }

#confirmation {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 100;
    background: var(--cream);
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

#confirmation.show { display: flex; }

.confirm-inner {
    text-align: center;
    max-width: 500px;
    padding: 40px 32px;
}

.confirm-seal {
    width: 80px;
    height: 80px;
    margin: 0 auto 32px;
}

.confirm-eyebrow {
    font-size: 0.6rem;
    letter-spacing: 0.35em;
    color: var(--gold);
    font-weight: 300;
    display: block;
    margin-bottom: 12px;
}

.confirm-title {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-weight: 300;
    font-size: 2.8rem;
    line-height: 1.15;
    color: var(--charcoal);
    margin-bottom: 16px;
}

.confirm-rule {
    width: 48px;
    height: 1px;
    background: var(--gold);
    margin: 0 auto 20px;
}

.confirm-body {
    font-size: 0.82rem;
    color: var(--warm-gray);
    font-weight: 300;
    line-height: 1.7;
    margin-bottom: 36px;
    letter-spacing: 0.02em;
}

.confirm-order-ref {
    display: inline-block;
    background: var(--ivory);
    padding: 10px 22px;
    font-size: 0.65rem;
    letter-spacing: 0.2em;
    color: var(--charcoal);
    margin-bottom: 36px;
    font-weight: 300;
}

.confirm-order-ref strong { color: var(--gold); font-weight: 400; }

.confirm-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.btn-outline-dark {
    padding: 13px 28px;
    border: 1px solid rgba(28,28,28,0.2);
    background: transparent;
    font-family: 'Jost', sans-serif;
    font-size: 0.6rem;
    letter-spacing: 0.24em;
    color: var(--charcoal);
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
}
.btn-outline-dark:hover { background: var(--charcoal); color: #fff; }

.loading {
    opacity: 0.6;
    pointer-events: none;
}
</style>
@endpush

@push('scripts')
<script>
// Accordion functionality
document.querySelectorAll('.acc-header').forEach(header => {
    header.addEventListener('click', function() {
        const body = this.nextElementSibling;
        const section = this.parentElement;
        const num = this.querySelector('.acc-num');
        const title = this.querySelector('.acc-title');
        
        // Toggle current section
        body.classList.toggle('open');
        num.classList.toggle('active');
        title.classList.toggle('active');
    });
});

// Payment method tabs
document.querySelectorAll('.pay-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.pay-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        const method = this.dataset.method;
        document.getElementById('payment-method').value = method;
        
        if (method === 'stripe') {
            document.getElementById('stripe-payment').style.display = 'block';
            document.getElementById('paypal-payment').style.display = 'none';
        } else {
            document.getElementById('stripe-payment').style.display = 'none';
            document.getElementById('paypal-payment').style.display = 'block';
        }
    });
});

// Card number formatting
document.querySelector('input[name="card_number"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s/g, '');
    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
    e.target.value = formattedValue;
    
    // Update card display
    const display = document.getElementById('card-display');
    if (value.length > 0) {
        let displayValue = formattedValue.padEnd(19, '•');
        display.textContent = displayValue;
    } else {
        display.textContent = '•••• •••• •••• ••••';
    }
});

// Card expiry formatting
document.querySelector('input[name="card_expiry"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.slice(0, 2) + '/' + value.slice(2, 4);
    }
    e.target.value = value;
});

// CVC handling
document.querySelector('input[name="card_cvc"]').addEventListener('input', function(e) {
    const value = e.target.value.replace(/\D/g, '');
    e.target.value = value;
    
    // Show CVV on card back when focused
    const card = document.getElementById('card-visual');
    const cvvDisplay = document.getElementById('cvv-display');
    
    if (value.length > 0) {
        card.classList.add('flipped');
        cvvDisplay.textContent = value.padEnd(3, '•');
    } else {
        card.classList.remove('flipped');
        cvvDisplay.textContent = '•••';
    }
});

// Form submission
document.getElementById('checkout-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = e.target.querySelector('button[type="submit"]');
    submitBtn.classList.add('loading');
    submitBtn.innerHTML = '<span>PROCESSING...</span><i class="fa-solid fa-spinner fa-spin"></i>';
    
    try {
        const formData = new FormData(this);
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Show confirmation
            document.getElementById('order-ref').textContent = result.order_number;
            document.getElementById('confirmation').classList.add('show');
            
            // Redirect after delay
            setTimeout(() => {
                window.location.href = result.redirect_url;
            }, 3000);
        } else {
            alert(result.error || 'An error occurred. Please try again.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    } finally {
        submitBtn.classList.remove('loading');
        submitBtn.innerHTML = '<span>PLACE ORDER</span><i class="fa-solid fa-arrow-right"></i>';
    }
});
</script>
@endpush
