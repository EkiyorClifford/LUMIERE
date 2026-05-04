<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - LUMIÈRE</title>
    <style>
        body {
            font-family: 'Jost', sans-serif;
            background-color: #F9F6F0;
            margin: 0;
            padding: 20px;
            color: #1C1C1C;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 1px solid #F2EDE4;
            padding-bottom: 30px;
        }
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            letter-spacing: 0.22em;
            color: #C9A84C;
            margin-bottom: 10px;
        }
        .title {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 2rem;
            color: #1C1C1C;
            margin: 0;
        }
        .order-number {
            color: #C9A84C;
            font-weight: 600;
            margin-top: 10px;
            font-size: 1.1rem;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: #1C1C1C;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #F2EDE4;
        }
        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #F2EDE4;
        }
        .item:last-child {
            border-bottom: none;
        }
        .item-info {
            flex: 1;
        }
        .item-name {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: #1C1C1C;
            margin-bottom: 5px;
        }
        .item-variant {
            font-size: 0.9rem;
            color: #8A8580;
        }
        .item-quantity {
            font-size: 0.9rem;
            color: #8A8580;
            margin: 0 20px;
        }
        .item-price {
            font-size: 1rem;
            color: #1C1C1C;
            font-weight: 300;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 0.95rem;
        }
        .total-row.grand {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 400;
            padding-top: 15px;
            border-top: 2px solid #C9A84C;
        }
        .shipping-info {
            background: #F2EDE4;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #F2EDE4;
            color: #8A8580;
            font-size: 0.9rem;
        }
        .btn {
            display: inline-block;
            background: #C9A84C;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 4px;
            font-family: 'Jost', sans-serif;
            font-size: 0.9rem;
            letter-spacing: 0.1em;
            margin: 20px 0;
        }
        .btn:hover {
            background: #A8862E;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">LUMIÈRE</div>
            <h1 class="title">Merci for Your Order</h1>
            <div class="order-number">Order #{{ $order->order_number }}</div>
        </div>

        <!-- Order Items -->
        <div class="section">
            <h2 class="section-title">Order Details</h2>
            @foreach($order->items as $item)
                <div class="item">
                    <div class="item-info">
                        <div class="item-name">{{ $item->product->name }}</div>
                        @if($item->variant)
                            <div class="item-variant">{{ $item->variant->name }}</div>
                        @endif
                    </div>
                    <div class="item-quantity">Qty: {{ $item->quantity }}</div>
                    <div class="item-price">${{ number_format($item->price * $item->quantity, 2) }}</div>
                </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="section">
            <h2 class="section-title">Order Summary</h2>
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

        <!-- Shipping Information -->
        <div class="section">
            <h2 class="section-title">Shipping Information</h2>
            <div class="shipping-info">
                <strong>{{ $order->shipping_full_name }}</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                {{ $order->shipping_country }}
            </div>
        </div>

        <!-- Next Steps -->
        <div class="section">
            <h2 class="section-title">What's Next?</h2>
            <p style="color: #8A8580; line-height: 1.6;">
                Our atelier is carefully preparing your order. You will receive another email when your package ships, 
                including tracking information. Expected delivery is within 7-10 business days.
            </p>
            <div style="text-align: center;">
                <a href="{{ route('home') }}" class="btn">Continue Shopping</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for choosing LUMIÈRE</p>
            <p style="font-size: 0.8rem; margin-top: 10px;">
                Questions? Contact us at <a href="mailto:support@lumiere.com" style="color: #C9A84C;">support@lumiere.com</a>
            </p>
        </div>
    </div>
</body>
</html>
