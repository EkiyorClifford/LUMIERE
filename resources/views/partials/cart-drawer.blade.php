<!-- CART DRAWER COMPONENT -->
@php
    $cartCount = $cartCount ?? 0;
    $cartItems = $cartItems ?? collect();
    $cartTotal = $cartTotal ?? 0;
@endphp
<div id="cart-drawer" class="fixed inset-y-0 right-0 w-full md:w-[450px] bg-white z-[100] shadow-2xl translate-x-full transition-transform duration-500 ease-in-out flex flex-col">
    <!-- Header -->
    <div class="p-8 border-b border-charcoal/5 flex justify-between items-center">
        <h2 class="font-playfair text-xl">Your Shopping Bag <span class="text-xs text-warm-gray font-jost ml-2">({{ $cartCount }})</span></h2>
        <button onclick="toggleCart()" class="text-charcoal/40 hover:text-charcoal transition-colors"><i class="fa-solid fa-xmark text-xl"></i></button>
    </div>

    <!-- Items -->
    <div class="flex-1 overflow-y-auto p-8 space-y-8">
        @if ($cartItems->count() > 0)
            @foreach ($cartItems as $item)
            <div class="flex gap-6">
                <div class="w-24 h-32 bg-deep-ivory overflow-hidden">
                    <img src="{{ $item->product->primaryImage?->image_path ?? $item->product->images->first()?->image_path ?? 'https://images.unsplash.com/photo-1515562141589-67f0b562b677?q=80&w=400&auto=format&fit=crop' }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 flex flex-col justify-between py-1">
                    <div>
                        <h3 class="font-playfair text-sm mb-1">{{ $item->product->name }}</h3>
                        <p class="text-[9px] tracking-widest text-warm-gray uppercase">{{ $item->variant_label ?? 'Standard' }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center border border-charcoal/10">
                            <button onclick="updateCartItem({{ $item->id }}, {{ $item->quantity - 1 }})" class="px-3 py-1 text-xs">-</button>
                            <span class="px-3 py-1 text-[10px]">{{ $item->quantity }}</span>
                            <button onclick="updateCartItem({{ $item->id }}, {{ $item->quantity + 1 }})" class="px-3 py-1 text-xs">+</button>
                        </div>
                        <p class="text-xs">${{ number_format($item->price * $item->quantity, 2) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-12">
                <i class="fa-solid fa-cart-shopping text-4xl text-charcoal/20 mb-4"></i>
                <p class="text-charcoal/50 text-sm font-jost">Your bag is empty</p>
                <a href="{{ route('shop') }}" class="inline-block mt-4 text-soft-gold text-xs tracking-[0.2em] hover:underline">Continue Shopping</a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    @if ($cartItems->count() > 0)
    <div class="p-8 bg-cream space-y-6">
        <div class="flex justify-between items-center">
            <p class="text-[10px] tracking-[0.2em] uppercase">Subtotal</p>
            <p class="font-playfair text-lg">${{ number_format($cartTotal, 2) }}</p>
        </div>
        <p class="text-[9px] text-warm-gray leading-relaxed">Complimentary insured shipping applied at checkout.</p>
        <a href="{{ route('shop') }}" class="block w-full bg-charcoal text-white py-5 text-[10px] tracking-[0.3em] uppercase hover:bg-soft-gold transition-colors duration-500 text-center">
            Secure Checkout
        </a>
    </div>
    @endif
</div>
<!-- OVERLAY -->
<div id="cart-overlay" class="fixed inset-0 bg-black/20 z-[90] hidden opacity-0 transition-opacity" onclick="toggleCart()"></div>

<script>
    function toggleCart() {
        const drawer = document.getElementById('cart-drawer');
        const overlay = document.getElementById('cart-overlay');
        drawer.classList.toggle('translate-x-full');
        overlay.classList.toggle('hidden');
        setTimeout(() => overlay.classList.toggle('opacity-100'), 10);
    }

    async function updateCartItem(itemId, quantity) {
        if (quantity < 1) {
            if (confirm('Remove this item from your bag?')) {
                location.reload();
            }
            return;
        }
        
        location.reload();
    }
</script>
