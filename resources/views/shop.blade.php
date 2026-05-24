<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shop - LUMIERE</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300&family=Jost:wght@300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: Jost, sans-serif; }
        .font-playfair { font-family: "Playfair Display", serif; }
        .font-cormorant { font-family: "Cormorant Garamond", serif; }

        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-[#F9F6F0] text-[#1C1C1C]">

<nav class="px-6 md:px-12 py-6 flex items-center justify-between">
    <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-[0.25em]">LUMIERE</a>

    <div class="hidden md:flex gap-8 text-[11px] tracking-[0.22em]">
        <a href="{{ route('collections') }}" class="text-black/60 hover:text-[#C9A84C]">COLLECTIONS</a>
        <a href="{{ route('shop') }}" class="text-[#C9A84C]">SHOP</a>
        <a href="{{ route('atelier') }}" class="text-black/60 hover:text-[#C9A84C]">ATELIER</a>
    </div>

    <div class="flex items-center gap-5">
        <a href="{{ route('wishlist.index') }}" class="text-black/60 hover:text-[#C9A84C] relative">
            <i class="fa-regular fa-heart"></i>
            <span id="wishlist-count" class="absolute -top-1 -right-1 text-[8px] bg-[#C9A84C] text-white w-4 h-4 flex items-center justify-center rounded-full">{{ $wishlistCount ?? 0 }}</span>
        </a>

        @auth
        <div class="relative group">
            <button class="flex items-center gap-2 text-black/60 hover:text-[#C9A84C]">
                <i class="fa-solid fa-user"></i>
                <span class="text-xs hidden md:block">{{ auth()->user()->name }}</span>
            </button>

            <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible">
                <a href="{{ route('profile.show') }}" class="block px-4 py-3 text-xs hover:text-[#C9A84C]">My Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-3 text-xs hover:text-[#C9A84C]">Sign Out</button>
                </form>
            </div>
        </div>
        @else
        <a href="{{ route('login') }}"><i class="fa-regular fa-user"></i></a>
        @endif

        <button onclick="toggleCart()" class="text-charcoal/60 hover:text-soft-gold transition-colors relative">
            <i class="fa-solid fa-cart-shopping text-base"></i>
            <span id="cart-count" class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center">{{ $cartCount ?? 0 }}</span>
        </button>
    </div>
</nav>

<!-- HEADER -->
<header class="px-6 md:px-12 pt-14 pb-16 text-center">
    <p class="text-[#C9A84C] text-[10px] tracking-[0.4em] mb-3">FINE JEWELRY</p>

    <h1 class="font-playfair text-5xl md:text-7xl font-light mb-4">
        Shop the House
    </h1>

    <p class="font-cormorant italic text-xl text-black/60 max-w-xl mx-auto mb-6">
        A curated expression of diamonds, gold, and quiet luxury.
    </p>

    <div class="w-16 h-[1px] bg-[#C9A84C] mx-auto"></div>
</header>

<main class="px-6 md:px-12 pb-24">
<div class="max-w-screen-xl mx-auto">

<!-- FILTER PILLS -->
<div class="flex gap-3 overflow-x-auto pb-4 mb-8">

    <a href="{{ route('shop') }}"
       class="px-4 py-2 text-[11px] tracking-widest border {{ !$activeCategory ? 'bg-black text-white' : 'border-black/20' }}">
        ALL
    </a>

    @foreach($categories as $category)
        <a href="{{ route('shop', ['category' => $category->slug]) }}"
           class="px-4 py-2 text-[11px] tracking-widest border whitespace-nowrap
           {{ $activeCategory === $category->slug ? 'bg-black text-white' : 'border-black/20 hover:border-[#C9A84C]' }}">
            {{ strtoupper($category->name) }}
        </a>
    @endforeach

</div>

<!-- SORT -->
<div class="flex justify-between items-center mb-6">
    <p class="text-xs text-black/40 tracking-widest">
        {{ $products->count() }} PIECES
    </p>

    <form method="GET">
        <select name="sort" onchange="this.form.submit()"
            class="text-[11px] tracking-widest border border-black/20 px-3 py-2 bg-transparent">
            <option value="">SORT</option>
            <option value="newest">Newest</option>
            <option value="price_low">Price ↑</option>
            <option value="price_high">Price ↓</option>
        </select>
    </form>
</div>

@if ($products->isEmpty())

<div class="text-center py-20">
    <div class="text-4xl text-black/20 mb-4">
        <i class="fa-regular fa-gem"></i>
    </div>

    <h3 class="font-playfair text-2xl mb-3">Nothing Here Yet</h3>

    <p class="font-cormorant italic text-black/50 mb-6">
        This selection is still being curated.
    </p>

    <a href="{{ route('shop') }}"
       class="border border-black px-6 py-3 text-[10px] tracking-widest hover:bg-black hover:text-white">
        EXPLORE ALL
    </a>
</div>

@else

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-7">

@foreach ($products as $product)
@php
    $productImageUrl = $product->primaryImage?->image_url
        ?? $product->images->first()?->image_url
        ?? 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=1200&auto=format&fit=crop';
@endphp

<div class="group relative fade-up" data-delay="{{ $loop->index * 80 }}">

    <div class="relative aspect-[3/4] bg-[#F2EDE4] overflow-hidden mb-4">

        <!-- BADGES -->
        <div class="absolute top-3 left-3 flex flex-col gap-2 z-10">
            @if($product->is_featured)
                <span class="text-[9px] tracking-widest bg-[#C9A84C] text-white px-2 py-1">NEW</span>
            @endif

            @if($product->stock <= 3)
                <span class="text-[9px] tracking-widest bg-black text-white px-2 py-1">LAST FEW</span>
            @endif
        </div>

        <!-- WISHLIST -->
        <button data-product-id="{{ $product->id }}" onclick="toggleWishlist(event)" class="absolute top-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition">
            <i class="fa-regular fa-heart hover:text-[#C9A84C]"></i>
        </button>

        <!-- IMAGE -->
        <img src="{{ $productImageUrl }}"
             class="w-full h-full object-cover transition duration-700 group-hover:scale-105">

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition duration-500 flex items-center justify-center">

            <button data-product-id="{{ $product->id }}" onclick="addToCart(event, null, 1)"
                class="opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 bg-[#C9A84C] text-white px-6 py-2 text-[11px] tracking-[0.2em]">
                QUICK ADD
            </button>

        </div>
    </div>

    <a href="{{ route('product.show', $product) }}">
        <p class="text-[#C9A84C] text-[10px] tracking-[0.25em] mb-2">
            {{ strtoupper($product->collection?->name ?? $product->category) }}
        </p>

        <h2 class="font-playfair text-xl font-light">{{ $product->name }}</h2>
        <p class="text-sm text-black/50 mt-1">{{ ucfirst($product->category) }}</p>
        <p class="font-playfair text-lg mt-3">€{{ number_format((float) $product->price) }}</p>
    </a>

</div>

@endforeach

</div>

@endif

</div>
</main>

<!-- NEWSLETTER -->
<section class="bg-[#1C1C1C] px-6 md:px-12 py-20 text-center">

    <p class="text-[#C9A84C] text-[10px] tracking-[0.4em] mb-3">INNER CIRCLE</p>

    <h2 class="font-playfair text-3xl text-white mb-3">
        Stay Close to the Atelier
    </h2>

    <p class="font-cormorant italic text-white/60 mb-6">
        Private releases. Quiet luxury. First access.
    </p>

    <div class="w-12 h-[1px] bg-[#C9A84C] mx-auto mb-8"></div>

    <form action="{{ route('newsletter') }}" method="POST" class="max-w-sm mx-auto">
        @csrf

        <div class="flex border-b border-white/20">
            <input type="email" name="email" required
                   placeholder="Your email address"
                   class="flex-1 bg-transparent py-3 text-sm text-white placeholder:text-white/35 outline-none">

            <button type="submit"
                class="text-[#C9A84C] text-[10px] tracking-[0.22em] pl-4">
                SUBSCRIBE
            </button>
        </div>
    </form>

</section>

@include('partials.cart-drawer')

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-delay]').forEach((el) => {
        el.style.animationDelay = `${el.dataset.delay}ms`;
    });
});

function toggleWishlist(event) {
    event?.preventDefault();
    const productId = event?.currentTarget?.dataset?.productId;
    if (!productId) {
        return;
    }

    fetch('/wishlist/add', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        },
        body: JSON.stringify({ product_id: productId }),
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        return response.json();
    })
    .then((data) => {
        if (data?.count !== undefined) {
            const wishlistCount = document.getElementById('wishlist-count');
            if (wishlistCount) {
                wishlistCount.textContent = data.count;
            }
        }
    })
    .catch((error) => {
        console.error('Error updating wishlist:', error);
    });
}
</script>

</body>
</html>