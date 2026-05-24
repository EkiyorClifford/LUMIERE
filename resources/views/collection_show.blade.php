<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $collection->name }} | LUMIÈRE Collections</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300&family=Jost:wght@300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: Jost, sans-serif; }
        .font-playfair { font-family: "Playfair Display", serif; }
        .font-cormorant { font-family: "Cormorant Garamond", serif; }
        .hero-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.35) 55%, rgba(0,0,0,0.1) 100%);
        }
    </style>
</head>
<body class="bg-[#F9F6F0] text-[#1C1C1C]">

<nav class="px-6 md:px-12 py-6 flex items-center justify-between bg-[#F9F6F0]/95 sticky top-0 z-40 border-b border-black/5">
    <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-[0.25em]">LUMIERE</a>

    <div class="hidden md:flex gap-8 text-[11px] tracking-[0.22em]">
        <a href="{{ route('collections') }}" class="text-[#C9A84C]">COLLECTIONS</a>
        <a href="{{ route('shop') }}" class="text-black/60 hover:text-[#C9A84C]">SHOP</a>
        <a href="{{ route('atelier') }}" class="text-black/60 hover:text-[#C9A84C]">ATELIER</a>
    </div>

    <button onclick="toggleCart()" class="text-black/60 hover:text-[#C9A84C] relative">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-[#C9A84C] text-white text-[8px] flex items-center justify-center">{{ $cartCount ?? 0 }}</span>
    </button>
</nav>

<header class="relative min-h-[70vh] flex items-end">
    <img src="{{ asset($collection->cover_image ?? 'images/diamond_bracelet_paris_night.png') }}"
         alt="{{ $collection->name }} hero"
         class="absolute inset-0 w-full h-full object-cover">
    <div class="hero-overlay absolute inset-0"></div>

    <div class="relative z-10 px-6 md:px-12 py-16 md:py-20 max-w-screen-xl mx-auto w-full text-white">
        <p class="text-[#E8C97A] text-[10px] tracking-[0.35em] mb-4">{{ $pageContent['eyebrow'] }}</p>
        <h1 class="font-playfair text-5xl md:text-7xl font-light mb-4">{{ strtoupper($collection->name) }}</h1>
        <p class="font-cormorant italic text-2xl md:text-3xl text-white/90 mb-4">{{ $pageContent['tagline'] }}</p>
        <p class="text-sm md:text-base text-white/80 max-w-2xl mb-8">{{ $pageContent['hero_copy'] }}</p>
        <div class="flex flex-wrap gap-3">
            <a href="#products" class="px-6 py-3 bg-[#C9A84C] text-white text-[10px] tracking-[0.2em]">SHOP THE COLLECTION</a>
            <a href="{{ route('atelier') }}" class="px-6 py-3 border border-white/50 text-white text-[10px] tracking-[0.2em]">BOOK PRIVATE CONSULTATION</a>
        </div>
    </div>
</header>

<section class="px-6 md:px-12 py-16 md:py-20">
    <div class="max-w-screen-xl mx-auto grid md:grid-cols-2 gap-10 items-center">
        <div>
            <p class="text-[#C9A84C] text-[10px] tracking-[0.35em] mb-3">THE STORY</p>
            <h2 class="font-playfair text-4xl md:text-5xl font-light mb-5">{{ $pageContent['story_heading'] }}</h2>
            <p class="text-black/65 leading-relaxed">{{ $pageContent['story_body'] }}</p>
        </div>
        <div class="bg-[#F2EDE4] p-8 md:p-10">
            <p class="text-[10px] tracking-[0.3em] text-black/50 mb-4">CRAFT GUARANTEES</p>
            <ul class="space-y-4">
                @foreach($pageContent['trust_points'] as $point)
                    <li class="flex items-center gap-3 text-sm">
                        <span class="text-[#C9A84C]"><i class="fa-solid fa-gem text-xs"></i></span>
                        <span>{{ $point }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<main id="products" class="px-6 md:px-12 pb-24">
    <div class="max-w-screen-xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h3 class="font-playfair text-3xl font-light">Signature Pieces</h3>
            <p class="text-xs tracking-[0.18em] text-black/45">{{ $products->count() }} PIECES</p>
        </div>

        @if ($products->isEmpty())
            <div class="text-center py-16 border border-black/10 bg-white/50">
                <p class="font-cormorant italic text-2xl text-black/55">This collection is being curated.</p>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-7">
                @foreach ($products as $product)
                    @php
                        $productImageUrl = $product->primaryImage?->image_url
                            ?? $product->images->first()?->image_url
                            ?? 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=1200&auto=format&fit=crop';
                    @endphp
                    <div class="group">
                        <a href="{{ route('product.show', $product) }}">
                            <div class="relative aspect-[3/4] bg-[#F2EDE4] overflow-hidden mb-4">
                                <img src="{{ $productImageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                            </div>
                            <p class="text-[#C9A84C] text-[10px] tracking-[0.22em] mb-2">{{ strtoupper($collection->name) }}</p>
                            <h4 class="font-playfair text-xl font-light">{{ $product->name }}</h4>
                            <p class="text-sm text-black/50 mt-1">{{ ucfirst($product->category) }}</p>
                            <p class="font-playfair text-lg mt-3">€{{ number_format((float) $product->price) }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</main>

<section class="bg-[#1C1C1C] text-white px-6 md:px-12 py-16">
    <div class="max-w-screen-xl mx-auto text-center">
        <p class="text-[#C9A84C] text-[10px] tracking-[0.35em] mb-4">CONCIERGE</p>
        <h3 class="font-playfair text-3xl md:text-4xl font-light mb-4">{{ $pageContent['cta_heading'] }}</h3>
        <p class="text-white/60 max-w-2xl mx-auto mb-8">Our advisors can guide fit, styling, gifting, and custom recommendations for this collection.</p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('atelier') }}" class="px-6 py-3 bg-[#C9A84C] text-white text-[10px] tracking-[0.2em]">CONTACT CONCIERGE</a>
            <a href="{{ route('profile.show') }}" class="px-6 py-3 border border-white/40 text-white text-[10px] tracking-[0.2em]">BOOK APPOINTMENT</a>
        </div>
    </div>
</section>

@include('partials.cart-drawer')

</body>
</html>