<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} | LUMIÈRE Fine Jewelry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F9F6F0', 'soft-gold': '#C9A84C', 'gold-light': '#E8C97A',
                        'deep-ivory': '#F2EDE4', charcoal: '#1C1C1C', 'warm-gray': '#8A8580',
                    },
                    fontFamily: {
                        'playfair': ['"Playfair Display"', 'serif'],
                        'cormorant': ['"Cormorant Garamond"', 'serif'],
                        'jost': ['Jost', 'sans-serif'],
                    },
                    keyframes: {
                        fadeUp: { '0%': { opacity:'0', transform:'translateY(20px)' }, '100%': { opacity:'1', transform:'translateY(0)' } },
                        shimmer: { '0%': { backgroundPosition:'-200% center' }, '100%': { backgroundPosition:'200% center' } },
                    },
                    animation: {
                        'fade-up':   'fadeUp 0.8s ease both',
                        'fade-up-2': 'fadeUp 0.8s ease 0.12s both',
                        'fade-up-3': 'fadeUp 0.8s ease 0.24s both',
                        'shimmer':   'shimmer 4s linear infinite',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Jost:wght@200;300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --gold:#C9A84C; --gold-light:#E8C97A; --cream:#F9F6F0; --charcoal:#1C1C1C; --ivory:#F2EDE4; }
        ::-webkit-scrollbar{width:5px} ::-webkit-scrollbar-track{background:var(--cream)} ::-webkit-scrollbar-thumb{background:var(--gold);border-radius:4px}
        ::selection{background:var(--gold);color:#fff} html{scroll-behavior:smooth}

        #main-nav{transition:padding .4s ease,background .4s ease,box-shadow .4s ease}
        #main-nav.scrolled{padding-top:.75rem;padding-bottom:.75rem;background:rgba(249,246,240,.97);box-shadow:0 1px 24px rgba(0,0,0,.06)}
        .nav-link{position:relative}
        .nav-link::after{content:'';position:absolute;bottom:-3px;left:0;width:0;height:1px;background:var(--gold);transition:width .3s ease}
        .nav-link:hover::after,.nav-link.active::after{width:100%}

        .thumb{cursor:pointer;transition:opacity .25s,border-color .25s}
        .thumb:hover{opacity:.85}
        .thumb.active{border-color:var(--gold) !important}

        .size-btn{border:1px solid rgba(28,28,28,.15);font-family:'Jost',sans-serif;font-size:.7rem;letter-spacing:.1em;padding:.5rem .85rem;cursor:pointer;transition:all .25s ease}
        .size-btn:hover,.size-btn.active{border-color:var(--gold);color:var(--gold);background:rgba(201,168,76,.06)}
        .size-btn.unavailable{opacity:.3;cursor:not-allowed;text-decoration:line-through;pointer-events:none}

        .qty-btn{width:36px;height:36px;border:1px solid rgba(28,28,28,.12);display:flex;align-items:center;justify-content:center;cursor:pointer;font-family:'Jost',sans-serif;transition:border-color .2s,color .2s}
        .qty-btn:hover{border-color:var(--gold);color:var(--gold)}
        .qty-input{width:44px;height:36px;border:none;border-top:1px solid rgba(28,28,28,.12);border-bottom:1px solid rgba(28,28,28,.12);text-align:center;font-family:'Jost',sans-serif;font-size:.8rem;background:transparent;outline:none}

        .accord-body{max-height:0;overflow:hidden;transition:max-height .4s ease,padding .4s ease}
        .accord-body.open{max-height:400px;padding-top:.75rem}
        .accord-icon{transition:transform .3s ease}
        .accord-item.open .accord-icon{transform:rotate(45deg)}

        .btn-gold{position:relative;overflow:hidden;background:var(--gold);color:#fff;transition:color .3s}
        .btn-gold::before{content:'';position:absolute;inset:0;background:#A8862E;transform:translateY(100%);transition:transform .32s cubic-bezier(.4,0,.2,1)}
        .btn-gold:hover:not(:disabled)::before{transform:translateY(0)}
        .btn-gold span{position:relative;z-index:1}
        .btn-gold:disabled{opacity:.6;cursor:not-allowed}

        .btn-outline-dark{position:relative;overflow:hidden;border:1px solid var(--charcoal);color:var(--charcoal);transition:color .3s}
        .btn-outline-dark::before{content:'';position:absolute;inset:0;background:var(--charcoal);transform:translateY(100%);transition:transform .32s cubic-bezier(.4,0,.2,1)}
        .btn-outline-dark:hover::before{transform:translateY(0)}
        .btn-outline-dark:hover{color:#fff}
        .btn-outline-dark span{position:relative;z-index:1}

        .gold-shimmer{background:linear-gradient(90deg,var(--gold) 0%,var(--gold-light) 40%,var(--gold) 60%,var(--gold-light) 100%);background-size:200% auto;-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;animation:shimmer 4s linear infinite}

        .rel-card .rel-img{transition:transform .7s cubic-bezier(.25,.46,.45,.94)}
        .rel-card:hover .rel-img{transform:scale(1.06)}
        .rel-card .rel-overlay{opacity:0;transform:translateY(6px);transition:opacity .3s,transform .3s}
        .rel-card:hover .rel-overlay{opacity:1;transform:translateY(0)}

        .reveal{opacity:0;transform:translateY(24px);transition:opacity .7s ease,transform .7s ease}
        .reveal.visible{opacity:1;transform:translateY(0)}

        #zoom-overlay{opacity:0;pointer-events:none;transition:opacity .3s}
        #zoom-overlay.open{opacity:1;pointer-events:all}

        #mobile-menu{transform:translateX(100%);transition:transform .4s cubic-bezier(.4,0,.2,1)}
        #mobile-menu.open{transform:translateX(0)}

        #sticky-bar{transform:translateY(100%);transition:transform .4s ease}
        #sticky-bar.visible{transform:translateY(0)}

        /* ── TOAST (replaces all alert() calls) ── */
        #toast {
            position: fixed; bottom: 28px; left: 50%;
            transform: translateX(-50%) translateY(80px);
            z-index: 999;
            background: var(--charcoal); color: #fff;
            padding: 13px 22px;
            display: flex; align-items: center; gap: 10px;
            font-family: 'Jost', sans-serif;
            font-size: .72rem; letter-spacing: .06em; font-weight: 300;
            border-left: 2px solid var(--gold);
            opacity: 0; white-space: nowrap;
            transition: transform .4s cubic-bezier(.34,1.56,.64,1), opacity .4s;
            pointer-events: none;
        }
        #toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }
        #toast i { color: var(--gold); }

        /* Wishlist heart toggled */
        .wishlist-btn.wishlisted i { font-weight: 900; color: var(--gold); }
        .wishlist-btn.wishlisted { border-color: rgba(201,168,76,.4); }
    </style>
</head>
<body class="bg-cream font-jost text-charcoal overflow-x-hidden" data-product-id="{{ $product->id }}">

    <!-- TOAST — replaces every alert() -->
    <div id="toast"><i id="toast-icon" class="fa-solid fa-check"></i><span id="toast-msg">Done</span></div>

    <!-- NAV -->
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">
            <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal hover:text-soft-gold transition-colors duration-300">LUMIÈRE</a>
            <div class="hidden md:flex items-center gap-10">
                <a href="{{ route('collections') }}" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal font-jost">COLLECTIONS</a>
                <a href="{{ route('shop') }}"        class="nav-link active text-xs tracking-[0.18em] text-charcoal font-jost">SHOP</a>
                <a href="{{ route('atelier') }}"     class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal font-jost">ABOUT</a>
                <a href="{{ route('journal') }}"     class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal font-jost">JOURNAL</a>
            </div>
            <div class="flex items-center gap-5">
                @auth
                    <div class="relative group">
                        <button class="text-charcoal/60 hover:text-soft-gold transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-user text-base"></i>
                            <span class="text-xs font-jost hidden md:block">{{ auth()->user()->name }}</span>
                        </button>
                        @if(auth()->user()->is_gold_circle)
                            <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-soft-gold"></span>
                        @endif
                        <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-sm opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-3 text-xs text-charcoal/70 hover:text-soft-gold hover:bg-[#F9F6F0] transition-colors font-jost">My Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-xs text-charcoal/70 hover:text-soft-gold hover:bg-[#F9F6F0] transition-colors font-jost">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-charcoal/60 hover:text-soft-gold transition-colors">
                        <i class="fa-regular fa-user text-base"></i>
                    </a>
                @endif

                {{-- Wishlist — links to wishlist page; no product ID at nav level --}}
                <a href="{{ route('wishlist.index') }}" class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300 relative">
                    <i class="fa-regular fa-heart text-base"></i>
                    <span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center font-jost">{{ $wishlistCount ?? 0 }}</span>
                </a>

                {{-- Cart — single definition, uses stable ID --}}
                <button onclick="toggleCart()" class="text-charcoal/60 hover:text-soft-gold transition-colors relative">
                    <i class="fa-solid fa-cart-shopping text-base"></i>
                    <span id="cart-count" class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center">{{ $cartCount ?? 0 }}</span>
                </button>

                <button id="menu-open" class="md:hidden text-charcoal/70 ml-1"><i class="fa-solid fa-bars text-lg"></i></button>
            </div>
        </div>
    </nav>

    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-cream z-[60] shadow-2xl flex flex-col px-10 py-12">
        <button id="menu-close" class="self-end text-charcoal/50 hover:text-charcoal mb-10"><i class="fa-solid fa-xmark text-xl"></i></button>
        <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal mb-10 block">LUMIÈRE</a>
        <div class="flex flex-col gap-7">
            <a href="{{ route('collections') }}" class="mobile-nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold font-jost">COLLECTIONS</a>
            <a href="{{ route('shop') }}"        class="text-xs tracking-[0.18em] text-soft-gold font-jost">SHOP</a>
            <a href="{{ route('atelier') }}"     class="mobile-nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold font-jost">ABOUT</a>
            <a href="{{ route('journal') }}"     class="mobile-nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold font-jost">JOURNAL</a>
        </div>
        <div class="mt-auto flex gap-5 text-charcoal/40">
            <a href="#"><i class="fa-brands fa-instagram text-lg hover:text-soft-gold transition-colors"></i></a>
            <a href="#"><i class="fa-brands fa-pinterest text-lg hover:text-soft-gold transition-colors"></i></a>
        </div>
    </div>
    <div id="menu-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden"></div>

    <!-- BREADCRUMB -->
    <div class="pt-28 pb-0 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto flex items-center gap-3">
            <a href="{{ route('home') }}"  class="text-[10px] tracking-[0.2em] font-jost text-warm-gray hover:text-soft-gold transition-colors">HOME</a>
            <span class="text-soft-gold/40 text-[10px]">✦</span>
            <a href="{{ route('shop') }}"  class="text-[10px] tracking-[0.2em] font-jost text-warm-gray hover:text-soft-gold transition-colors">SHOP</a>
            <span class="text-soft-gold/40 text-[10px]">✦</span>
            <span class="text-[10px] tracking-[0.2em] font-jost text-charcoal">{{ $product->name }}</span>
        </div>
    </div>

    @php
        $currencySymbol = config('lumiere.currency_symbol');
        $galleryImages  = $product->images->isNotEmpty()
            ? $product->images
            : ($product->primaryImage ? collect([$product->primaryImage]) : collect());
        $mainImage      = $galleryImages->first()?->image_url
            ?? 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=2188&auto=format&fit=crop';
        $relatedFallback = 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=600&auto=format&fit=crop';

        // FIX 6: stock-based badge logic
        $totalStock = $product->variants->sum('stock');
        $showLastFew = $totalStock > 0 && $totalStock <= 3;
        $showNew     = !$showLastFew && $product->sort_order <= 5;

        // FIX 5: variants grouped by type
        $variantsByType = $product->variants->groupBy('type');
    @endphp

    <!-- PRODUCT DETAIL -->
    <section class="py-12 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 xl:gap-20 items-start">

                <!-- LEFT — Image gallery -->
                <div class="animate-fade-up">
                    <div class="relative overflow-hidden rounded-sm bg-deep-ivory mb-4 group" style="aspect-ratio:4/5">
                        <img id="main-img"
                             src="{{ $mainImage }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover cursor-zoom-in"
                             style="transition:transform .8s cubic-bezier(.25,.46,.45,.94)"
                             onclick="openZoom(this.src)">

                        {{-- FIX 6: conditional badge --}}
                        @if($showLastFew)
                            <span class="absolute top-4 left-4 bg-charcoal text-white text-[9px] tracking-[0.15em] font-jost px-3 py-1.5">LAST FEW</span>
                        @elseif($showNew)
                            <span class="absolute top-4 left-4 bg-soft-gold text-white text-[9px] tracking-[0.15em] font-jost px-3 py-1.5">NEW</span>
                        @endif

                        <div class="absolute bottom-4 right-4 bg-white/80 backdrop-blur-sm text-[9px] tracking-[0.15em] font-jost text-charcoal/60 px-3 py-1.5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass mr-1"></i>ZOOM
                        </div>
                    </div>

                    {{-- FIX 8: only render thumbnail grid when more than one image --}}
                    @if($galleryImages->count() > 1)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($galleryImages->take(4) as $image)
                                <div class="thumb border-2 rounded-sm overflow-hidden aspect-square bg-deep-ivory {{ $loop->first ? 'active border-soft-gold' : 'border-transparent' }}"
                                     onclick="switchImg(this, '{{ $image->image_url }}')">
                                    <img src="{{ $image->image_url }}" class="w-full h-full object-cover" loading="lazy">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- RIGHT — Product info -->
                <div class="lg:sticky lg:top-28">

                    <a href="{{ route('collections') }}" class="inline-flex items-center gap-2 text-[10px] tracking-[0.3em] font-jost text-soft-gold hover:text-gold-light transition-colors mb-5 animate-fade-up">
                        {{ $product->collection?->name ?? ucwords(str_replace('-', ' ', $product->category)) }}
                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                    </a>

                    <h1 class="font-playfair text-4xl md:text-5xl font-light text-charcoal leading-tight mb-2 animate-fade-up-2">{{ $product->name }}</h1>
                    <p class="text-warm-gray text-sm font-jost font-light tracking-wide mb-5 animate-fade-up-2">
                        {{ ucwords(str_replace('-', ' ', $product->category)) }} · {{ $product->collection?->name ?? 'Fine Jewelry' }}
                    </p>

                    <div class="flex items-baseline gap-4 mb-6 animate-fade-up-2">
                        <span class="font-playfair text-3xl text-charcoal font-light">{{ $currencySymbol }}{{ number_format($product->price, 2) }}</span>
                        @if($showLastFew)
                            <span class="text-xs text-soft-gold tracking-wide font-jost bg-soft-gold/10 px-2 py-1">LAST FEW</span>
                        @endif
                    </div>

                    <span class="block w-10 h-px bg-soft-gold mb-7 animate-fade-up-2"></span>

                    <p class="text-warm-gray font-jost font-light text-sm leading-relaxed mb-8 animate-fade-up-3">
                        {{ $product->description }}
                    </p>

                    {{-- FIX 5: dynamic variants from DB, grouped by type --}}
                    @foreach($variantsByType as $type => $variants)
                        <div class="mb-6 animate-fade-up-3">
                            <p class="text-[10px] tracking-[0.2em] font-jost mb-3 text-charcoal/60">
                                {{ strtoupper($type) }} — <span class="text-charcoal" id="{{ Str::slug($type) }}-label">Select</span>
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($variants as $variant)
                                    <button
                                        class="size-btn {{ $variant->stock === 0 ? 'unavailable' : '' }}"
                                        data-variant-id="{{ $variant->id }}"
                                        data-type="{{ Str::slug($type) }}"
                                        @if($variant->stock > 0)
                                            onclick="selectVariant(this, '{{ Str::slug($type) }}', '{{ $variant->value }}', {{ $variant->id }})"
                                        @endif
                                        title="{{ $variant->stock === 0 ? 'Out of stock' : '' }}">
                                        {{ $variant->value }}
                                    </button>
                                @endforeach
                            </div>
                            @if($variants->where('stock', 0)->count() > 0)
                                <p class="text-[10px] font-jost text-warm-gray mt-2">
                                    Some options unavailable.
                                    <a href="#" class="text-soft-gold hover:underline">Notify me</a>
                                </p>
                            @endif
                        </div>
                    @endforeach

                    <!-- Qty + Add to cart -->
                    <div class="flex gap-3 mb-4 animate-fade-up-3">
                        <div class="flex items-center">
                            <button class="qty-btn" onclick="changeQty(-1)"><i class="fa-solid fa-minus text-[9px]"></i></button>
                            <input type="text" class="qty-input" value="1" id="qty" readonly>
                            <button class="qty-btn" onclick="changeQty(1)"><i class="fa-solid fa-plus text-[9px]"></i></button>
                        </div>

                        {{-- FIX 1 + 10: no alert(), loading state on button --}}
                        <button id="atc-btn" data-product-id="{{ $product->id }}" onclick="handleAddToCart(event)" class="btn-gold flex-1 py-3.5 text-[11px] tracking-[0.22em] font-jost">
                            <span>ADD TO CART</span>
                        </button>

                        {{-- FIX 3: clean single-signature wishlist toggle --}}
                        <button
                            id="wishlist-btn"
                            class="wishlist-btn w-12 h-12 border border-charcoal/15 flex items-center justify-center text-charcoal/40 hover:text-soft-gold hover:border-soft-gold/40 transition-colors {{ $isWishlisted ? 'wishlisted' : '' }}"
                            data-product-id="{{ $product->id }}"
                            onclick="toggleWishlist(this)">
                            <i class="fa-{{ $isWishlisted ? 'solid' : 'regular' }} fa-heart text-sm"></i>
                        </button>
                    </div>

                    <!-- Engraving -->
                    <div class="mb-6 animate-fade-up-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" id="engrave-check" class="w-4 h-4 accent-yellow-600 cursor-pointer">
                            <span class="text-xs font-jost text-charcoal/60">Add complimentary engraving <span class="text-soft-gold">(free)</span></span>
                        </label>
                        <div id="engrave-input" class="hidden mt-3">
                            <input type="text" maxlength="20" placeholder="Up to 20 characters…"
                                   class="w-full border-b border-charcoal/15 py-2 px-1 text-sm font-jost font-light bg-transparent outline-none focus:border-soft-gold transition-colors placeholder-warm-gray/40">
                        </div>
                    </div>

                    <!-- Trust badges -->
                    <div class="grid grid-cols-3 gap-4 py-6 border-t border-b border-charcoal/7 mb-6 animate-fade-up-3">
                        <div class="text-center">
                            <i class="fa-solid fa-shield-halved text-soft-gold text-lg mb-2 block"></i>
                            <p class="text-[9px] tracking-[0.12em] font-jost text-charcoal/50">CERTIFIED<br>AUTHENTIC</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-truck text-soft-gold text-lg mb-2 block"></i>
                            <p class="text-[9px] tracking-[0.12em] font-jost text-charcoal/50">FREE<br>WORLDWIDE</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-rotate-left text-soft-gold text-lg mb-2 block"></i>
                            <p class="text-[9px] tracking-[0.12em] font-jost text-charcoal/50">30-DAY<br>RETURNS</p>
                        </div>
                    </div>

                    <!-- Accordion -->
                    <div class="space-y-0 animate-fade-up-3">

                        {{-- FIX 4: dynamic attributes from DB --}}
                        @if($product->attributes->isNotEmpty())
                        <div class="accord-item border-b border-charcoal/7">
                            <button class="accord-toggle w-full flex items-center justify-between py-4 text-left">
                                <span class="text-[10px] tracking-[0.2em] font-jost font-medium text-charcoal">SPECIFICATIONS</span>
                                <i class="fa-solid fa-plus accord-icon text-soft-gold text-[10px]"></i>
                            </button>
                            <div class="accord-body">
                                <div class="grid grid-cols-2 gap-3 pb-4 text-xs font-jost font-light">
                                    @foreach($product->attributes as $attr)
                                        <div>
                                            <p class="text-warm-gray mb-0.5">{{ ucfirst(str_replace('_', ' ', $attr->key)) }}</p>
                                            <p class="text-charcoal">{{ $attr->value }}{{ $attr->unit ? ' ' . $attr->unit : '' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="accord-item border-b border-charcoal/7">
                            <button class="accord-toggle w-full flex items-center justify-between py-4 text-left">
                                <span class="text-[10px] tracking-[0.2em] font-jost font-medium text-charcoal">SHIPPING & DELIVERY</span>
                                <i class="fa-solid fa-plus accord-icon text-soft-gold text-[10px]"></i>
                            </button>
                            <div class="accord-body">
                                <div class="pb-4 text-xs font-jost font-light text-warm-gray space-y-2">
                                    <p>Complimentary worldwide shipping on all orders. Insured and tracked.</p>
                                    <p>Standard: <span class="text-charcoal">5–8 business days</span></p>
                                    <p>Express: <span class="text-charcoal">2–3 business days</span></p>
                                    <p>Each piece ships in our signature Lumière box with a certificate of authenticity.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accord-item border-b border-charcoal/7">
                            <button class="accord-toggle w-full flex items-center justify-between py-4 text-left">
                                <span class="text-[10px] tracking-[0.2em] font-jost font-medium text-charcoal">CARE INSTRUCTIONS</span>
                                <i class="fa-solid fa-plus accord-icon text-soft-gold text-[10px]"></i>
                            </button>
                            <div class="accord-body">
                                <div class="pb-4 text-xs font-jost font-light text-warm-gray space-y-2">
                                    <p>Store separately in the provided pouch to avoid scratches. Clean with a soft, lint-free cloth.</p>
                                    <p>Avoid exposure to perfumes, chemicals, and prolonged direct sunlight. Remove before swimming or bathing.</p>
                                    <p>Annual professional cleaning recommended. Complimentary at any Lumière atelier.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accord-item border-b border-charcoal/7">
                            <button class="accord-toggle w-full flex items-center justify-between py-4 text-left">
                                <span class="text-[10px] tracking-[0.2em] font-jost font-medium text-charcoal">RETURNS & GUARANTEE</span>
                                <i class="fa-solid fa-plus accord-icon text-soft-gold text-[10px]"></i>
                            </button>
                            <div class="accord-body">
                                <div class="pb-4 text-xs font-jost font-light text-warm-gray space-y-2">
                                    <p>30-day return window for unworn pieces in original packaging. Engraved items are non-returnable.</p>
                                    <p>Lifetime guarantee against manufacturing defects. Free resizing once within the first year.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- RELATED PRODUCTS -->
    <section class="py-20 px-6 md:px-12 bg-cream">
        <div class="max-w-screen-xl mx-auto">
            <div class="text-center mb-14">
                <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-3 font-jost">YOU MAY ALSO LOVE</p>
                <h2 class="font-playfair text-3xl font-light text-charcoal">
                    From {{ $product->collection?->name ?? 'The Collection' }}
                </h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    @php
                        $relatedImage = $related->primaryImage?->image_url ?? $relatedFallback;
                    @endphp
                    <div class="rel-card group cursor-pointer reveal">
                        <div class="relative overflow-hidden bg-deep-ivory rounded-sm mb-4 aspect-[3/4]">
                            <a href="{{ route('product.show', $related) }}">
                                <img src="{{ $relatedImage }}"
                                     class="rel-img w-full h-full object-cover" loading="lazy">
                            </a>
                            <div class="rel-overlay absolute inset-0 bg-black/15 flex items-end justify-center pb-4">
                                {{-- FIX 9: Quick View links to product page (quickAdd removed — was dead code) --}}
                                <a href="{{ route('product.show', $related) }}"
                                   class="bg-white text-charcoal text-[10px] tracking-[0.15em] font-jost px-5 py-2 hover:bg-soft-gold hover:text-white transition-colors">
                                    QUICK VIEW
                                </a>
                            </div>
                        </div>
                        <h3 class="font-playfair text-base font-light mb-1">{{ $related->name }}</h3>
                        <p class="text-warm-gray text-xs font-jost font-light mb-1">{{ ucwords(str_replace('-', ' ', $related->category)) }}</p>
                        <p class="text-soft-gold text-sm font-jost">{{ $currencySymbol }}{{ number_format($related->price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- STICKY BAR -->
    <div id="sticky-bar" class="fixed bottom-0 left-0 right-0 bg-cream/97 backdrop-blur-sm border-t border-charcoal/8 z-40 px-6 py-3 flex items-center gap-4">
        <div class="flex-1">
            <p class="font-playfair text-base font-light text-charcoal">{{ $product->name }}</p>
            <p class="text-soft-gold text-sm font-jost">{{ $currencySymbol }}{{ number_format($product->price, 2) }}</p>
        </div>
        <button id="sticky-atc-btn" data-product-id="{{ $product->id }}" onclick="handleAddToCart(event)" class="btn-gold px-8 py-3 text-[10px] tracking-[0.22em] font-jost flex-shrink-0">
            <span>ADD TO CART</span>
        </button>
    </div>

    <!-- FOOTER -->
    <footer class="bg-[#161616] pt-16 pb-8 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div>
                    <h3 class="font-playfair text-2xl font-light text-white mb-4 tracking-widest">LUMIÈRE</h3>
                    <p class="text-white/35 text-xs font-jost font-light leading-relaxed max-w-[180px]">Timeless elegance crafted for the discerning soul.</p>
                </div>
                <div>
                    <h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">SHOP</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('shop', ['category' => 'necklace']) }}"  class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Necklaces</a></li>
                        <li><a href="{{ route('shop', ['category' => 'ring']) }}"      class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Rings</a></li>
                        <li><a href="{{ route('shop', ['category' => 'earrings']) }}"  class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Earrings</a></li>
                        <li><a href="{{ route('shop', ['category' => 'bracelet']) }}"  class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Bracelets</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">SUPPORT</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('contact') }}"   class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Contact Us</a></li>
                        <li><a href="{{ route('faq') }}"       class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">FAQs</a></li>
                        <li><a href="{{ route('shipping') }}"  class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Shipping & Returns</a></li>
                        <li><a href="{{ route('size-guide') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Size Guide</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">FOLLOW</h4>
                    <div class="flex gap-5 mb-8">
                        <a href="#" class="text-white/35 hover:text-soft-gold transition-colors"><i class="fa-brands fa-instagram text-base"></i></a>
                        <a href="#" class="text-white/35 hover:text-soft-gold transition-colors"><i class="fa-brands fa-pinterest text-base"></i></a>
                        <a href="#" class="text-white/35 hover:text-soft-gold transition-colors"><i class="fa-brands fa-x-twitter text-base"></i></a>
                    </div>
                    <form action="{{ route('newsletter') }}" method="POST">
                        @csrf
                        <input type="hidden" name="source" value="newsletter_footer">
                        <div class="flex border-b border-white/20">
                            <input type="email" name="email" required placeholder="Email address"
                                   class="flex-1 bg-transparent py-3 text-xs text-white placeholder:text-white/30 outline-none">
                            <button type="submit" class="text-soft-gold text-[9px] tracking-[0.2em] pl-3">JOIN</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center gap-3">
                <p class="text-white/20 text-[10px] font-jost font-light">© 2026 Lumière Jewelry. All rights reserved.</p>
                <p class="text-white/20 text-[10px] font-jost font-light">Crafted with elegance in Paris.</p>
            </div>
        </div>
    </footer>

    <!-- ZOOM OVERLAY -->
    <div id="zoom-overlay" class="fixed inset-0 z-[80] bg-black/90 flex items-center justify-center p-6" onclick="closeZoom()">
        <button class="absolute top-5 right-5 text-white/60 hover:text-white text-2xl"><i class="fa-solid fa-xmark"></i></button>
        <img id="zoom-img" src="" class="max-w-full max-h-full object-contain">
    </div>

    {{-- FIX 2: single cart drawer include, single toggleCart() definition --}}
    @include('partials.cart-drawer')

    <script>
        // ── TOAST (replaces every alert()) ──────────────────────────────
        let toastTimer;
        function showToast(msg, iconClass = 'fa-solid fa-check') {
            clearTimeout(toastTimer);
            document.getElementById('toast-msg').textContent  = msg;
            document.getElementById('toast-icon').className   = iconClass;
            const t = document.getElementById('toast');
            t.classList.add('show');
            toastTimer = setTimeout(() => t.classList.remove('show'), 2800);
        }

        // ── NAV SCROLL ──────────────────────────────────────────────────
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 60));

        // ── STICKY BAR ──────────────────────────────────────────────────
        const stickyBar = document.getElementById('sticky-bar');
        window.addEventListener('scroll', () => stickyBar.classList.toggle('visible', window.scrollY > 600));

        // ── MOBILE MENU ─────────────────────────────────────────────────
        const openBtn     = document.getElementById('menu-open');
        const closeBtn    = document.getElementById('menu-close');
        const mobileMenu  = document.getElementById('mobile-menu');
        const menuOverlay = document.getElementById('menu-overlay');
        const openMenu  = () => { mobileMenu.classList.add('open');    menuOverlay.classList.remove('hidden'); document.body.style.overflow = 'hidden'; };
        const closeMenu = () => { mobileMenu.classList.remove('open'); menuOverlay.classList.add('hidden');    document.body.style.overflow = ''; };
        openBtn.addEventListener('click', openMenu);
        closeBtn.addEventListener('click', closeMenu);
        menuOverlay.addEventListener('click', closeMenu);
        document.querySelectorAll('.mobile-nav-link').forEach(l => l.addEventListener('click', closeMenu));

        // ── THUMBNAIL SWITCH ────────────────────────────────────────────
        function switchImg(el, src) {
            document.getElementById('main-img').src = src;
            document.getElementById('zoom-img').src = src;
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active', 'border-soft-gold'));
            el.classList.add('active', 'border-soft-gold');
        }

        // ── VARIANT SELECTION ───────────────────────────────────────────
        // FIX 5: driven by DB variants, tracks selected variant IDs per type
        const selectedVariants = {};

        function selectVariant(el, type, value, variantId) {
            // Deselect siblings of same type
            document.querySelectorAll(`.size-btn[data-type="${type}"]`).forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            // Update label
            const label = document.getElementById(`${type}-label`);
            if (label) label.textContent = value;
            // Store selected variant ID
            selectedVariants[type] = variantId;
        }

        // ── QTY ─────────────────────────────────────────────────────────
        function changeQty(delta) {
            const input = document.getElementById('qty');
            input.value = Math.max(1, parseInt(input.value) + delta);
        }

        // ── ENGRAVING TOGGLE ────────────────────────────────────────────
        document.getElementById('engrave-check').addEventListener('change', function () {
            document.getElementById('engrave-input').classList.toggle('hidden', !this.checked);
        });

        // ── ADD TO CART ─────────────────────────────────────────────────
        // Wrapper function to handle variant selection before calling global addToCart
        function handleAddToCart(event) {
            const btn = event.currentTarget;
            const productId = btn.dataset.productId;
            const qty = parseInt(document.getElementById('qty').value);
            
            // Get first selected variant if any (for products with size/metal options)
            const variantId = Object.values(selectedVariants)[0] ?? null;
            
            // Call global addToCart function from cart-drawer
            addToCart(productId, variantId, qty);
        }

        // ── WISHLIST TOGGLE AJAX FUNCTION ───────────────────────────────────
        // Toggles product in wishlist (add if not present, remove if present)
        // Handles both guests and authenticated users via server-side logic
        function toggleWishlist(btn) {
            // Get product ID from button's data attribute (set in Blade template)
            const productId = Number(btn.dataset.productId);
            
            // Show loading state
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            
            // Make AJAX request to wishlist toggle endpoint
            fetch('/wishlist/add', {
                method: 'POST',
                headers: {
                    // Tell server we're sending and expecting JSON
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    // Mark as AJAX request (helps Laravel detect AJAX)
                    'X-Requested-With': 'XMLHttpRequest',
                    // Include CSRF token for security
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                // Send only product ID - server handles toggle logic
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => {
                // Handle HTTP errors
                if (!res.ok) return res.text().then(t => { throw new Error(t); });
                return res.json();
            })
            .then(data => {
                // Success: update UI based on server response
                if (data.success) {
                    // Determine if product was added or removed from wishlist
                    const isWishlisted = data.action === 'added';
                    
                    // Update button styling based on wishlist state
                    btn.classList.toggle('wishlisted', isWishlisted);
                    const icon = btn.querySelector('i');
                    icon.className = isWishlisted ? 'fa-solid fa-heart text-sm' : 'fa-regular fa-heart text-sm';
                    
                    // Update wishlist count in navigation
                    const navWishlist = document.querySelector('a[href*="wishlist"] span');
                    if (navWishlist && data.count !== undefined) {
                        navWishlist.textContent = data.count;
                    }
                    
                    // Show appropriate success message
                    showToast(
                        isWishlisted ? 'Saved to your wishlist' : 'Removed from wishlist',
                        isWishlisted ? 'fa-solid fa-heart' : 'fa-regular fa-heart'
                    );
                }
            })
            .catch(err => {
                // Error handling: show error toast and log for debugging
                showToast('Could not update wishlist', 'fa-solid fa-circle-exclamation');
                console.error('Wishlist error:', err);
            });
        }

        // ── CART DRAWER ─────────────────────────────────────────────────
        // Use shared drawer script from the included partial.
        // ── ACCORDION ───────────────────────────────────────────────────
        document.querySelectorAll('.accord-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = btn.closest('.accord-item');
                const body = item.querySelector('.accord-body');
                const isOpen = item.classList.contains('open');
                item.classList.toggle('open', !isOpen);
                body.classList.toggle('open', !isOpen);
            });
        });

        // ── ZOOM ────────────────────────────────────────────────────────
        function openZoom(src) {
            document.getElementById('zoom-img').src = src;
            document.getElementById('zoom-overlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeZoom() {
            document.getElementById('zoom-overlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeZoom(); });

        // ── SCROLL REVEAL ───────────────────────────────────────────────
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

        // ── INIT ────────────────────────────────────────────────────────
        // Sync cart count on page load
        fetch('/api/cart')
            .then(r => r.json())
            .then(data => {
                const total = data.items?.reduce((s, i) => s + i.quantity, 0) ?? 0;
                document.getElementById('cart-count').textContent = total;
            })
            .catch(() => {});
    </script>
</body>
</html>
