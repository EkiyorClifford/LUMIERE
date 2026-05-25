<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LUMIÈRE | Fine Jewelry</title>
    <meta name="description" content="Timeless elegance. Handcrafted jewelry for the discerning soul.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F9F6F0',
                        'soft-gold': '#C9A84C',
                        'gold-light': '#E8C97A',
                        'deep-ivory': '#F2EDE4',
                        charcoal: '#1C1C1C',
                        'charcoal-mid': '#2C2C2C',
                        'warm-gray': '#8A8580',
                    },
                    fontFamily: {
                        'playfair': ['"Playfair Display"', 'serif'],
                        'cormorant': ['"Cormorant Garamond"', 'serif'],
                        'jost': ['Jost', 'sans-serif'],
                    },
                    keyframes: {
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(28px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slowZoom: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.06)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% center' },
                            '100%': { backgroundPosition: '200% center' },
                        },
                        lineGrow: {
                            '0%': { width: '0' },
                            '100%': { width: '4rem' },
                        },
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.9s ease both',
                        'fade-up-2': 'fadeUp 0.9s ease 0.15s both',
                        'fade-up-3': 'fadeUp 0.9s ease 0.3s both',
                        'fade-up-4': 'fadeUp 0.9s ease 0.45s both',
                        'slow-zoom': 'slowZoom 22s ease-in-out infinite',
                        'shimmer': 'shimmer 3s linear infinite',
                        'line-grow': 'lineGrow 0.8s ease 0.6s both',
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Jost:wght@200;300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C97A;
            --cream: #F9F6F0;
            --charcoal: #1C1C1C;
            --ivory: #F2EDE4;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }
        ::selection { background: var(--gold); color: #fff; }
        html { scroll-behavior: smooth; }

        /* ── NAV scroll transformation ── */
        #main-nav {
            transition: padding 0.4s ease, background 0.4s ease, box-shadow 0.4s ease;
        }
        #main-nav.scrolled {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            background: rgba(249,246,240,0.97);
            box-shadow: 0 1px 24px rgba(0,0,0,0.06);
        }

        /* ── Gold divider ── */
        .gold-rule {
            display: block;
            width: 0;
            height: 1px;
            background: var(--gold);
            margin: 0 auto;
            animation: lineGrow 0.8s ease 0.5s forwards;
        }

        /* ── Nav underline hover ── */
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--gold);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }

        /* ── Product card overlay ── */
        .product-card .overlay {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.35s ease, transform 0.35s ease;
        }
        .product-card:hover .overlay {
            opacity: 1;
            transform: translateY(0);
        }
        .product-card .card-img {
            transition: transform 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .product-card:hover .card-img {
            transform: scale(1.06);
        }

        /* ── Collection card ── */
        .collection-card .coll-img {
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .collection-card:hover .coll-img { transform: scale(1.05); }
        .collection-card .coll-label {
            transition: letter-spacing 0.4s ease;
        }
        .collection-card:hover .coll-label { letter-spacing: 0.2em; }

        /* ── Gold shimmer text ── */
        .gold-shimmer {
            background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 40%, var(--gold) 60%, var(--gold-light) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s linear infinite;
        }

        /* ── Hero text ── */
        .hero-italic {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 300;
        }

        /* ── Marquee ── */
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .marquee-track {
            animation: marquee 22s linear infinite;
            white-space: nowrap;
        }
        .marquee-track:hover { animation-play-state: paused; }

        /* ── Blog card ── */
        .blog-card .blog-img {
            transition: transform 0.6s ease;
        }
        .blog-card:hover .blog-img { transform: scale(1.04); }
        .blog-card .read-more {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--gold);
            font-size: 0.7rem;
            letter-spacing: 0.15em;
            opacity: 0;
            transform: translateX(-6px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .blog-card:hover .read-more {
            opacity: 1;
            transform: translateX(0);
        }

        /* ── Featured ring section ── */
        .ring-section-bg {
            background: linear-gradient(135deg, #F5F0E4 0%, #F9F6F0 60%, #EDE8DC 100%);
        }

        /* ── Button styles ── */
        .btn-outline-dark {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--charcoal);
            color: var(--charcoal);
            transition: color 0.35s ease;
        }
        .btn-outline-dark::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--charcoal);
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
            z-index: 0;
        }
        .btn-outline-dark:hover::before { transform: translateY(0); }
        .btn-outline-dark:hover { color: #fff; }
        .btn-outline-dark span { position: relative; z-index: 1; }

        .btn-gold {
            position: relative;
            overflow: hidden;
            background: var(--gold);
            color: #fff;
            transition: color 0.35s ease;
        }
        .btn-gold::before {
            content: '';
            position: absolute;
            inset: 0;
            background: #A8862E;
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-gold:hover::before { transform: translateY(0); }
        .btn-gold span { position: relative; z-index: 1; }

        .btn-outline-white {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.6);
            color: #fff;
            transition: color 0.35s ease;
        }
        .btn-outline-white::before {
            content: '';
            position: absolute;
            inset: 0;
            background: #fff;
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-outline-white:hover::before { transform: translateY(0); }
        .btn-outline-white:hover { color: var(--charcoal); }
        .btn-outline-white span { position: relative; z-index: 1; }

        /* ── Wishlist heart pulse ── */
        .wishlist-btn:active i {
            animation: pulse 0.3s ease;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.4); }
        }

        /* ── Newsletter input ── */
        .newsletter-input {
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(255,255,255,0.25);
            color: #fff;
            outline: none;
            transition: border-color 0.3s ease;
        }
        .newsletter-input:focus {
            border-bottom-color: var(--gold);
        }
        .newsletter-input::placeholder { color: rgba(255,255,255,0.35); }

        /* ── Noise overlay on hero ── */
        .noise-overlay {
            position: absolute;
            inset: 0;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* ── Mobile menu ── */
        #mobile-menu {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        #mobile-menu.open {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-cream font-jost text-charcoal overflow-x-hidden">
@php
    $currencySymbol = config('lumiere.currency_symbol');
@endphp

    <!-- ══════════════════════════════════
         NAVIGATION
    ══════════════════════════════════ -->
    <!-- Fixed navigation with scroll transformation effect -->
    <!-- Using z-50 to stay above all content, transform for scroll effects -->
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">

            <!-- Logo - links to home page -->
            <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal hover:text-soft-gold transition-colors duration-300">
                LUMIÈRE
            </a>

            <!-- Desktop navigation links -->
            <!-- Hidden on mobile, shown on md screens and up -->
            <!-- Using nav-link class for underline hover effect defined in CSS -->
            <div class="hidden md:flex items-center gap-10">
                <a href="{{ route('collections') }}" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal transition-colors duration-300 font-jost">COLLECTIONS</a>
                <a href="{{ route('shop') }}" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal transition-colors duration-300 font-jost">SHOP</a>
                <a href="{{ route('atelier') }}" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal transition-colors duration-300 font-jost">ATELIER</a>
                <a href="{{ route('journal') }}" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal transition-colors duration-300 font-jost">JOURNAL</a>
            </div>

            <!-- Right side icons: Wishlist, User Profile, Cart, Mobile Menu -->
            <div class="flex items-center gap-5">
                <!-- Wishlist button with count badge -->
                <!-- The count comes from CartController::home() which loads wishlist data -->
                <!-- Using ?? 0 as fallback to prevent errors if count isn't passed -->
                <button onclick="toggleWishlist(event)" class="wishlist-btn text-charcoal/60 hover:text-soft-gold transition-colors duration-300 relative">
                    <i class="fa-regular fa-heart text-base"></i>
                    <span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center font-jost">{{ $wishlistCount ?? 0 }}</span>
                </button>
                <!-- User profile section - conditional based on authentication -->
                @auth
                    <!-- Authenticated user: show dropdown with profile options -->
                    <!-- Using group hover for dropdown visibility -->
                    <div class="relative group">
                        <button class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300 flex items-center gap-2">
                            <i class="fa-solid fa-user text-base"></i>
                            <!-- Show user name on desktop only -->
                            <span class="text-xs font-jost hidden md:block">{{ auth()->user()->name }}</span>
                        </button>
                        <!-- Gold circle indicator for premium members -->
                        @if(auth()->user()->is_gold_circle)
                            <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-soft-gold"></span>
                        @endif
                        <!-- Dropdown menu - appears on hover -->
                        <!-- Using opacity/visibility for smooth transitions -->
                        <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-sm opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-3 text-xs text-charcoal/70 hover:text-soft-gold hover:bg-[#F9F6F0] transition-colors font-jost">My Profile</a>
                            <!-- Logout form - using POST method for security -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-xs text-charcoal/70 hover:text-soft-gold hover:bg-[#F9F6F0] transition-colors font-jost">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Guest user: simple login link -->
                    <a href="{{ route('login') }}" class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300">
                        <i class="fa-regular fa-user text-base"></i>
                    </a>
                @endif
                <!-- Cart button with count badge -->
                <!-- Count comes from CartController::home() -->
                <button onclick="toggleCart()" class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300 relative">
                    <i class="fa-solid fa-cart-shopping text-base"></i>
                    <span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center font-jost">{{ $cartCount ?? 0 }}</span>
                </button>
                <!-- Mobile menu toggle - hidden on desktop -->
                <button id="menu-open" class="md:hidden text-charcoal/70 ml-1">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Drawer -->
    <!-- Slide-out menu for mobile devices -->
    <!-- Using higher z-index than nav but lower than cart drawer -->
    <div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-cream z-[60] shadow-2xl flex flex-col px-10 py-12">
        <button id="menu-close" class="self-end text-charcoal/50 hover:text-charcoal mb-10">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
        <!-- Logo in mobile menu for brand consistency -->
        <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal mb-10 block">LUMIÈRE</a>
        <!-- Navigation links - vertical layout for mobile -->
        <div class="flex flex-col gap-7">
            <a href="{{ route('collections') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold transition-colors duration-300 font-jost">COLLECTIONS</a>
            <a href="{{ route('shop') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold transition-colors duration-300 font-jost">SHOP</a>
            <a href="{{ route('atelier') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold transition-colors duration-300 font-jost">ATELIER</a>
            <a href="{{ route('journal') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold transition-colors duration-300 font-jost">JOURNAL</a>
        </div>
        <!-- Social links at bottom of mobile menu -->
        <!-- Using mt-auto to push to bottom -->
        <div class="mt-auto flex gap-5 text-charcoal/40">
            <a href="#"><i class="fa-brands fa-instagram text-lg hover:text-soft-gold transition-colors"></i></a>
            <a href="#"><i class="fa-brands fa-pinterest text-lg hover:text-soft-gold transition-colors"></i></a>
        </div>
    </div>
    <!-- Overlay for mobile menu - darkens background when menu is open -->
    <div id="menu-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden"></div>


    <!-- ══════════════════════════════════
         HERO
    ══════════════════════════════════ -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=2070&auto=format&fit=crop"
                 alt="Elegant jewelry display"
                 class="w-full h-full object-cover animate-slow-zoom">
            <!-- Refined gradient: darkens bottom and left edges, stays light in center -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/10 to-black/60"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/20 via-transparent to-transparent"></div>
        </div>
        <div class="noise-overlay"></div>

        <!-- Content -->
        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
            <p class="text-white/60 tracking-[0.4em] text-[10px] mb-8 font-jost font-light animate-fade-up">EST. 2024 &nbsp;·&nbsp; PARIS</p>

            <h1 class="font-cormorant mb-6 animate-fade-up-2" style="font-family:'Cormorant Garamond',serif; font-weight:300;">
                <span class="block text-white text-6xl md:text-8xl lg:text-9xl leading-none tracking-tight">Timeless</span>
                <span class="block text-white text-6xl md:text-8xl lg:text-9xl leading-none italic" style="font-style:italic">Elegance</span>
            </h1>

            <span class="gold-rule animate-fade-up-3 block w-16 h-px bg-soft-gold mx-auto my-8"></span>

            <p class="text-white/75 text-base md:text-lg font-jost font-light max-w-xl mx-auto leading-relaxed tracking-wide animate-fade-up-3">
                Handcrafted jewelry that tells your story. Each piece, a celebration of life's most precious moments.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center animate-fade-up-4">
                <a href="{{ route('collections') }}" class="btn-outline-white inline-block px-9 py-3.5 text-[11px] tracking-[0.22em] font-jost font-light">
                    <span>DISCOVER COLLECTION</span>
                </a>
                <a href="{{ route('shop') }}" class="btn-gold inline-block px-9 py-3.5 text-[11px] tracking-[0.22em] font-jost font-light">
                    <span>SHOP NOW</span>
                </a>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-60">
            <span class="text-white text-[9px] tracking-[0.3em] font-jost">SCROLL</span>
            <div class="w-px h-10 bg-gradient-to-b from-white/60 to-transparent animate-pulse"></div>
        </div>
    </section>


    <!-- ══════════════════════════════════
         MARQUEE STRIP
    ══════════════════════════════════ -->
    <div class="bg-soft-gold py-3 overflow-hidden">
        <div class="marquee-track inline-flex gap-16">
            <!-- doubled for seamless loop -->
            <span class="text-white text-[10px] tracking-[0.35em] font-jost font-light">HANDCRAFTED IN PARIS</span>
            <span class="text-white/50">✦</span>
            <span class="text-white text-[10px] tracking-[0.35em] font-jost font-light">ETHICALLY SOURCED GEMSTONES</span>
            <span class="text-white/50">✦</span>
            <span class="text-white text-[10px] tracking-[0.35em] font-jost font-light">COMPLIMENTARY ENGRAVING</span>
            <span class="text-white/50">✦</span>
            <span class="text-white text-[10px] tracking-[0.35em] font-jost font-light">FREE WORLDWIDE SHIPPING</span>
            <span class="text-white/50">✦</span>
            <span class="text-white text-[10px] tracking-[0.35em] font-jost font-light">LIFETIME GUARANTEE</span>
            <span class="text-white/50">✦</span>
            <!-- repeat -->
            <span class="text-white text-[10px] tracking-[0.35em] font-jost font-light">HANDCRAFTED IN PARIS</span>
            <span class="text-white/50">✦</span>
            <span class="text-white text-[10px] tracking-[0.35em] font-jost font-light">ETHICALLY SOURCED GEMSTONES</span>
            <span class="text-white/50">✦</span>
            <span class="text-white text-[10px] tracking-[0.35em] font-jost font-light">COMPLIMENTARY ENGRAVING</span>
            <span class="text-white/50">✦</span>
            <span class="text-white text-[10px] tracking-[0.35em] font-jost font-light">FREE WORLDWIDE SHIPPING</span>
            <span class="text-white/50">✦</span>
            <span class="text-white text-[10px] tracking-[0.35em] font-jost font-light">LIFETIME GUARANTEE</span>
            <span class="text-white/50">✦</span>
        </div>
    </div>


    <!-- ══════════════════════════════════
         SIGNATURE COLLECTIONS
    ══════════════════════════════════ -->
    <section id="collections" class="py-28 px-6 md:px-12 bg-cream">
        <div class="max-w-screen-xl mx-auto">

            <div class="text-center mb-20">
                <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-4 font-jost font-light">OUR CURATIONS</p>
                <h2 class="font-playfair text-4xl md:text-5xl font-light text-charcoal mb-6 tracking-wide">Signature Collections</h2>
                <span class="gold-rule block w-16 h-px bg-soft-gold mx-auto mb-6"></span>
                <p class="text-warm-gray text-sm font-jost font-light max-w-md mx-auto leading-relaxed">
                    Each collection tells a unique story of craftsmanship, love, and timeless beauty.
                </p>
            </div>

            <!-- 3-col grid — first card taller, editorial feel -->
            <div class="grid md:grid-cols-3 gap-6">

                <!-- Card 1 - tall -->
                <div class="collection-card group cursor-pointer md:row-span-1">
                    <div class="overflow-hidden rounded-sm bg-gray-100 relative">
                        <img src="{{asset('images/collection_diamond_essence.png')}}"
                             alt="Diamond Collection"
                             class="coll-img w-full h-[480px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                            <h3 class="font-playfair text-2xl font-light mb-1">L'ÉCLAT</h3>
                            <p class="font-jost text-xs text-white/70 mb-2 tracking-wide">Diamond Collection</p>
                            <p class="coll-label text-soft-gold text-[10px] tracking-[0.15em] font-jost font-light transition-all duration-400">FROM {{ $currencySymbol }}2,800</p>
                        </div>
                    </div>
                </div>

                <!-- Cards 2 & 3 stacked -->
                <div class="md:col-span-2 grid grid-rows-2 gap-6">
                    <div class="collection-card group cursor-pointer">
                        <div class="overflow-hidden rounded-sm bg-gray-100 relative">
                            <img src="{{asset('images/collection_gold_essence.png')}}"
                                 alt="Gold Collection"
                                 class="coll-img w-full h-[228px] object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <h3 class="font-playfair text-xl font-light mb-1">L'OR</h3>
                                <p class="font-jost text-xs text-white/70 mb-1 tracking-wide">Gold Collection</p>
                                <p class="coll-label text-soft-gold text-[10px] tracking-[0.15em] font-jost font-light">FROM {{ $currencySymbol }}1,200</p>
                            </div>
                        </div>
                    </div>

                    <div class="collection-card group cursor-pointer">
                        <div class="overflow-hidden rounded-sm bg-gray-100 relative">
                            <img src="{{asset('images/collection_pearl_essence.png')}}"
                                 alt="Pearl Collection"
                                 class="coll-img w-full h-[228px] object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <h3 class="font-playfair text-xl font-light mb-1">LA PERLE</h3>
                                <p class="font-jost text-xs text-white/70 mb-1 tracking-wide">Pearl Collection</p>
                                <p class="coll-label text-soft-gold text-[10px] tracking-[0.15em] font-jost font-light">FROM {{ $currencySymbol }}900</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ══════════════════════════════════
         FEATURED PIECE
    ══════════════════════════════════ -->
    <section class="ring-section-bg py-28 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid md:grid-cols-2 gap-16 items-center">

                <!-- Text -->
                <div class="order-2 md:order-1 max-w-lg">
                    <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-6 font-jost font-light">LIMITED EDITION</p>
                    <h2 class="font-playfair text-4xl md:text-5xl font-light text-charcoal mb-2 leading-tight">
                        The Lumière<br>
                        <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">Signature Ring</span>
                    </h2>
                    <span class="block w-12 h-px bg-soft-gold mt-6 mb-8"></span>
                    <p class="text-warm-gray leading-relaxed mb-4 font-jost font-light text-sm">
                        A masterpiece of Italian craftsmanship. Featuring a flawless 2-carat diamond set in ethically sourced 18k gold. Each ring is hand-engraved and takes over 40 hours to complete.
                    </p>
                    <p class="text-warm-gray leading-relaxed mb-8 font-jost font-light text-sm">
                        Only <span class="text-charcoal font-medium">12 pieces</span> remain in this edition.
                    </p>
                    <div class="flex items-baseline gap-4 mb-10">
                        <span class="font-playfair text-3xl font-light text-charcoal">{{ $currencySymbol }}4,500</span>
                        <span class="text-sm text-warm-gray line-through font-jost">{{ $currencySymbol }}5,800</span>
                        <span class="text-xs text-soft-gold tracking-wide font-jost bg-soft-gold/10 px-2 py-1 rounded-sm">SAVE 22%</span>
                    </div>
                    <div class="flex gap-4 flex-wrap">
                        <button id="inquiry-open" type="button" class="btn-outline-dark inline-block px-8 py-3.5 text-[11px] tracking-[0.22em] font-jost">
                            <span>INQUIRE NOW</span>
                        </button>
                        <button onclick="toggleWishlist(event)" class="wishlist-btn text-charcoal/50 hover:text-soft-gold transition-colors duration-300 flex items-center gap-2 text-xs tracking-wide font-jost">
                            <i class="fa-regular fa-heart"></i> ADD TO WISHLIST
                        </button>
                    </div>
                </div>

                <!-- Image -->
                <div class="order-1 md:order-2 group">
                    <div class="overflow-hidden rounded-sm shadow-[0_30px_80px_rgba(0,0,0,0.12)]">
                        <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=2070&auto=format&fit=crop"
                             alt="Signature Ring"
                             class="w-full object-cover transition-transform duration-700 group-hover:scale-103"
                             style="transition: transform 0.8s cubic-bezier(0.25,0.46,0.45,0.94);">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ══════════════════════════════════
         SHOP / BESTSELLERS
    ══════════════════════════════════ -->
    <div id="inquiry-modal" class="fixed inset-0 z-[70] hidden items-center justify-center px-5 py-8" aria-labelledby="inquiry-title" aria-modal="true" role="dialog">
        <button id="inquiry-overlay" type="button" class="absolute inset-0 bg-charcoal/70 backdrop-blur-sm" aria-label="Close inquiry form"></button>

        <div class="relative w-full max-w-3xl max-h-[90vh] overflow-y-auto bg-cream shadow-[0_30px_100px_rgba(0,0,0,0.35)]">
            <div class="grid md:grid-cols-[0.9fr_1.1fr]">
                <div class="relative min-h-72 md:min-h-full overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=1200&auto=format&fit=crop"
                         alt="The Lumière Signature Ring"
                         class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-charcoal/70 via-charcoal/10 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <p class="text-soft-gold text-[10px] tracking-[0.3em] font-jost mb-3">LIMITED EDITION</p>
                        <h3 class="font-playfair text-3xl font-light leading-tight">The Lumière<br>Signature Ring</h3>
                    </div>
                </div>

                <div class="p-7 sm:p-10">
                    <div class="flex items-start justify-between gap-6 mb-8">
                        <div>
                            <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-3 font-jost font-light">PRIVATE INQUIRY</p>
                            <h2 id="inquiry-title" class="font-playfair text-3xl font-light text-charcoal">Reserve Your Moment</h2>
                        </div>
                        <button id="inquiry-close" type="button" class="text-charcoal/45 hover:text-soft-gold transition-colors duration-300" aria-label="Close inquiry form">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <form id="inquiry-form" class="space-y-5">
                        <div>
                            <label for="inquiry-name" class="block text-[10px] tracking-[0.24em] text-charcoal/50 font-jost mb-2">NAME</label>
                            <input id="inquiry-name" name="name" type="text" required class="w-full bg-transparent border-0 border-b border-charcoal/15 focus:border-soft-gold focus:ring-0 px-0 py-3 text-sm font-jost text-charcoal placeholder:text-charcoal/25" placeholder="Your name">
                        </div>

                        <div>
                            <label for="inquiry-email" class="block text-[10px] tracking-[0.24em] text-charcoal/50 font-jost mb-2">EMAIL</label>
                            <input id="inquiry-email" name="email" type="email" required class="w-full bg-transparent border-0 border-b border-charcoal/15 focus:border-soft-gold focus:ring-0 px-0 py-3 text-sm font-jost text-charcoal placeholder:text-charcoal/25" placeholder="you@example.com">
                        </div>

                        <div>
                            <label for="inquiry-ring-size" class="block text-[10px] tracking-[0.24em] text-charcoal/50 font-jost mb-2">RING SIZE</label>
                            <select id="inquiry-ring-size" name="ring_size" required class="w-full bg-transparent border-0 border-b border-charcoal/15 focus:border-soft-gold focus:ring-0 px-0 py-3 text-sm font-jost text-charcoal">
                                <option value="">Select a size</option>
                                <option value="4">US 4</option>
                                <option value="5">US 5</option>
                                <option value="6">US 6</option>
                                <option value="7">US 7</option>
                                <option value="8">US 8</option>
                                <option value="9">US 9</option>
                                <option value="custom">Custom sizing</option>
                            </select>
                        </div>

                        <div>
                            <label for="inquiry-question" class="block text-[10px] tracking-[0.24em] text-charcoal/50 font-jost mb-2">QUESTION</label>
                            <textarea id="inquiry-question" name="question" rows="4" required class="w-full bg-transparent border-0 border-b border-charcoal/15 focus:border-soft-gold focus:ring-0 px-0 py-3 text-sm font-jost text-charcoal placeholder:text-charcoal/25 resize-none" placeholder="Ask about availability, sizing, or a private viewing."></textarea>
                        </div>

                        <button type="submit" class="btn-gold w-full px-8 py-3.5 text-[11px] tracking-[0.24em] font-jost">
                            <span>SEND INQUIRY</span>
                        </button>
                    </form>

                    <div id="inquiry-success" class="p-8 text-center hidden">
                        <div class="success-circle w-16 h-16 rounded-full border border-soft-gold/30 flex items-center justify-center mx-auto mb-6">
                            <svg width="28" height="28" viewBox="0 0 32 32" fill="none">
                                <path d="M6 16L13 23L26 9" stroke="#C9A84C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="success-check"/>
                            </svg>
                        </div>
                        <p class="text-soft-gold text-[9px] tracking-[0.35em] font-jost mb-2">INQUIRY SENT</p>
                        <h3 class="font-playfair text-xl font-light text-charcoal mb-3">Thank you, <span id="success-name-display"></span></h3>
                        <p class="text-warm-gray text-xs font-jost font-light leading-relaxed mb-6">
                            Your inquiry about the <span class="text-charcoal font-medium">Lumière Signature Ring</span> has been received.
                            Our atelier team will respond within <strong>24 hours</strong>.
                        </p>
                        <div class="bg-deep-ivory p-4 text-left mb-6">
                            <p class="text-[8px] tracking-[0.2em] text-charcoal/40 font-jost mb-2">WHAT HAPPENS NEXT?</p>
                            <ul class="space-y-2 text-[11px] font-jost text-charcoal/70">
                                <li class="flex items-center gap-2"><i class="fa-solid fa-envelope text-soft-gold text-[9px]"></i> You'll receive a confirmation email</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-comment text-soft-gold text-[9px]"></i> A consultant will reach out directly</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-gem text-soft-gold text-[9px]"></i> We'll check availability &amp; sizing</li>
                            </ul>
                        </div>
                        <button id="inquiry-return" type="button" class="btn-outline-dark w-full py-3.5 text-[10px] tracking-[0.22em] font-jost bg-transparent">
                            <span>CONTINUE BROWSING</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="shop" class="py-28 px-6 md:px-12 bg-white">
        <div class="max-w-screen-xl mx-auto">

            <div class="text-center mb-20">
                <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-4 font-jost font-light">BESTSELLERS</p>
                <h2 class="font-playfair text-4xl md:text-5xl font-light text-charcoal mb-6 tracking-wide">Treasures You'll Adore</h2>
                <span class="gold-rule block w-16 h-px bg-soft-gold mx-auto"></span>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $index => $product)
                <a href="{{ route('product.show', $product) }}" class="product-card group block">
                    <div class="relative overflow-hidden bg-deep-ivory rounded-sm mb-5 aspect-[3/4]">
                        <img src="{{ $product->primaryImage?->image_url ?? 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=1931&auto=format&fit=crop' }}"
                             alt="{{ $product->name }}"
                             class="card-img w-full h-full object-cover">
                        <!-- Overlay -->
                        <div class="overlay absolute inset-0 bg-black/20 flex items-end justify-center pb-6">
                            <button data-product-id="{{ $product->id }}" onclick="addToCart(event, null, 1)" class="bg-white text-charcoal text-[10px] tracking-[0.2em] font-jost px-6 py-2.5 hover:bg-soft-gold hover:text-white transition-colors duration-300">
                                QUICK ADD
                            </button>
                        </div>
                        <!-- Wishlist -->
                        <button data-product-id="{{ $product->id }}" onclick="toggleWishlist(event, {{ $product->id }})" class="wishlist-btn absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-charcoal/60 hover:text-soft-gold transition-colors duration-300 opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fa-regular fa-heart text-xs"></i>
                        </button>
                        @if($index === 1)
                        <span class="absolute top-3 left-3 bg-soft-gold text-white text-[9px] tracking-[0.15em] font-jost px-2 py-1">NEW</span>
                        @elseif($index === 3)
                        <span class="absolute top-3 left-3 bg-charcoal text-white text-[9px] tracking-[0.15em] font-jost px-2 py-1">LAST FEW</span>
                        @endif
                    </div>
                    <h3 class="font-playfair text-base font-light text-charcoal mb-1">{{ $product->name }}</h3>
                    <p class="text-warm-gray text-xs font-jost font-light mb-2 tracking-wide">{{ $product->collection?->name ?? 'LUMIÈRE' }}</p>
                    <p class="text-soft-gold text-sm font-jost">{{ $currencySymbol }}{{ number_format($product->price, 2) }}</p>
                </a>
                @endforeach
                @if($featuredProducts->count() < 4)
                    @for($i = $featuredProducts->count(); $i < 4; $i++)
                    <div class="product-card group cursor-pointer opacity-50">
                        <div class="relative overflow-hidden bg-deep-ivory rounded-sm mb-5 aspect-[3/4]">
                            <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=1931&auto=format&fit=crop"
                                 alt="Coming Soon"
                                 class="card-img w-full h-full object-cover">
                        </div>
                        <h3 class="font-playfair text-base font-light text-charcoal mb-1">More Coming Soon</h3>
                        <p class="text-warm-gray text-xs font-jost font-light mb-2 tracking-wide">LUMIÈRE</p>
                        <p class="text-soft-gold text-sm font-jost">--</p>
                    </div>
                    @endfor
                @endif
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('collections') }}" class="btn-outline-dark inline-block px-10 py-3.5 text-[11px] tracking-[0.22em] font-jost">
                    <span>VIEW ALL COLLECTION</span>
                </a>
            </div>
        </div>
    </section>


    <!-- ══════════════════════════════════
         ABOUT / STORY
    ══════════════════════════════════ -->
    <section id="about" class="relative py-28 px-6 md:px-12 overflow-hidden">
        <!-- Background image with heavy overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1506630448388-4e683c67ddb0?q=80&w=2070&auto=format&fit=crop"
                 alt="Atelier"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-charcoal/85"></div>
        </div>

        <div class="relative z-10 max-w-3xl mx-auto text-center">
            <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-6 font-jost font-light">OUR STORY</p>
            <h2 class="font-playfair text-4xl md:text-5xl font-light text-white mb-6 leading-tight">
                Craftsmanship Passed<br>
                <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">Through Generations</span>
            </h2>
            <span class="block w-16 h-px bg-soft-gold mx-auto mb-10"></span>
            <p class="text-white/65 leading-relaxed mb-5 font-jost font-light text-sm max-w-2xl mx-auto">
                Founded in Paris, Lumière has been creating heirloom-quality jewelry since 2024. We believe that true luxury lies in the details — the cut of a diamond, the curve of a setting, the sparkle in a loved one's eye.
            </p>
            <p class="text-white/65 leading-relaxed mb-10 font-jost font-light text-sm max-w-2xl mx-auto">
                Every piece is ethically sourced and handcrafted by master artisans who share our passion for timeless elegance.
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-8 max-w-lg mx-auto mb-12 border-t border-white/10 pt-10">
                <div class="text-center">
                    <p class="font-playfair text-3xl text-white font-light mb-1">200+</p>
                    <p class="text-white/40 text-[10px] tracking-[0.2em] font-jost">PIECES CRAFTED</p>
                </div>
                <div class="text-center border-x border-white/10">
                    <p class="font-playfair text-3xl text-white font-light mb-1">40h</p>
                    <p class="text-white/40 text-[10px] tracking-[0.2em] font-jost">PER PIECE</p>
                </div>
                <div class="text-center">
                    <p class="font-playfair text-3xl text-white font-light mb-1">18k</p>
                    <p class="text-white/40 text-[10px] tracking-[0.2em] font-jost">GOLD STANDARD</p>
                </div>
            </div>

            <a href="{{ route('atelier') }}" class="btn-gold inline-block px-10 py-3.5 text-[11px] tracking-[0.22em] font-jost">
                <span>LEARN MORE ABOUT US</span>
            </a>
        </div>
    </section>


    <!-- ══════════════════════════════════
         JOURNAL
    ══════════════════════════════════ -->
    <section id="journal" class="py-28 px-6 md:px-12 bg-cream">
        <div class="max-w-screen-xl mx-auto">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-16 gap-4">
                <div>
                    <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-4 font-jost font-light">FROM OUR JOURNAL</p>
                    <h2 class="font-playfair text-4xl md:text-5xl font-light text-charcoal tracking-wide">Stories &amp; Inspiration</h2>
                </div>
                <a href="{{ route('journal') }}" class="text-[10px] tracking-[0.22em] font-jost text-charcoal/50 hover:text-soft-gold transition-colors duration-300 border-b border-charcoal/20 pb-0.5 self-start md:self-auto">VIEW ALL ARTICLES</a>
            </div>

            <div class="grid md:grid-cols-3 gap-8">

                <!-- Article 1 — large -->
                <a href="{{ route('post.show', 'ultimate-diamond-buying-guide') }}" class="blog-card group block md:col-span-1">
                    <div class="overflow-hidden rounded-sm bg-gray-100 mb-5">
                        <img src="https://images.unsplash.com/photo-1530968033775-2c92736b131e?q=80&w=2071&auto=format&fit=crop"
                             alt="Diamond Guide"
                             class="blog-img w-full h-72 object-cover">
                    </div>
                    <p class="text-soft-gold text-[10px] tracking-[0.2em] mb-2 font-jost">APRIL 25, 2026 &nbsp;·&nbsp; GUIDES</p>
                    <h3 class="font-playfair text-xl font-light text-charcoal mb-3 leading-snug">The Ultimate Diamond Buying Guide</h3>
                    <p class="text-warm-gray text-xs font-jost font-light leading-relaxed mb-4">
                        Everything you need to know before investing in your perfect diamond.
                    </p>
                    <span class="read-more font-jost font-light">READ MORE <i class="fa-solid fa-arrow-right text-[10px]"></i></span>
                </a>

                <a href="{{ route('post.show', 'commitment-sustainability') }}" class="blog-card group block">
                    <div class="overflow-hidden rounded-sm bg-gray-100 mb-5">
                        <img src="{{asset('images/virtues.png')}}"
                             alt="Sustainable Jewelry"
                             class="blog-img w-full h-72 object-cover">
                    </div>
                    <p class="text-soft-gold text-[10px] tracking-[0.2em] mb-2 font-jost">APRIL 18, 2026 &nbsp;·&nbsp; ETHICS</p>
                    <h3 class="font-playfair text-xl font-light text-charcoal mb-3 leading-snug">Our Commitment to Sustainability</h3>
                    <p class="text-warm-gray text-xs font-jost font-light leading-relaxed mb-4">
                        How we're creating beautiful jewelry while protecting our planet.
                    </p>
                    <span class="read-more font-jost font-light">READ MORE <i class="fa-solid fa-arrow-right text-[10px]"></i></span>
                </a>

                <a href="{{ route('post.show', 'jewelry-care-101') }}" class="blog-card group block">
                    <div class="overflow-hidden rounded-sm bg-gray-100 mb-5">
                        <img src="https://images.unsplash.com/photo-1599643477877-530eb83abc8e?q=80&w=2070&auto=format&fit=crop"
                             alt="Care Guide"
                             class="blog-img w-full h-72 object-cover">
                    </div>
                    <p class="text-soft-gold text-[10px] tracking-[0.2em] mb-2 font-jost">APRIL 12, 2026 &nbsp;·&nbsp; CARE</p>
                    <h3 class="font-playfair text-xl font-light text-charcoal mb-3 leading-snug">Jewelry Care 101</h3>
                    <p class="text-warm-gray text-xs font-jost font-light leading-relaxed mb-4">
                        Tips to keep your precious pieces shining for generations.
                    </p>
                    <span class="read-more font-jost font-light">READ MORE <i class="fa-solid fa-arrow-right text-[10px]"></i></span>
                </a>

            </div>
        </div>
    </section>


    <!-- ══════════════════════════════════
         NEWSLETTER
    ══════════════════════════════════ -->
    <section class="py-24 px-6 md:px-12 bg-charcoal">
        <div class="max-w-xl mx-auto text-center">
            <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-6 font-jost font-light">INNER CIRCLE</p>
            <h2 class="font-playfair text-4xl md:text-5xl font-light text-white mb-4 leading-tight">
                Join Our<br>
                <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">Inner Circle</span>
            </h2>
            <span class="block w-16 h-px bg-soft-gold mx-auto my-8"></span>
            <p class="text-white/50 font-jost font-light text-sm mb-10 leading-relaxed">
                Be the first to discover new collections, exclusive offers, and jewelry insights.
            </p>
            <!-- Minimal newsletter — no form tag, uses flex row -->
            <form id="newsletter-home-form" action="{{ route('newsletter') }}" method="POST" class="mb-6">
                @csrf
                <input type="hidden" name="source" value="newsletter_footer">
            <div class="flex gap-0 max-w-sm mx-auto border-b border-white/20 pb-0 mb-6">
                <input type="email"
                       name="email"
                       required
                       placeholder="Your email address"
                       class="newsletter-input flex-1 py-3 px-1 text-sm font-jost font-light bg-transparent text-white outline-none">
                <button type="submit" class="text-soft-gold text-[10px] tracking-[0.25em] font-jost font-light hover:text-gold-light transition-colors duration-300 pb-3 pl-4 whitespace-nowrap">
                    SUBSCRIBE →
                </button>
            </div>
            </form>
            <p id="newsletter-home-message" class="hidden text-soft-gold text-xs font-jost mb-6"></p>
            <p class="text-white/25 text-[10px] font-jost tracking-wide">By subscribing, you agree to our Privacy Policy.</p>
        </div>
    </section>


    <!-- ══════════════════════════════════
         FOOTER
    ══════════════════════════════════ -->
    <footer class="bg-[#161616] pt-16 pb-8 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-16">

                <div>
                    <h3 class="font-playfair text-2xl font-light text-white mb-4 tracking-widest">LUMIÈRE</h3>
                    <p class="text-white/35 text-xs font-jost font-light leading-relaxed max-w-[180px]">
                        Timeless elegance crafted for the discerning soul.
                    </p>
                </div>

                <div>
                    <h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">SHOP</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('shop', ['category' => 'necklace']) }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">Necklaces</a></li>
                        <li><a href="{{ route('shop', ['category' => 'ring']) }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">Rings</a></li>
                        <li><a href="{{ route('shop', ['category' => 'earrings']) }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">Earrings</a></li>
                        <li><a href="{{ route('shop', ['category' => 'bracelet']) }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">Bracelets</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">SUPPORT</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('contact') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">Contact Us</a></li>
                        <li><a href="{{ route('faq') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">FAQs</a></li>
                        <li><a href="{{ route('shipping') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">Shipping & Returns</a></li>
                        <li><a href="{{ route('size-guide') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">Size Guide</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">FOLLOW</h4>
                    <div class="flex gap-5">
                        <a href="#" class="text-white/35 hover:text-soft-gold transition-colors duration-300"><i class="fa-brands fa-instagram text-base"></i></a>
                        <a href="#" class="text-white/35 hover:text-soft-gold transition-colors duration-300"><i class="fa-brands fa-pinterest text-base"></i></a>
                        <a href="#" class="text-white/35 hover:text-soft-gold transition-colors duration-300"><i class="fa-brands fa-facebook-f text-base"></i></a>
                        <a href="#" class="text-white/35 hover:text-soft-gold transition-colors duration-300"><i class="fa-brands fa-x-twitter text-base"></i></a>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center gap-3">
                <p class="text-white/20 text-[10px] font-jost font-light tracking-wide">© 2026 Lumière Jewelry. All rights reserved.</p>
                <p class="text-white/20 text-[10px] font-jost font-light tracking-wide">Crafted with elegance in Paris.</p>
            </div>
        </div>
    </footer>


    <!-- ══════════════════════════════════
         JS — Nav scroll + Mobile menu
    ══════════════════════════════════ -->
    <script>
        // Nav scroll
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 60);
        });

        // Mobile menu
        const openBtn = document.getElementById('menu-open');
        const closeBtn = document.getElementById('menu-close');
        const mobileMenu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('menu-overlay');

        function openMenu() {
            mobileMenu.classList.add('open');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeMenu() {
            mobileMenu.classList.remove('open');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        if (openBtn) openBtn.addEventListener('click', openMenu);
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        if (overlay) overlay.addEventListener('click', closeMenu);

        // Close on nav link click (mobile)
        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        const inquiryOpen = document.getElementById('inquiry-open');
        const inquiryModal = document.getElementById('inquiry-modal');
        const inquiryOverlay = document.getElementById('inquiry-overlay');
        const inquiryClose = document.getElementById('inquiry-close');
        const inquiryForm = document.getElementById('inquiry-form');
        const inquirySuccess = document.getElementById('inquiry-success');
        const inquiryReturn = document.getElementById('inquiry-return');
        const inquiryName = document.getElementById('inquiry-name');
        const successNameDisplay = document.getElementById('success-name-display');

        function openInquiryModal() {
            inquiryForm.reset();
            inquiryForm.classList.remove('hidden');
            inquirySuccess.classList.add('hidden');
            inquiryModal.classList.remove('hidden');
            inquiryModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            inquiryName.focus();
        }

        function closeInquiryModal() {
            inquiryModal.classList.add('hidden');
            inquiryModal.classList.remove('flex');
            document.body.style.overflow = '';
            inquiryOpen.focus();
        }

        if (inquiryOpen && inquiryModal && inquiryOverlay && inquiryClose && inquiryReturn && inquiryForm && inquirySuccess && inquiryName && successNameDisplay) {
            inquiryOpen.addEventListener('click', openInquiryModal);
            inquiryOverlay.addEventListener('click', closeInquiryModal);
            inquiryClose.addEventListener('click', closeInquiryModal);
            inquiryReturn.addEventListener('click', closeInquiryModal);

            inquiryForm.addEventListener('submit', event => {
                event.preventDefault();
                successNameDisplay.textContent = inquiryName.value.trim() || 'there';
                inquiryForm.classList.add('hidden');
                inquirySuccess.classList.remove('hidden');
                inquiryReturn.focus();
            });
        }

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && !inquiryModal.classList.contains('hidden')) {
                closeInquiryModal();
            }
        });
    </script>

    <!-- CART DRAWER COMPONENT (loaded from partial) -->

    <script>
        // Wishlist functionality
        function toggleWishlist(eventOrProductId = null, productId = null) {
            let event = null;
            if (eventOrProductId instanceof Event) {
                event = eventOrProductId;
            } else {
                productId = eventOrProductId;
            }

            // If no productId provided, redirect to wishlist page
            if (!productId) {
                window.location.href = '/wishlist';
                return;
            }
            
            fetch('/wishlist/add', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update wishlist count
                    const wishlistCount = document.querySelector('.wishlist-btn .fa-heart').nextElementSibling;
                    if (wishlistCount) {
                        wishlistCount.textContent = data.count || 1;
                    }
                    // Toggle heart icon
                    const heartButton = event?.target?.closest('.wishlist-btn');
                    const heartIcon = heartButton?.querySelector('i');
                    if (heartIcon) {
                        heartIcon.classList.toggle('fa-regular');
                        heartIcon.classList.toggle('fa-solid');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // ── QUICK ADD AJAX FUNCTION ──────────────────────────────────────
        // Quick add for product grid - adds item with quantity 1 without page reload
        // Used on home page and shop page product cards
        function quickAdd(productId) {
            // Make AJAX request to cart add API
            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    // Tell server we're sending and expecting JSON
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    // Mark as AJAX request
                    'X-Requested-With': 'XMLHttpRequest',
                    // Include CSRF token for security
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                // Send product ID with quantity 1 (default for quick add)
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => {
                // Handle HTTP errors with detailed error message
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                // Update cart count badges if API provides count
                if (typeof data.cart_count !== 'undefined') {
                    // Update all cart count badges in navigation
                    document.querySelectorAll('#cart-count, [data-cart-count], button[onclick*="toggleCart"] span').forEach((badge) => {
                        badge.textContent = data.cart_count;
                    });
                } else {
                    // Fallback: manually update cart count if API doesn't provide it
                    updateCartCount();
                }
            })
            .catch(error => {
                // Log error for debugging (no user-facing error for quick add)
                console.error('Error:', error);
            });
        }

        // ── NEWSLETTER SUBSCRIPTION AJAX ───────────────────────────────────
        // Handle newsletter form submission without page reload
        const newsletterHomeForm = document.getElementById('newsletter-home-form');
        if (newsletterHomeForm) {
            newsletterHomeForm.addEventListener('submit', async (event) => {
                // Prevent default form submission
                event.preventDefault();
                
                // Send form data via AJAX
                const response = await fetch(newsletterHomeForm.action, {
                    method: 'POST',
                    headers: {
                        // Expect JSON response from server
                        'Accept': 'application/json',
                        // Include CSRF token
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    // Send form data as FormData (handles file uploads if any)
                    body: new FormData(newsletterHomeForm),
                });
                
                // Parse JSON response
                const data = await response.json();
                
                // Show success message to user
                const message = document.getElementById('newsletter-home-message');
                if (message) {
                    message.textContent = data.message ?? 'Thank you for subscribing!';
                    message.classList.remove('hidden');
                }
                newsletterHomeForm.classList.add('hidden');
            });
        }
    </script>

    @include('partials.cart-drawer')

</body>
</html>
