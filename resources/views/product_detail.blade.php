<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celestial Ring | LUMIÈRE Fine Jewelry</title>
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
                        'fade-up': 'fadeUp 0.8s ease both',
                        'fade-up-2': 'fadeUp 0.8s ease 0.12s both',
                        'fade-up-3': 'fadeUp 0.8s ease 0.24s both',
                        'shimmer': 'shimmer 4s linear infinite',
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

        /* Thumbnail gallery */
        .thumb{cursor:pointer;transition:opacity .25s,border-color .25s}
        .thumb:hover{opacity:.85}
        .thumb.active{border-color:var(--gold) !important}

        /* Size selector */
        .size-btn{border:1px solid rgba(28,28,28,.15);font-family:'Jost',sans-serif;font-size:.7rem;letter-spacing:.1em;padding:.5rem .85rem;cursor:pointer;transition:all .25s ease}
        .size-btn:hover,.size-btn.active{border-color:var(--gold);color:var(--gold);background:rgba(201,168,76,.06)}
        .size-btn.unavailable{opacity:.3;cursor:not-allowed;text-decoration:line-through}

        /* Qty */
        .qty-btn{width:36px;height:36px;border:1px solid rgba(28,28,28,.12);display:flex;align-items:center;justify-content:center;cursor:pointer;font-family:'Jost',sans-serif;transition:border-color .2s,color .2s}
        .qty-btn:hover{border-color:var(--gold);color:var(--gold)}
        .qty-input{width:44px;height:36px;border:none;border-top:1px solid rgba(28,28,28,.12);border-bottom:1px solid rgba(28,28,28,.12);text-align:center;font-family:'Jost',sans-serif;font-size:.8rem;background:transparent;outline:none}

        /* Accordion */
        .accord-body{max-height:0;overflow:hidden;transition:max-height .4s ease,padding .4s ease}
        .accord-body.open{max-height:400px;padding-top:.75rem}
        .accord-icon{transition:transform .3s ease}
        .accord-item.open .accord-icon{transform:rotate(45deg)}

        /* Buttons */
        .btn-gold{position:relative;overflow:hidden;background:var(--gold);color:#fff;transition:color .3s}
        .btn-gold::before{content:'';position:absolute;inset:0;background:#A8862E;transform:translateY(100%);transition:transform .32s cubic-bezier(.4,0,.2,1)}
        .btn-gold:hover::before{transform:translateY(0)}
        .btn-gold span{position:relative;z-index:1}
        .btn-outline-dark{position:relative;overflow:hidden;border:1px solid var(--charcoal);color:var(--charcoal);transition:color .3s}
        .btn-outline-dark::before{content:'';position:absolute;inset:0;background:var(--charcoal);transform:translateY(100%);transition:transform .32s cubic-bezier(.4,0,.2,1)}
        .btn-outline-dark:hover::before{transform:translateY(0)}
        .btn-outline-dark:hover{color:#fff}
        .btn-outline-dark span{position:relative;z-index:1}

        /* Gold shimmer */
        .gold-shimmer{background:linear-gradient(90deg,var(--gold) 0%,var(--gold-light) 40%,var(--gold) 60%,var(--gold-light) 100%);background-size:200% auto;-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;animation:shimmer 4s linear infinite}

        /* Related cards */
        .rel-card .rel-img{transition:transform .7s cubic-bezier(.25,.46,.45,.94)}
        .rel-card:hover .rel-img{transform:scale(1.06)}
        .rel-card .rel-overlay{opacity:0;transform:translateY(6px);transition:opacity .3s,transform .3s}
        .rel-card:hover .rel-overlay{opacity:1;transform:translateY(0)}

        /* Reveal */
        .reveal{opacity:0;transform:translateY(24px);transition:opacity .7s ease,transform .7s ease}
        .reveal.visible{opacity:1;transform:translateY(0)}

        /* Tab */
        .tab-btn{position:relative;padding-bottom:.5rem;font-family:'Jost',sans-serif;font-size:.7rem;letter-spacing:.2em;cursor:pointer;transition:color .25s}
        .tab-btn::after{content:'';position:absolute;bottom:0;left:0;width:0;height:1px;background:var(--gold);transition:width .3s}
        .tab-btn.active{color:var(--charcoal)}
        .tab-btn.active::after{width:100%}
        .tab-content{display:none}
        .tab-content.active{display:block}

        /* Zoom overlay */
        #zoom-overlay{opacity:0;pointer-events:none;transition:opacity .3s}
        #zoom-overlay.open{opacity:1;pointer-events:all}

        /* Mobile menu */
        #mobile-menu{transform:translateX(100%);transition:transform .4s cubic-bezier(.4,0,.2,1)}
        #mobile-menu.open{transform:translateX(0)}

        .noise-overlay{position:absolute;inset:0;opacity:.025;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");pointer-events:none}

        /* Sticky purchase bar — consistent from detail2 */
        #sticky-bar{transform:translateY(100%);transition:transform .4s ease}
        #sticky-bar.visible{transform:translateY(0)}
    </style>
</head>
<body class="bg-cream font-jost text-charcoal overflow-x-hidden">

    <!-- NAV (from detail2) -->
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
                <button class="text-charcoal/60 hover:text-soft-gold transition-colors"><i class="fa-regular fa-heart text-base"></i></button>
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
                            <a href="#" class="block px-4 py-3 text-xs text-charcoal/70 hover:text-soft-gold hover:bg-[#F9F6F0] transition-colors font-jost">My Profile</a>
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
                <button onclick="toggleCart()" class="text-charcoal/60 hover:text-soft-gold transition-colors relative">
                    <i class="fa-solid fa-cart-shopping text-base"></i>
                    <span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center">{{ $cartCount ?? 0 }}</span>
                </button>
                <button id="menu-open" class="md:hidden text-charcoal/70 ml-1"><i class="fa-solid fa-bars text-lg"></i></button>
            </div>
        </div>
    </nav>
    <div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-cream z-[60] shadow-2xl flex flex-col px-10 py-12">
        <button id="menu-close" class="self-end text-charcoal/50 hover:text-charcoal mb-10"><i class="fa-solid fa-xmark text-xl"></i></button>
        <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal mb-10 block">LUMIÈRE</a>
        <div class="flex flex-col gap-7">
            <a href="{{ route('collections') }}" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold font-jost mobile-nav-link">COLLECTIONS</a>
            <a href="{{ route('shop') }}"        class="text-xs tracking-[0.18em] text-soft-gold font-jost">SHOP</a>
            <a href="{{ route('atelier') }}"     class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold font-jost mobile-nav-link">ABOUT</a>
            <a href="{{ route('journal') }}"     class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold font-jost mobile-nav-link">JOURNAL</a>
        </div>
        <div class="mt-auto flex gap-5 text-charcoal/40">
            <a href="#"><i class="fa-brands fa-instagram text-lg hover:text-soft-gold transition-colors"></i></a>
            <a href="#"><i class="fa-brands fa-pinterest text-lg hover:text-soft-gold transition-colors"></i></a>
        </div>
    </div>
    <div id="menu-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden"></div>

    <!-- BREADCRUMB (from detail2) -->
    <div class="pt-28 pb-0 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto flex items-center gap-3">
            <a href="{{ route('home') }}"       class="text-[10px] tracking-[0.2em] font-jost text-warm-gray hover:text-soft-gold transition-colors">HOME</a>
            <span class="text-soft-gold/40 text-[10px]">✦</span>
            <a href="{{ route('shop') }}"        class="text-[10px] tracking-[0.2em] font-jost text-warm-gray hover:text-soft-gold transition-colors">SHOP</a>
            <span class="text-soft-gold/40 text-[10px]">✦</span>
            <span class="text-[10px] tracking-[0.2em] font-jost text-charcoal">CELESTIAL RING</span>
        </div>
    </div>

    <!-- PRODUCT DETAIL (core from detail2, enhanced with full returns, guarantee, care) -->
    <section class="py-12 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 xl:gap-20 items-start">

                <!-- LEFT — Image gallery (detail2) -->
                <div class="animate-fade-up">
                    <div class="relative overflow-hidden rounded-sm bg-deep-ivory mb-4 group" style="aspect-ratio:4/5">
                        <img id="main-img"
                             src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=2188&auto=format&fit=crop"
                             alt="Celestial Ring"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-103 cursor-zoom-in"
                             style="transition:transform .8s cubic-bezier(.25,.46,.45,.94)"
                             id="zoom-trigger">
                        <span class="absolute top-4 left-4 bg-charcoal text-white text-[9px] tracking-[0.15em] font-jost px-3 py-1.5">LAST FEW</span>
                        <div class="absolute bottom-4 right-4 bg-white/80 backdrop-blur-sm text-[9px] tracking-[0.15em] font-jost text-charcoal/60 px-3 py-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fa-solid fa-magnifying-glass mr-1"></i>ZOOM
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-3">
                        <div class="thumb active border-2 rounded-sm overflow-hidden aspect-square bg-deep-ivory" onclick="switchImg(this, 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=2188&auto=format&fit=crop')">
                            <img src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                        </div>
                        <div class="thumb border-2 border-transparent rounded-sm overflow-hidden aspect-square bg-deep-ivory" onclick="switchImg(this, 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=2070&auto=format&fit=crop')">
                            <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                        </div>
                        <div class="thumb border-2 border-transparent rounded-sm overflow-hidden aspect-square bg-deep-ivory" onclick="switchImg(this, 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=2187&auto=format&fit=crop')">
                            <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                        </div>
                        <div class="thumb border-2 border-transparent rounded-sm overflow-hidden aspect-square bg-deep-ivory" onclick="switchImg(this, 'https://images.unsplash.com/photo-1602751584552-8ba73aad9250?q=80&w=2187&auto=format&fit=crop')">
                            <img src="https://images.unsplash.com/photo-1602751584552-8ba73aad9250?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- RIGHT — Product info (detail2 layout + full accordion: Specifications, Shipping, Care, Returns) -->
                <div class="lg:sticky lg:top-28">

                    <a href="{{ route('collections') }}" class="inline-flex items-center gap-2 text-[10px] tracking-[0.3em] font-jost text-soft-gold hover:text-gold-light transition-colors mb-5 animate-fade-up">
                        L'ÉCLAT COLLECTION <i class="fa-solid fa-arrow-right text-[9px]"></i>
                    </a>

                    <h1 class="font-playfair text-4xl md:text-5xl font-light text-charcoal leading-tight mb-2 animate-fade-up-2">Celestial Ring</h1>
                    <p class="text-warm-gray text-sm font-jost font-light tracking-wide mb-5 animate-fade-up-2">Sapphire & Diamond · 18k White Gold</p>

                    <div class="flex items-baseline gap-4 mb-6 animate-fade-up-2">
                        <span class="font-playfair text-3xl text-charcoal font-light">$3,450</span>
                        <span class="text-xs text-soft-gold tracking-wide font-jost bg-soft-gold/10 px-2 py-1">LAST FEW</span>
                    </div>

                    <!-- No star ratings / reviews section removed as requested -->

                    <span class="block w-10 h-px bg-soft-gold mb-7 animate-fade-up-2"></span>

                    <p class="text-warm-gray font-jost font-light text-sm leading-relaxed mb-8 animate-fade-up-3">
                        A celestial vision in gemstone and metal. The centrepiece: a 1.2-carat Sri Lankan cornflower sapphire, encircled by a halo of pavé-set diamonds totalling 0.45 carats. Set in hand-finished 18k white gold. Each piece takes 38 hours to complete.
                    </p>

                    <!-- Metal selector -->
                    <div class="mb-6 animate-fade-up-3">
                        <p class="text-[10px] tracking-[0.2em] font-jost mb-3 text-charcoal/60">METAL — <span class="text-charcoal" id="metal-label">White Gold</span></p>
                        <div class="flex gap-2">
                            <button class="size-btn active" onclick="selectOption(this,'metal','White Gold','metal-label')">White Gold</button>
                            <button class="size-btn" onclick="selectOption(this,'metal','Yellow Gold','metal-label')">Yellow Gold</button>
                            <button class="size-btn" onclick="selectOption(this,'metal','Rose Gold','metal-label')">Rose Gold</button>
                        </div>
                    </div>

                    <!-- Size selector -->
                    <div class="mb-8 animate-fade-up-3">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[10px] tracking-[0.2em] font-jost text-charcoal/60">RING SIZE — <span class="text-charcoal" id="size-label">Select a size</span></p>
                            <button class="text-[10px] tracking-[0.1em] font-jost text-soft-gold hover:underline">SIZE GUIDE</button>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button class="size-btn" onclick="selectOption(this,'size','46','size-label')">46</button>
                            <button class="size-btn" onclick="selectOption(this,'size','48','size-label')">48</button>
                            <button class="size-btn" onclick="selectOption(this,'size','50','size-label')">50</button>
                            <button class="size-btn" onclick="selectOption(this,'size','52','size-label')">52</button>
                            <button class="size-btn unavailable" title="Unavailable">54</button>
                            <button class="size-btn" onclick="selectOption(this,'size','56','size-label')">56</button>
                            <button class="size-btn" onclick="selectOption(this,'size','58','size-label')">58</button>
                        </div>
                        <p class="text-[10px] font-jost text-warm-gray mt-2">Size 54 temporarily unavailable. <a href="#" class="text-soft-gold hover:underline">Notify me</a></p>
                    </div>

                    <!-- Qty + Add to cart -->
                    <div class="flex gap-3 mb-4 animate-fade-up-3">
                        <div class="flex items-center">
                            <button class="qty-btn" onclick="changeQty(-1)"><i class="fa-solid fa-minus text-[9px]"></i></button>
                            <input type="text" class="qty-input" value="1" id="qty" readonly>
                            <button class="qty-btn" onclick="changeQty(1)"><i class="fa-solid fa-plus text-[9px]"></i></button>
                        </div>
                        <button class="btn-gold flex-1 py-3.5 text-[11px] tracking-[0.22em] font-jost">
                            <span>ADD TO CART</span>
                        </button>
                        <button id="wish-btn" class="w-12 h-12 border border-charcoal/15 flex items-center justify-center text-charcoal/40 hover:text-soft-gold hover:border-soft-gold/40 transition-colors">
                            <i class="fa-regular fa-heart text-sm"></i>
                        </button>
                    </div>

                    <!-- Engraving -->
                    <div class="mb-6 animate-fade-up-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" id="engrave-check" class="w-4 h-4 accent-yellow-600 cursor-pointer">
                            <span class="text-xs font-jost text-charcoal/60">Add complimentary engraving <span class="text-soft-gold">(+$0)</span></span>
                        </label>
                        <div id="engrave-input" class="hidden mt-3">
                            <input type="text" maxlength="20" placeholder="Up to 20 characters…"
                            class="w-full border-b border-charcoal/15 py-2 px-1 text-sm font-jost font-light bg-transparent outline-none focus:border-soft-gold transition-colors placeholder-warm-gray/40">
                        </div>
                    </div>

                    <!-- Trust badges -->
                    <div class="grid grid-cols-3 gap-4 py-6 border-t border-b border-charcoal/7 mb-6 animate-fade-up-3">
                        <div class="text-center">
                            <i class="fa-solid fa-shield-halved text-soft-gold text-lg mb-2"></i>
                            <p class="text-[9px] tracking-[0.12em] font-jost text-charcoal/50">CERTIFIED<br>AUTHENTIC</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-truck text-soft-gold text-lg mb-2"></i>
                            <p class="text-[9px] tracking-[0.12em] font-jost text-charcoal/50">FREE<br>WORLDWIDE</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-rotate-left text-soft-gold text-lg mb-2"></i>
                            <p class="text-[9px] tracking-[0.12em] font-jost text-charcoal/50">30-DAY<br>RETURNS</p>
                        </div>
                    </div>

                    <!-- Accordion details: includes full SPECIFICATIONS, SHIPPING, CARE, RETURNS (care + returns added from best of detail1 style) -->
                    <div class="space-y-0 animate-fade-up-3">

                        <div class="accord-item border-b border-charcoal/7">
                            <button class="accord-toggle w-full flex items-center justify-between py-4 text-left">
                                <span class="text-[10px] tracking-[0.2em] font-jost font-medium text-charcoal">SPECIFICATIONS</span>
                                <i class="fa-solid fa-plus accord-icon text-soft-gold text-[10px]"></i>
                            </button>
                            <div class="accord-body">
                                <div class="grid grid-cols-2 gap-3 pb-4 text-xs font-jost font-light">
                                    <div><p class="text-warm-gray mb-0.5">Stone</p><p class="text-charcoal">Sri Lankan Sapphire</p></div>
                                    <div><p class="text-warm-gray mb-0.5">Diamond</p><p class="text-charcoal">Pavé, 0.45 ct</p></div>
                                    <div><p class="text-warm-gray mb-0.5">Metal</p><p class="text-charcoal">18k White Gold</p></div>
                                    <div><p class="text-warm-gray mb-0.5">Band Width</p><p class="text-charcoal">2.4 mm</p></div>
                                    <div><p class="text-warm-gray mb-0.5">Craft Time</p><p class="text-charcoal">38 hours</p></div>
                                    <div><p class="text-warm-gray mb-0.5">Origin</p><p class="text-charcoal">Paris, France</p></div>
                                </div>
                            </div>
                        </div>

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

                        <!-- CARE INSTRUCTIONS (added from detail1's best) -->
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

                        <!-- RETURNS & GUARANTEE (enhanced from detail1, integrated into detail2 layout) -->
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

    <!-- RELATED PRODUCTS — "You May Also Love" from detail2 (fully preserved) -->
    <section class="py-20 px-6 md:px-12 bg-cream">
        <div class="max-w-screen-xl mx-auto">
            <div class="text-center mb-14">
                <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-3 font-jost">YOU MAY ALSO LOVE</p>
                <h2 class="font-playfair text-3xl font-light text-charcoal">From L'Éclat</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="rel-card group cursor-pointer reveal">
                    <div class="relative overflow-hidden bg-deep-ivory rounded-sm mb-4 aspect-[3/4]">
                        <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=600&auto=format&fit=crop" class="rel-img w-full h-full object-cover">
                        <div class="rel-overlay absolute inset-0 bg-black/15 flex items-end justify-center pb-4">
                            <button class="bg-white text-charcoal text-[10px] tracking-[0.15em] font-jost px-5 py-2 hover:bg-soft-gold hover:text-white transition-colors">QUICK VIEW</button>
                        </div>
                    </div>
                    <h3 class="font-playfair text-base font-light mb-1">Solitaire Pendant</h3>
                    <p class="text-warm-gray text-xs font-jost font-light mb-1">Diamond Necklace</p>
                    <p class="text-soft-gold text-sm font-jost">$1,250</p>
                </div>
                <div class="rel-card group cursor-pointer reveal" style="transition-delay:.08s">
                    <div class="relative overflow-hidden bg-deep-ivory rounded-sm mb-4 aspect-[3/4]">
                        <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=600&auto=format&fit=crop" class="rel-img w-full h-full object-cover">
                        <div class="rel-overlay absolute inset-0 bg-black/15 flex items-end justify-center pb-4">
                            <button class="bg-white text-charcoal text-[10px] tracking-[0.15em] font-jost px-5 py-2 hover:bg-soft-gold hover:text-white transition-colors">QUICK VIEW</button>
                        </div>
                        <span class="absolute top-3 left-3 bg-soft-gold/90 text-white text-[9px] tracking-[0.15em] font-jost px-2 py-1">SIGNATURE</span>
                    </div>
                    <h3 class="font-playfair text-base font-light mb-1">Lumière Signature Ring</h3>
                    <p class="text-warm-gray text-xs font-jost font-light mb-1">Diamond · Limited</p>
                    <p class="text-soft-gold text-sm font-jost">$4,500</p>
                </div>
                <div class="rel-card group cursor-pointer reveal" style="transition-delay:.16s">
                    <div class="relative overflow-hidden bg-deep-ivory rounded-sm mb-4 aspect-[3/4]">
                        <img src="https://images.unsplash.com/photo-1602173574767-37ac01994b2a?q=80&w=600&auto=format&fit=crop" class="rel-img w-full h-full object-cover">
                        <div class="rel-overlay absolute inset-0 bg-black/15 flex items-end justify-center pb-4">
                            <button class="bg-white text-charcoal text-[10px] tracking-[0.15em] font-jost px-5 py-2 hover:bg-soft-gold hover:text-white transition-colors">QUICK VIEW</button>
                        </div>
                    </div>
                    <h3 class="font-playfair text-base font-light mb-1">Diamond Halo Studs</h3>
                    <p class="text-warm-gray text-xs font-jost font-light mb-1">Diamond Earrings</p>
                    <p class="text-soft-gold text-sm font-jost">$1,680</p>
                </div>
                <div class="rel-card group cursor-pointer reveal" style="transition-delay:.24s">
                    <div class="relative overflow-hidden bg-deep-ivory rounded-sm mb-4 aspect-[3/4]">
                        <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600&auto=format&fit=crop" class="rel-img w-full h-full object-cover">
                        <div class="rel-overlay absolute inset-0 bg-black/15 flex items-end justify-center pb-4">
                            <button class="bg-white text-charcoal text-[10px] tracking-[0.15em] font-jost px-5 py-2 hover:bg-soft-gold hover:text-white transition-colors">QUICK VIEW</button>
                        </div>
                    </div>
                    <h3 class="font-playfair text-base font-light mb-1">Knot Signet Ring</h3>
                    <p class="text-warm-gray text-xs font-jost font-light mb-1">18k Gold</p>
                    <p class="text-soft-gold text-sm font-jost">$1,850</p>
                </div>
            </div>
        </div>
    </section>

    <!-- STICKY BAR (from detail2) -->
    <div id="sticky-bar" class="fixed bottom-0 left-0 right-0 bg-cream/97 backdrop-blur-sm border-t border-charcoal/8 z-40 px-6 py-3 flex items-center gap-4">
        <div class="flex-1">
            <p class="font-playfair text-base font-light text-charcoal">Celestial Ring</p>
            <p class="text-soft-gold text-sm font-jost">$3,450</p>
        </div>
        <button class="btn-gold px-8 py-3 text-[10px] tracking-[0.22em] font-jost flex-shrink-0">
            <span>ADD TO CART</span>
        </button>
    </div>

    <!-- FOOTER (detail2) -->
    <footer class="bg-[#161616] pt-16 pb-8 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div><h3 class="font-playfair text-2xl font-light text-white mb-4 tracking-widest">LUMIÈRE</h3><p class="text-white/35 text-xs font-jost font-light leading-relaxed max-w-[180px]">Timeless elegance crafted for the discerning soul.</p></div>
                <div><h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">SHOP</h4><ul class="space-y-3"><li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Necklaces</a></li><li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Rings</a></li><li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Earrings</a></li><li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Bracelets</a></li></ul></div>
                <div><h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">SUPPORT</h4><ul class="space-y-3"><li><a href="{{ route('contact') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Contact Us</a></li><li><a href="{{ route('faq') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">FAQs</a></li><li><a href="{{ route('shipping') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Shipping & Returns</a></li><li><a href="{{ route('size-guide') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Size Guide</a></li></ul></div>
                <div><h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">FOLLOW</h4><div class="flex gap-5"><a href="#" class="text-white/35 hover:text-soft-gold transition-colors"><i class="fa-brands fa-instagram text-base"></i></a><a href="#" class="text-white/35 hover:text-soft-gold transition-colors"><i class="fa-brands fa-pinterest text-base"></i></a><a href="#" class="text-white/35 hover:text-soft-gold transition-colors"><i class="fa-brands fa-x-twitter text-base"></i></a></div><form action="{{ route('newsletter') }}" method="POST" class="mt-8">@csrf<input type="hidden" name="source" value="newsletter_footer"><div class="flex border-b border-white/20"><input type="email" name="email" required placeholder="Email address" class="flex-1 bg-transparent py-3 text-xs text-white placeholder:text-white/30 outline-none"><button type="submit" class="text-soft-gold text-[9px] tracking-[0.2em] pl-3">JOIN</button></div></form></div>
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

    <script>
        // Nav scroll
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 60));

        // Sticky bar (detail2 style)
        const stickyBar = document.getElementById('sticky-bar');
        window.addEventListener('scroll', () => stickyBar.classList.toggle('visible', window.scrollY > 600));

        // Mobile menu
        const openBtn = document.getElementById('menu-open'), closeBtn = document.getElementById('menu-close');
        const mobileMenu = document.getElementById('mobile-menu'), menuOverlay = document.getElementById('menu-overlay');
        const openMenu = () => { mobileMenu.classList.add('open'); menuOverlay.classList.remove('hidden'); document.body.style.overflow='hidden'; };
        const closeMenu = () => { mobileMenu.classList.remove('open'); menuOverlay.classList.add('hidden'); document.body.style.overflow=''; };
        openBtn.addEventListener('click', openMenu); closeBtn.addEventListener('click', closeMenu); menuOverlay.addEventListener('click', closeMenu);
        document.querySelectorAll('.mobile-nav-link').forEach(l => l.addEventListener('click', closeMenu));

        // Thumbnail switch
        function switchImg(el, src) {
            document.getElementById('main-img').src = src;
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        }

        // Option selector (metal / size)
        function selectOption(el, group, label, labelId) {
            document.querySelectorAll(`[onclick*="'${group}'"]`).forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById(labelId).textContent = label;
        }

        // Qty
        function changeQty(delta) {
            const input = document.getElementById('qty');
            const val = Math.max(1, parseInt(input.value) + delta);
            input.value = val;
        }

        // Engraving toggle
        document.getElementById('engrave-check').addEventListener('change', function() {
            document.getElementById('engrave-input').classList.toggle('hidden', !this.checked);
        });

        // Wishlist
        document.getElementById('wish-btn').addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-regular');
            icon.classList.toggle('fa-solid');
            this.classList.toggle('text-soft-gold');
        });

        // Accordion
        document.querySelectorAll('.accord-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = btn.closest('.accord-item');
                const body = item.querySelector('.accord-body');
                const isOpen = item.classList.contains('open');
                item.classList.toggle('open', !isOpen);
                body.classList.toggle('open', !isOpen);
            });
        });

        // Zoom
        document.getElementById('zoom-trigger').addEventListener('click', () => {
            const overlay = document.getElementById('zoom-overlay');
            document.getElementById('zoom-img').src = document.getElementById('main-img').src;
            overlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        });
        function closeZoom() {
            document.getElementById('zoom-overlay').classList.remove('open');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if(e.key==='Escape') closeZoom(); });

        // Scroll reveal for related items
        const reveals = document.querySelectorAll('.reveal');
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); } });
        }, { threshold: 0.1 });
        reveals.forEach(el => obs.observe(el));
    </script>

    @include('partials.cart-drawer')

    <script>
        function toggleCart() {
            const drawer = document.getElementById('cart-drawer');
            const overlay = document.getElementById('cart-overlay');
            drawer.classList.toggle('translate-x-full');
            overlay.classList.toggle('hidden');
            setTimeout(() => overlay.classList.toggle('opacity-100'), 10);
        }
    </script>
</body>
</html>
