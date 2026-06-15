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
        #main-nav {
            transition: padding 0.4s ease, background 0.4s ease, box-shadow 0.4s ease;
        }
        #main-nav.scrolled {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            background: rgba(249,246,240,0.97);
            box-shadow: 0 1px 24px rgba(0,0,0,0.06);
        }
        .nav-link { position: relative; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 1px;
            background: #C9A84C;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after,
        .nav-link.active::after { width: 100%; }
        #mobile-menu {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        #mobile-menu.open { transform: translateX(0); }
        .hero-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.35) 55%, rgba(0,0,0,0.1) 100%);
        }
    </style>
</head>
<body class="bg-[#F9F6F0] text-[#1C1C1C]">
@php
    $currencySymbol = config('lumiere.currency_symbol');
    $heroImage = $pageContent['hero_image'] ?? ($collection->cover_image ?? 'images/diamond_bracelet_paris_night.png');
    $heroImageUrl = str_starts_with($heroImage, 'http') ? $heroImage : asset($heroImage);
@endphp

<nav id="main-nav" class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12">
    <div class="flex justify-between items-center max-w-screen-xl mx-auto">
        <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-[#1C1C1C] hover:text-[#C9A84C] transition-colors duration-300">LUMIÈRE</a>
        <div class="hidden md:flex items-center gap-10">
            <a href="{{ route('collections') }}" class="nav-link active text-xs tracking-[0.18em] text-[#1C1C1C] font-jost">COLLECTIONS</a>
            <a href="{{ route('shop') }}" class="nav-link text-xs tracking-[0.18em] text-[#1C1C1C]/70 hover:text-[#1C1C1C] font-jost">SHOP</a>
            <a href="{{ route('atelier') }}" class="nav-link text-xs tracking-[0.18em] text-[#1C1C1C]/70 hover:text-[#1C1C1C] font-jost">ABOUT</a>
            <a href="{{ route('journal') }}" class="nav-link text-xs tracking-[0.18em] text-[#1C1C1C]/70 hover:text-[#1C1C1C] font-jost">JOURNAL</a>
        </div>
        <div class="flex items-center gap-5">
            <a href="{{ route('wishlist.index') }}" class="text-[#1C1C1C]/60 hover:text-[#C9A84C] transition-colors duration-300 relative">
                <i class="fa-regular fa-heart text-base"></i>
                <span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-[#C9A84C] text-white text-[8px] flex items-center justify-center font-jost">{{ $wishlistCount ?? 0 }}</span>
            </a>
            @auth('web')
                <div class="relative group">
                    <button class="text-[#1C1C1C]/60 hover:text-[#C9A84C] transition-colors duration-300 flex items-center gap-2">
                        <i class="fa-solid fa-user text-base"></i>
                        <span class="text-xs font-jost hidden md:block">{{ auth('web')->user()?->name }}</span>
                    </button>
                    @if(auth('web')->user()?->is_gold_circle)
                        <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-[#C9A84C]"></span>
                    @endif
                    <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-sm opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-3 text-xs text-[#1C1C1C]/70 hover:text-[#C9A84C] hover:bg-[#F9F6F0] transition-colors font-jost">My Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-xs text-[#1C1C1C]/70 hover:text-[#C9A84C] hover:bg-[#F9F6F0] transition-colors font-jost">Sign Out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-[#1C1C1C]/60 hover:text-[#C9A84C] transition-colors duration-300">
                    <i class="fa-regular fa-user text-base"></i>
                </a>
            @endif
            <button onclick="toggleCart()" class="text-[#1C1C1C]/60 hover:text-[#C9A84C] transition-colors duration-300 relative">
                <i class="fa-solid fa-cart-shopping text-base"></i>
                <span id="cart-count" class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-[#C9A84C] text-white text-[8px] flex items-center justify-center">{{ $cartCount ?? 0 }}</span>
            </button>
            <button id="menu-open" class="md:hidden text-[#1C1C1C]/70 ml-1">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>
    </div>
</nav>

<div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-[#F9F6F0] z-[60] shadow-2xl flex flex-col px-10 py-12">
    <button id="menu-close" class="self-end text-[#1C1C1C]/50 hover:text-[#1C1C1C] mb-10">
        <i class="fa-solid fa-xmark text-xl"></i>
    </button>
    <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-[#1C1C1C] mb-10 block">LUMIÈRE</a>
    <div class="flex flex-col gap-7">
        <a href="{{ route('collections') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-[#C9A84C] font-jost">COLLECTIONS</a>
        <a href="{{ route('shop') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-[#1C1C1C]/70 hover:text-[#C9A84C] transition-colors duration-300 font-jost">SHOP</a>
        <a href="{{ route('atelier') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-[#1C1C1C]/70 hover:text-[#C9A84C] transition-colors duration-300 font-jost">ABOUT</a>
        <a href="{{ route('journal') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-[#1C1C1C]/70 hover:text-[#C9A84C] transition-colors duration-300 font-jost">JOURNAL</a>
        @auth
            <a href="{{ route('profile.show') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-[#1C1C1C]/70 hover:text-[#C9A84C] transition-colors duration-300 font-jost">MY PROFILE</a>
        @else
            <a href="{{ route('login') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-[#1C1C1C]/70 hover:text-[#C9A84C] transition-colors duration-300 font-jost">SIGN IN</a>
        @endif
    </div>
    <div class="mt-auto flex gap-5 text-[#1C1C1C]/40">
        <a href="#"><i class="fa-brands fa-instagram text-lg hover:text-[#C9A84C] transition-colors"></i></a>
        <a href="#"><i class="fa-brands fa-pinterest text-lg hover:text-[#C9A84C] transition-colors"></i></a>
    </div>
</div>
<div id="menu-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden"></div>

<header class="relative min-h-[70vh] flex items-end">
    <img src="{{ $heroImageUrl }}"
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
                            <p class="font-playfair text-lg mt-3">{{ $currencySymbol }}{{ number_format((float) $product->price) }}</p>
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
            <a href="{{ route('atelier') }}" class="px-6 py-3 border border-white/40 text-white text-[10px] tracking-[0.2em]">BOOK APPOINTMENT</a>
        </div>
    </div>
</section>

@include('partials.cart-drawer')

<script>
    const nav = document.getElementById('main-nav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 60);
    });

    const openBtn = document.getElementById('menu-open');
    const closeBtn = document.getElementById('menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('menu-overlay');
    const openMenu = () => {
        mobileMenu.classList.add('open');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };
    const closeMenu = () => {
        mobileMenu.classList.remove('open');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    };

    openBtn?.addEventListener('click', openMenu);
    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);
    document.querySelectorAll('.mobile-nav-link').forEach((link) => link.addEventListener('click', closeMenu));
</script>

</body>
</html>
