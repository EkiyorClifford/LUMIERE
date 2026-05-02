<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The Atelier | LUMIÈRE Fine Jewelry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F9F6F0', 'soft-gold': '#C9A84C', 'gold-light': '#E8C97A',
                        'deep-ivory': '#F2EDE4', 'warm-charcoal': '#2A2A2A', charcoal: '#2A2A2A', 'warm-gray': '#8A8580',
                        'rose-warm': '#E8D1C5', 'champagne': '#F3E5D8',
                    },
                    fontFamily: {
                        'playfair': ['"Playfair Display"', 'serif'],
                        'cormorant': ['"Cormorant Garamond"', 'serif'],
                        'jost': ['Jost', 'sans-serif'],
                    },
                    keyframes: {
                        fadeUp: { '0%': { opacity:'0', transform:'translateY(24px)' }, '100%': { opacity:'1', transform:'translateY(0)' } },
                        slowZoom: { '0%,100%': { transform:'scale(1)' }, '50%': { transform:'scale(1.03)' } },
                        lineGrow: { '0%': { width:'0' }, '100%': { width:'3rem' } },
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.9s ease both',
                        'fade-up-2': 'fadeUp 0.9s ease 0.15s both',
                        'fade-up-3': 'fadeUp 0.9s ease 0.3s both',
                        'slow-zoom': 'slowZoom 28s ease-in-out infinite',
                        'line-grow': 'lineGrow 0.7s ease 0.4s both',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@200;300;400;500&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --gold:#C9A84C; --gold-light:#E8C97A; --cream:#F9F6F0; --warm-charcoal:#2A2A2A; }
        ::-webkit-scrollbar{width:4px} ::-webkit-scrollbar-track{background:var(--cream)} ::-webkit-scrollbar-thumb{background:var(--gold);border-radius:4px}
        ::selection{background:var(--gold);color:#fff} html{scroll-behavior:smooth}

        #main-nav{transition:padding .4s ease,background .4s ease,box-shadow .4s ease}
        #main-nav.scrolled{padding-top:.75rem;padding-bottom:.75rem;background:rgba(249,246,240,.96);box-shadow:0 1px 20px rgba(0,0,0,.04)}
        .nav-link{position:relative}
        .nav-link::after{content:'';position:absolute;bottom:-3px;left:0;width:0;height:1px;background:var(--gold);transition:width .3s ease}
        .nav-link:hover::after,.nav-link.active::after{width:100%}

        /* Hero — warm, not grayscale */
        .hero-bg { background: linear-gradient(160deg, #2A2418 0%, #1E1A14 100%); }
        .hero-grid {
            position:absolute; inset:0;
            background-image: linear-gradient(rgba(201,168,76,0.06) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(201,168,76,0.06) 1px, transparent 1px);
            background-size: 70px 70px;
        }
        .hero-vignette { position:absolute; inset:0; background:radial-gradient(ellipse at center, transparent 40%, rgba(0,0,0,0.4) 100%); }

        .reveal{opacity:0;transform:translateY(24px);transition:opacity .8s cubic-bezier(0.2,0.9,0.4,1.1),transform .8s cubic-bezier(0.2,0.9,0.4,1.1)}
        .reveal.visible{opacity:1;transform:translateY(0)}
        .reveal-left{opacity:0;transform:translateX(-24px);transition:opacity .9s ease,transform .9s ease}
        .reveal-left.visible{opacity:1;transform:translateX(0)}
        .reveal-right{opacity:0;transform:translateX(24px);transition:opacity .9s ease,transform .9s ease}
        .reveal-right.visible{opacity:1;transform:translateX(0)}

        .parallax-wrap{overflow:hidden;position:relative}
        .parallax-img{transition:transform .8s cubic-bezier(.25,.46,.45,.94);will-change:transform}
        .parallax-wrap:hover .parallax-img{transform:scale(1.03)}

        .corner-tl::before{content:'';position:absolute;top:20px;left:20px;width:32px;height:32px;border-top:1px solid rgba(201,168,76,.5);border-left:1px solid rgba(201,168,76,.5);z-index:2}
        .corner-br::after{content:'';position:absolute;bottom:20px;right:20px;width:32px;height:32px;border-bottom:1px solid rgba(201,168,76,.5);border-right:1px solid rgba(201,168,76,.5);z-index:2}

        .btn-gold{position:relative;overflow:hidden;background:var(--gold);color:#fff;transition:color .3s}
        .btn-gold::before{content:'';position:absolute;inset:0;background:#A8862E;transform:translateY(100%);transition:transform .32s cubic-bezier(.4,0,.2,1)}
        .btn-gold:hover::before{transform:translateY(0)}
        .btn-gold span{position:relative;z-index:1}
        .btn-outline-white{position:relative;overflow:hidden;border:1px solid rgba(255,255,255,.35);color:#fff;transition:color .3s}
        .btn-outline-white::before{content:'';position:absolute;inset:0;background:#fff;transform:translateY(100%);transition:transform .32s cubic-bezier(.4,0,.2,1)}
        .btn-outline-white:hover::before{transform:translateY(0)}
        .btn-outline-white:hover{color:var(--warm-charcoal)}
        .btn-outline-white span{position:relative;z-index:1}

        .btn-outline-dark{position:relative;overflow:hidden;border:1px solid var(--warm-charcoal);color:var(--warm-charcoal);transition:color .3s}
        .btn-outline-dark::before{content:'';position:absolute;inset:0;background:var(--warm-charcoal);transform:translateY(100%);transition:transform .32s cubic-bezier(.4,0,.2,1)}
        .btn-outline-dark:hover::before{transform:translateY(0)}
        .btn-outline-dark:hover{color:#fff}
        .btn-outline-dark span{position:relative;z-index:1}

        .value-icon{width:44px;height:44px;border:1px solid rgba(201,168,76,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0}

        #mobile-menu{transform:translateX(100%);transition:transform .4s cubic-bezier(.4,0,.2,1)}
        #mobile-menu.open{transform:translateX(0)}
        .noise-overlay{position:absolute;inset:0;opacity:.015;pointer-events:none;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E")}

        @keyframes marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
        .marquee-track{animation:marquee 32s linear infinite;white-space:nowrap}
        .marquee-track:hover{animation-play-state:paused}

        /* ── Visit Request Modal ── */
        #visit-modal {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }
        #visit-modal.open {
            opacity: 1;
            pointer-events: all;
        }
        #visit-panel {
            transform: translateY(32px);
            transition: transform 0.45s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #visit-modal.open #visit-panel {
            transform: translateY(0);
        }

        /* Floating label inputs */
        .field-wrap { position: relative; }
        .field-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(42,42,42,0.15);
            padding: 1.25rem 0 0.5rem 0;
            font-family: 'Jost', sans-serif;
            font-size: 0.85rem;
            font-weight: 300;
            color: var(--warm-charcoal);
            outline: none;
            transition: border-color 0.3s ease;
        }
        .field-input:focus {
            border-bottom-color: var(--gold);
        }
        .field-label {
            position: absolute;
            top: 1.1rem;
            left: 0;
            font-family: 'Jost', sans-serif;
            font-size: 0.75rem;
            font-weight: 300;
            letter-spacing: 0.12em;
            color: rgba(138,133,128,0.7);
            pointer-events: none;
            transition: top 0.25s ease, font-size 0.25s ease, color 0.25s ease, letter-spacing 0.25s ease;
        }
        .field-input:focus ~ .field-label,
        .field-input:not(:placeholder-shown) ~ .field-label {
            top: 0;
            font-size: 0.6rem;
            letter-spacing: 0.2em;
            color: var(--gold);
        }
        textarea.field-input { resize: none; min-height: 72px; }

        /* Success state */
        #visit-success {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        #visit-success.show {
            display: flex;
            opacity: 1;
        }

        /* Gold line animation on modal open */
        @keyframes goldLineIn {
            from { width: 0; }
            to   { width: 2.5rem; }
        }
        .modal-line {
            width: 0;
            height: 1px;
            background: var(--gold);
            transition: none;
        }
        #visit-modal.open .modal-line {
            animation: goldLineIn 0.6s ease 0.35s forwards;
        }
    </style>
</head>
<body class="bg-cream font-jost text-warm-charcoal overflow-x-hidden">

    <!-- NAV — lighter on dark hero -->
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">
            <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-white hover:text-soft-gold transition-colors duration-300">LUMIÈRE</a>
            <div class="hidden md:flex items-center gap-10">
                <a href="{{ route('collections') }}" class="nav-link text-xs tracking-[0.18em] text-white/70 hover:text-white font-jost">COLLECTIONS</a>
                <a href="{{ route('shop') }}"        class="nav-link text-xs tracking-[0.18em] text-white/70 hover:text-white font-jost">SHOP</a>
                <a href="{{ route('atelier') }}"     class="nav-link active text-xs tracking-[0.18em] text-white font-jost">ABOUT</a>
                <a href="{{ route('journal') }}"     class="nav-link text-xs tracking-[0.18em] text-white/70 hover:text-white font-jost">JOURNAL</a>
            </div>
            <div class="flex items-center gap-5">
                <button class="text-white/50 hover:text-soft-gold transition-colors"><i class="fa-regular fa-heart text-base"></i></button>
                @auth
                    <div class="relative group">
                        <button class="text-white/50 hover:text-soft-gold transition-colors flex items-center gap-2">
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
                    <a href="{{ route('login') }}" class="text-white/50 hover:text-soft-gold transition-colors">
                        <i class="fa-regular fa-user text-base"></i>
                    </a>
                @endif
                <button onclick="toggleCart()" class="text-white/50 hover:text-soft-gold transition-colors relative">
                    <i class="fa-solid fa-cart-shopping text-base"></i>
                    <span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center">{{ $cartCount ?? 0 }}</span>
                </button>
                <button id="menu-open" class="md:hidden text-white/70 ml-1"><i class="fa-solid fa-bars text-lg"></i></button>
            </div>
        </div>
    </nav>
    <div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-cream z-[60] shadow-2xl flex flex-col px-10 py-12">
        <button id="menu-close" class="self-end text-charcoal/50 hover:text-charcoal mb-10"><i class="fa-solid fa-xmark text-xl"></i></button>
        <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal mb-10 block">LUMIÈRE</a>
        <div class="flex flex-col gap-7">
            <a href="{{ route('collections') }}" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold font-jost">COLLECTIONS</a>
            <a href="{{ route('shop') }}"        class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold font-jost">SHOP</a>
            <a href="{{ route('atelier') }}"     class="text-xs tracking-[0.18em] text-soft-gold font-jost">ABOUT</a>
            <a href="{{ route('home') }}#journal"     class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold font-jost">JOURNAL</a>
        </div>
        <div class="mt-auto flex gap-5 text-charcoal/40">
            <a href="#"><i class="fa-brands fa-instagram text-lg hover:text-soft-gold transition-colors"></i></a>
            <a href="#"><i class="fa-brands fa-pinterest text-lg hover:text-soft-gold transition-colors"></i></a>
        </div>
    </div>
    <div id="menu-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden"></div>

    <!-- HERO — FULL COLOR, WARM -->
    <section class="hero-bg relative min-h-screen flex items-end pb-24 md:pb-32 overflow-hidden">
        <div class="hero-grid"></div>
        <div class="hero-vignette"></div>
        <div class="noise-overlay"></div>
        <div class="absolute inset-0 opacity-40">
            <img src="https://images.unsplash.com/photo-1534008757030-27299c4371b6?q=80&w=2070&auto=format&fit=crop" alt="Warm gold jewelry" class="w-full h-full object-cover animate-slow-zoom">
        </div>

        <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none overflow-hidden">
            <span class="font-cormorant italic font-light text-[clamp(6rem,16vw,16rem)] text-[rgba(201,168,76,0.04)] leading-none whitespace-nowrap">L'Atelier</span>
        </div>

        <div class="relative z-10 max-w-screen-xl mx-auto px-6 md:px-12 w-full">
            <div class="flex items-center gap-3 mb-12 animate-fade-up">
                <a href="{{ route('home') }}" class="text-white/30 text-[10px] tracking-[0.25em] font-jost hover:text-soft-gold transition-colors">HOME</a>
                <span class="text-soft-gold/40 text-[10px]">✦</span>
                <span class="text-soft-gold text-[10px] tracking-[0.25em] font-jost">THE ATELIER</span>
            </div>
            <div class="max-w-2xl">
                <p class="text-soft-gold text-[10px] tracking-[0.4em] mb-6 font-jost font-light animate-fade-up">EST. 2024 · PARIS</p>
                <h1 class="font-playfair font-light text-white leading-[1.1] mb-8">
                    <span class="block text-5xl md:text-7xl lg:text-8xl tracking-tight">Where light</span>
                    <span class="block text-4xl md:text-6xl lg:text-7xl font-cormorant italic font-light">becomes gold.</span>
                </h1>
                <span class="block w-0 h-px bg-soft-gold mb-8 animate-line-grow"></span>
                <p class="text-white/55 font-jost font-light text-sm max-w-md leading-relaxed animate-fade-up-2">
                    A small house born in Paris with a single conviction: fine jewelry made slowly, by hand, designed to outlive its maker.
                </p>
                <div class="flex gap-4 mt-10 animate-fade-up-3">
                    <a href="{{ route('shop') }}" class="btn-gold inline-block px-8 py-3.5 text-[11px] tracking-[0.22em] font-jost"><span>SHOP THE COLLECTIONS</span></a>
                    <a href="#story"    class="btn-outline-white inline-block px-8 py-3.5 text-[11px] tracking-[0.22em] font-jost"><span>OUR STORY</span></a>
                </div>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-40">
            <span class="text-white text-[8px] tracking-[0.35em] font-jost">SCROLL</span>
            <div class="w-px h-10 bg-gradient-to-b from-white/50 to-transparent animate-pulse"></div>
        </div>
    </section>

    <div class="bg-soft-gold py-3 overflow-hidden">
        <div class="marquee-track inline-flex gap-12">
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">HANDCRAFTED IN PARIS</span><span class="text-white/50">✦</span>
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">ETHICALLY SOURCED</span><span class="text-white/50">✦</span>
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">40 HOURS PER PIECE</span><span class="text-white/50">✦</span>
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">LIFETIME GUARANTEE</span><span class="text-white/50">✦</span>
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">18k GOLD STANDARD</span><span class="text-white/50">✦</span>
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">WARMTH IN EVERY DETAIL</span><span class="text-white/50">✦</span>
            <!-- duplicated for seamless loop -->
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">HANDCRAFTED IN PARIS</span><span class="text-white/50">✦</span>
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">ETHICALLY SOURCED</span><span class="text-white/50">✦</span>
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">40 HOURS PER PIECE</span><span class="text-white/50">✦</span>
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">LIFETIME GUARANTEE</span><span class="text-white/50">✦</span>
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">18k GOLD STANDARD</span><span class="text-white/50">✦</span>
            <span class="text-white text-[9px] tracking-[0.35em] font-jost font-light">WARMTH IN EVERY DETAIL</span><span class="text-white/50">✦</span>
        </div>
    </div>

    <!-- THE STORY — FULL COLOR IMAGE, no grayscale -->
    <section id="story" class="py-28 px-6 md:px-12 bg-cream">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid md:grid-cols-2 gap-16 xl:gap-24 items-center">
                <div class="reveal-left relative corner-tl corner-br">
                    <div class="parallax-wrap rounded-sm overflow-hidden shadow-2xl" style="height:520px">
                        <img src="https://images.unsplash.com/photo-1589128777073-263566ae5e4d?q=80&w=2070&auto=format&fit=crop" alt="Jeweller at work with warm gold" class="parallax-img w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-warm-charcoal text-white px-6 py-4 shadow-xl">
                        <p class="font-playfair text-2xl font-light">2024</p>
                        <p class="text-[9px] tracking-[0.2em] font-jost text-white/50 mt-0.5">YEAR FOUNDED</p>
                    </div>
                </div>
                <div class="reveal-right">
                    <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-6 font-jost font-light">THE FOUNDING</p>
                    <h2 class="font-playfair text-4xl md:text-5xl font-light text-warm-charcoal leading-tight">A house built on <span class="font-cormorant italic font-light">patience.</span></h2>
                    <span class="block w-10 h-px bg-soft-gold mt-6 mb-8"></span>
                    <p class="text-warm-gray font-jost font-light text-sm leading-relaxed mb-5">
                        Lumière was founded in Paris in 2024 with a refusal to compromise. Slow craft, verified origins, and heirloom intention over transaction volume.
                    </p>
                    <p class="text-warm-gray font-jost font-light text-sm leading-relaxed mb-5">
                        Every gemstone is traceable. Diamonds verified beyond Kimberley. Pearls from certified Japanese farms. Our atelier occupies a quiet corner of the 6th arrondissement.
                    </p>
                    <p class="text-warm-gray font-jost font-light text-sm leading-relaxed mb-10">
                        Seven artisans work there. The oldest has been making jewelry for 34 years. Together, they produce fewer than 300 pieces per year — by design.
                    </p>
                    <div class="grid grid-cols-3 gap-6 border-t border-warm-charcoal/8 pt-8">
                        <div><p class="font-playfair text-3xl text-warm-charcoal font-light">7</p><p class="text-[9px] tracking-[0.18em] font-jost text-warm-gray mt-1">ARTISANS</p></div>
                        <div><p class="font-playfair text-3xl text-warm-charcoal font-light">300+</p><p class="text-[9px] tracking-[0.18em] font-jost text-warm-gray mt-1">PIECES / YEAR</p></div>
                        <div><p class="font-playfair text-3xl text-warm-charcoal font-light">40</p><p class="text-[9px] tracking-[0.18em] font-jost text-warm-gray mt-1">HOURS / PIECE</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- THE PROCESS — 3 steps, FULL COLOR -->
    <section class="py-28 px-6 md:px-12 bg-champagne">
        <div class="max-w-screen-xl mx-auto">
            <div class="text-center mb-20 reveal">
                <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-4 font-jost font-light">HOW IT'S MADE</p>
                <h2 class="font-playfair text-4xl md:text-5xl font-light text-warm-charcoal mb-5">The Process</h2>
                <span class="block w-12 h-px bg-soft-gold mx-auto mb-6"></span>
                <p class="text-warm-gray text-sm font-jost font-light max-w-md mx-auto">Every Lumière piece passes through three core stages of craft.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="reveal text-center">
                    <div class="parallax-wrap rounded-sm overflow-hidden mb-6 shadow-xl" style="height:280px">
                        <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=2070&auto=format&fit=crop" alt="Jewelry design sketch" class="parallax-img w-full h-full object-cover">
                    </div>
                    <p class="text-soft-gold text-[9px] tracking-[0.3em] mb-2 font-jost">01</p>
                    <h3 class="font-playfair text-xl font-light text-warm-charcoal mb-2">Sketch & Wax</h3>
                    <p class="text-warm-gray text-xs font-jost font-light leading-relaxed max-w-xs mx-auto">Each piece begins as a pencil sketch, then carved in wax by hand — unchanged for centuries.</p>
                </div>
                <div class="reveal text-center" style="transition-delay:.1s">
                    <div class="parallax-wrap rounded-sm overflow-hidden mb-6 shadow-xl" style="height:280px">
                        <img src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=2188&auto=format&fit=crop" alt="Gold casting" class="parallax-img w-full h-full object-cover">
                    </div>
                    <p class="text-soft-gold text-[9px] tracking-[0.3em] mb-2 font-jost">02</p>
                    <h3 class="font-playfair text-xl font-light text-warm-charcoal mb-2">Casting & Setting</h3>
                    <p class="text-warm-gray text-xs font-jost font-light leading-relaxed max-w-xs mx-auto">Liquid gold replaces the wax. Gemstones set by hand under magnification — the most delicate stage.</p>
                </div>
                <div class="reveal text-center" style="transition-delay:.2s">
                    <div class="parallax-wrap rounded-sm overflow-hidden mb-6 shadow-xl" style="height:280px">
                        <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=2187&auto=format&fit=crop" alt="Finished jewelry" class="parallax-img w-full h-full object-cover">
                    </div>
                    <p class="text-soft-gold text-[9px] tracking-[0.3em] mb-2 font-jost">03</p>
                    <h3 class="font-playfair text-xl font-light text-warm-charcoal mb-2">Finish & Certificate</h3>
                    <p class="text-warm-gray text-xs font-jost font-light leading-relaxed max-w-xs mx-auto">Six stages of polish, 10× magnification inspection, then signed by the artisan who made it.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FULL-BLEED ATELIER IMAGE -->
    <section class="relative h-[65vh] overflow-hidden">
        <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=2070&auto=format&fit=crop" alt="Paris courtyard atelier" class="w-full h-full object-cover animate-slow-zoom">
        <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/35 to-transparent"></div>
        <div class="noise-overlay"></div>
        <div class="absolute inset-0 flex items-center px-6 md:px-20">
            <div class="max-w-lg reveal-left">
                <p class="text-soft-gold text-[9px] tracking-[0.35em] mb-5 font-jost font-light">6TH ARRONDISSEMENT · SAINT-GERMAIN-DES-PRÉS</p>
                <h2 class="font-playfair text-4xl md:text-5xl font-light text-white mb-5 leading-tight">The Paris <span class="font-cormorant italic font-light">atelier.</span></h2>
                <span class="block w-10 h-px bg-soft-gold mb-6"></span>
                <p class="text-white/55 font-jost font-light text-sm leading-relaxed mb-4 max-w-md">Tucked behind a courtyard gate in Saint-Germain-des-Prés, our atelier is where every Lumière piece begins and ends. Seven artisans. One standard. No shortcuts.</p>
                <p class="text-white/35 font-jost font-light text-sm leading-relaxed mb-8 max-w-md">We don't receive visitors as a rule — but for those who want to see the work up close, we welcome you by appointment. Come and watch a stone being set. Ask questions. Leave knowing exactly what you're wearing.</p>
                <a href="#contact" class="btn-outline-white inline-block px-8 py-3 text-[11px] tracking-[0.22em] font-jost"><span>REQUEST A VISIT</span></a>
            </div>
        </div>
    </section>

    <!-- OUR ARTISANS -->
    <section class="py-28 px-6 md:px-12 bg-cream">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-16 gap-4">
                <div class="reveal">
                    <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-4 font-jost font-light">THE HANDS BEHIND LUMIÈRE</p>
                    <h2 class="font-playfair text-4xl md:text-5xl font-light text-warm-charcoal">Our Artisans</h2>
                </div>
                <p class="text-warm-gray text-sm font-jost font-light max-w-xs leading-relaxed reveal">Seven makers. A combined 120 years of craft experience between them.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group cursor-pointer reveal">
                    <div class="overflow-hidden rounded-sm mb-5" style="height:360px">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=600&auto=format&fit=crop"
                             alt="Michel Fontaine" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105">
                    </div>
                    <p class="text-soft-gold text-[10px] tracking-[0.3em] mb-1 font-jost">MASTER GOLDSMITH</p>
                    <h3 class="font-playfair text-xl font-light text-warm-charcoal mb-2">Michel Fontaine</h3>
                    <p class="text-warm-gray text-xs font-jost font-light leading-relaxed">34 years · Specialises in granulation and repoussé. Trained under the last generation of Parisian guild goldsmiths.</p>
                </div>
                <div class="group cursor-pointer reveal" style="transition-delay:.12s">
                    <div class="overflow-hidden rounded-sm mb-5" style="height:360px">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b1a4?q=80&w=600&auto=format&fit=crop"
                             alt="Isabelle Marchand" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105">
                    </div>
                    <p class="text-soft-gold text-[10px] tracking-[0.3em] mb-1 font-jost">STONE SETTER</p>
                    <h3 class="font-playfair text-xl font-light text-warm-charcoal mb-2">Isabelle Marchand</h3>
                    <p class="text-warm-gray text-xs font-jost font-light leading-relaxed">21 years · Pavé and invisible setting specialist. Her hands are steady enough to set stones under a single millimetre in diameter.</p>
                </div>
                <div class="group cursor-pointer reveal" style="transition-delay:.24s">
                    <div class="overflow-hidden rounded-sm mb-5" style="height:360px">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=600&auto=format&fit=crop"
                             alt="Kofi Asante" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105">
                    </div>
                    <p class="text-soft-gold text-[10px] tracking-[0.3em] mb-1 font-jost">DESIGNER & WAX CARVER</p>
                    <h3 class="font-playfair text-xl font-light text-warm-charcoal mb-2">Kofi Asante</h3>
                    <p class="text-warm-gray text-xs font-jost font-light leading-relaxed">12 years · Creates all initial designs and wax models. Influenced by West African geometric forms and French Art Deco.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- OUR VALUES — warm and inviting -->
    <section class="py-28 px-6 md:px-12 bg-warm-charcoal relative overflow-hidden">
        <div class="noise-overlay"></div>
        <div class="absolute right-0 top-1/2 -translate-y-1/2 opacity-[0.03] pointer-events-none select-none text-soft-gold text-[18rem] font-cormorant italic">✦</div>
        <div class="relative z-10 max-w-screen-xl mx-auto">
            <div class="text-center mb-16 reveal">
                <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-4 font-jost font-light">WHAT WE STAND FOR</p>
                <h2 class="font-playfair text-4xl md:text-5xl font-light text-white mb-5">Our Values</h2>
                <span class="block w-10 h-px bg-soft-gold mx-auto"></span>
            </div>
            <div class="grid md:grid-cols-2 gap-10 max-w-3xl mx-auto">
                <div class="flex gap-5 reveal">
                    <div class="value-icon text-soft-gold"><i class="fa-solid fa-leaf text-lg"></i></div>
                    <div><h3 class="font-playfair text-lg font-light text-white mb-1">Ethical Sourcing</h3><p class="text-white/45 text-[11px] font-jost font-light leading-relaxed">Every stone traceable to origin. We visit our suppliers in person and publish what we find.</p></div>
                </div>
                <div class="flex gap-5 reveal" style="transition-delay:.1s">
                    <div class="value-icon text-soft-gold"><i class="fa-solid fa-hand-holding-heart text-lg"></i></div>
                    <div><h3 class="font-playfair text-lg font-light text-white mb-1">Made by Hand</h3><p class="text-white/45 text-[11px] font-jost font-light leading-relaxed">No mass-production machinery. Tools and techniques unchanged for three centuries.</p></div>
                </div>
                <div class="flex gap-5 reveal" style="transition-delay:.2s">
                    <div class="value-icon text-soft-gold"><i class="fa-solid fa-infinity text-lg"></i></div>
                    <div><h3 class="font-playfair text-lg font-light text-white mb-1">Designed to Last</h3><p class="text-white/45 text-[11px] font-jost font-light leading-relaxed">Lifetime repairs, annual cleaning, and an heirloom promise. We intend to still be here when you need us.</p></div>
                </div>
                <div class="flex gap-5 reveal" style="transition-delay:.3s">
                    <div class="value-icon text-soft-gold"><i class="fa-solid fa-eye text-lg"></i></div>
                    <div><h3 class="font-playfair text-lg font-light text-white mb-1">Radical Transparency</h3><p class="text-white/45 text-[11px] font-jost font-light leading-relaxed">We publish the origin of every major gemstone we sell. If you ask how a piece is made, we will tell you everything.</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT CTA -->
    <section id="contact" class="py-24 px-6 md:px-12 bg-rose-warm">
        <div class="max-w-2xl mx-auto text-center reveal">
            <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-5 font-jost font-light">GET IN TOUCH</p>
            <h2 class="font-playfair text-4xl md:text-5xl font-light text-warm-charcoal mb-4">We'd love to <span class="font-cormorant italic font-light">hear from you.</span></h2>
            <span class="block w-10 h-px bg-soft-gold mx-auto my-7"></span>
            <p class="text-warm-charcoal/60 font-jost font-light text-sm leading-relaxed mb-10 max-w-md mx-auto">Commission a bespoke piece, book an atelier visit, or simply ask a question.</p>
            <div class="grid sm:grid-cols-3 gap-6 mb-10 text-center">
                <div><i class="fa-solid fa-envelope text-soft-gold text-xl mb-2"></i><p class="text-[9px] tracking-[0.2em] font-jost text-warm-charcoal/50 mb-1">EMAIL</p><a href="mailto:bonjour@lumiere.com" class="text-xs font-jost text-warm-charcoal hover:text-soft-gold transition-colors">bonjour@lumiere.com</a></div>
                <div><i class="fa-solid fa-phone text-soft-gold text-xl mb-2"></i><p class="text-[9px] tracking-[0.2em] font-jost text-warm-charcoal/50 mb-1">PHONE</p><a href="tel:+33140000000" class="text-xs font-jost text-warm-charcoal hover:text-soft-gold transition-colors">+33 1 40 00 00 00</a></div>
                <div><i class="fa-solid fa-location-dot text-soft-gold text-xl mb-2"></i><p class="text-[9px] tracking-[0.2em] font-jost text-warm-charcoal/50 mb-1">ATELIER</p><p class="text-xs font-jost text-warm-charcoal">6th Arr., Paris · By appt</p></div>
            </div>
            <a href="mailto:bonjour@lumiere.com" class="btn-outline-dark inline-block px-10 py-3.5 text-[11px] tracking-[0.22em] font-jost"><span>WRITE TO US</span></a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-[#1A1A1A] pt-16 pb-8 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div><h3 class="font-playfair text-2xl font-light text-white mb-4 tracking-widest">LUMIÈRE</h3><p class="text-white/30 text-xs font-jost font-light">Timeless elegance crafted in Paris.</p></div>
                <div><h4 class="text-white/50 text-[9px] font-jost tracking-[0.3em] mb-5">SHOP</h4><ul class="space-y-2"><li><a href="#" class="text-white/30 hover:text-soft-gold text-[11px] font-jost font-light">Necklaces</a></li><li><a href="#" class="text-white/30 hover:text-soft-gold text-[11px] font-jost font-light">Rings</a></li><li><a href="#" class="text-white/30 hover:text-soft-gold text-[11px] font-jost font-light">Earrings</a></li></ul></div>
                <div><h4 class="text-white/50 text-[9px] font-jost tracking-[0.3em] mb-5">SUPPORT</h4><ul class="space-y-2"><li><a href="{{ route('contact') }}" class="text-white/30 hover:text-soft-gold text-[11px] font-jost font-light">Contact</a></li><li><a href="{{ route('faq') }}" class="text-white/30 hover:text-soft-gold text-[11px] font-jost font-light">FAQs</a></li><li><a href="{{ route('shipping') }}" class="text-white/30 hover:text-soft-gold text-[11px] font-jost font-light">Shipping</a></li></ul></div>
                <div><h4 class="text-white/50 text-[9px] font-jost tracking-[0.3em] mb-5">FOLLOW</h4><div class="flex gap-4"><a href="#" class="text-white/30 hover:text-soft-gold"><i class="fa-brands fa-instagram"></i></a><a href="#" class="text-white/30 hover:text-soft-gold"><i class="fa-brands fa-pinterest"></i></a></div></div>
            </div>
            <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center gap-3">
                <p class="text-white/20 text-[10px] font-jost font-light tracking-wide">© 2026 Lumière Jewelry. All rights reserved.</p>
                <p class="text-white/20 text-[10px] font-jost font-light tracking-wide">Crafted with elegance in Paris.</p>
            </div>
        </div>
    </footer>

    <!-- ══════════════════════════════════
         VISIT REQUEST MODAL
    ══════════════════════════════════ -->
    <div id="visit-modal" class="fixed inset-0 z-[80] flex items-center justify-center p-6">

        <!-- Backdrop -->
        <div id="visit-backdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <!-- Panel -->
        <div id="visit-panel" class="relative w-full max-w-lg bg-cream shadow-[0_40px_100px_rgba(0,0,0,0.25)] overflow-hidden">

            <!-- Gold top border accent -->
            <div class="h-px bg-gradient-to-r from-transparent via-soft-gold to-transparent"></div>

            <!-- Close -->
            <button id="visit-close" class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center text-warm-charcoal/30 hover:text-warm-charcoal transition-colors z-10">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>

            <!-- ── FORM STATE ── -->
            <div id="visit-form-wrap" class="p-10 md:p-12">

                <!-- Header -->
                <p class="text-soft-gold text-[10px] tracking-[0.35em] font-jost font-light mb-5">L'ATELIER · PARIS</p>
                <h2 class="font-playfair text-3xl font-light text-warm-charcoal leading-tight mb-2">
                    Request a Visit
                </h2>
                <p class="font-cormorant italic text-warm-gray text-lg font-light mb-1" style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300">
                    — by appointment only
                </p>
                <div class="modal-line my-6"></div>
                <p class="text-warm-gray font-jost font-light text-xs leading-relaxed mb-8">
                    We don't take open bookings. Leave your details and we'll reach out personally when a visit becomes available. We respond to every request.
                </p>

                <!-- Fields -->
                <div class="space-y-7">

                    <!-- Name -->
                    <div class="field-wrap">
                        <input type="text" id="visit-name" class="field-input" placeholder=" " autocomplete="off">
                        <label for="visit-name" class="field-label">YOUR NAME</label>
                    </div>

                    <!-- Email -->
                    <div class="field-wrap">
                        <input type="email" id="visit-email" class="field-input" placeholder=" " autocomplete="off">
                        <label for="visit-email" class="field-label">EMAIL ADDRESS</label>
                    </div>

                    <!-- Message -->
                    <div class="field-wrap">
                        <textarea id="visit-message" class="field-input" placeholder=" " rows="3"></textarea>
                        <label for="visit-message" class="field-label">WHAT BRINGS YOU TO US? <span class="text-warm-gray/50 normal-case" style="letter-spacing:0.05em">(optional)</span></label>
                    </div>

                </div>

                <!-- Error message -->
                <p id="visit-error" class="hidden text-[11px] font-jost text-red-400 mt-4"></p>

                <!-- Submit -->
                <button id="visit-submit" class="btn-gold w-full mt-8 py-4 text-[11px] tracking-[0.25em] font-jost flex items-center justify-center gap-3">
                    <span id="submit-label">REQUEST A VISIT</span>
                    <span id="submit-spinner" class="hidden">
                        <i class="fa-solid fa-circle-notch fa-spin text-sm"></i>
                    </span>
                </button>

                <p class="text-warm-gray/50 text-[10px] font-jost text-center mt-5 leading-relaxed">
                    We'll never share your details. You'll hear from us within 48 hours.
                </p>

            </div>

            <!-- ── SUCCESS STATE ── -->
            <div id="visit-success" class="p-10 md:p-12 flex-col items-center justify-center text-center min-h-[420px]">
                <!-- Ornament -->
                <div class="w-14 h-14 border border-soft-gold/40 flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-check text-soft-gold text-lg"></i>
                </div>
                <p class="text-soft-gold text-[10px] tracking-[0.35em] font-jost font-light mb-4">REQUEST RECEIVED</p>
                <h3 class="font-playfair text-2xl font-light text-warm-charcoal mb-2">Thank you,</h3>
                <p id="success-name" class="font-cormorant italic text-warm-charcoal text-xl font-light mb-1" style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300"></p>
                <div class="w-8 h-px bg-soft-gold mx-auto my-6"></div>
                <p class="text-warm-gray font-jost font-light text-xs leading-relaxed max-w-xs mx-auto mb-8">
                    We've noted your request. When a visit becomes available, you'll receive a personal invitation from our atelier. We look forward to welcoming you.
                </p>
                <button id="success-close" class="btn-outline-dark inline-block px-8 py-3 text-[10px] tracking-[0.22em] font-jost"><span>CLOSE</span></button>
            </div>

        </div>
    </div>

    <script>
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 60));

        const openBtn = document.getElementById('menu-open'), closeBtn = document.getElementById('menu-close');
        const mobileMenu = document.getElementById('mobile-menu'), menuOverlay = document.getElementById('menu-overlay');
        const openMenu = () => { mobileMenu.classList.add('open'); menuOverlay.classList.remove('hidden'); document.body.style.overflow='hidden'; };
        const closeMenu = () => { mobileMenu.classList.remove('open'); menuOverlay.classList.add('hidden'); document.body.style.overflow=''; };
        if(openBtn) openBtn.addEventListener('click', openMenu); if(closeBtn) closeBtn.addEventListener('click', closeMenu); if(menuOverlay) menuOverlay.addEventListener('click', closeMenu);

        const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
        const obs = new IntersectionObserver(entries => { entries.forEach(e => { if(e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } }); }, { threshold: 0.12 });
        reveals.forEach(el => obs.observe(el));

        // ── Visit Modal ──
        const visitModal     = document.getElementById('visit-modal');
        const visitBackdrop  = document.getElementById('visit-backdrop');
        const visitClose     = document.getElementById('visit-close');
        const visitFormWrap  = document.getElementById('visit-form-wrap');
        const visitSuccess   = document.getElementById('visit-success');
        const visitSubmit    = document.getElementById('visit-submit');
        const visitError     = document.getElementById('visit-error');
        const submitLabel    = document.getElementById('submit-label');
        const submitSpinner  = document.getElementById('submit-spinner');
        const successClose   = document.getElementById('success-close');

        function openVisitModal() {
            visitModal.classList.add('open');
            document.body.style.overflow = 'hidden';
            // reset to form state each time
            visitFormWrap.style.display = 'block';
            visitSuccess.classList.remove('show');
            visitError.classList.add('hidden');
            document.getElementById('visit-name').value = '';
            document.getElementById('visit-email').value = '';
            document.getElementById('visit-message').value = '';
        }

        function closeVisitModal() {
            visitModal.classList.remove('open');
            document.body.style.overflow = '';
        }

        // Wire ALL "Request a Visit" buttons on the page
        document.querySelectorAll('a[href="#contact"], button').forEach(el => {
            if (el.textContent.trim() === 'REQUEST A VISIT') {
                el.addEventListener('click', (e) => { e.preventDefault(); openVisitModal(); });
            }
        });

        visitBackdrop.addEventListener('click', closeVisitModal);
        visitClose.addEventListener('click', closeVisitModal);
        successClose.addEventListener('click', closeVisitModal);
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeVisitModal(); });

        // Submit
        visitSubmit.addEventListener('click', () => {
            const name    = document.getElementById('visit-name').value.trim();
            const email   = document.getElementById('visit-email').value.trim();
            const message = document.getElementById('visit-message').value.trim();

            // Basic validation
            if (!name) {
                visitError.textContent = 'Please enter your name.';
                visitError.classList.remove('hidden');
                document.getElementById('visit-name').focus();
                return;
            }
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                visitError.textContent = 'Please enter a valid email address.';
                visitError.classList.remove('hidden');
                document.getElementById('visit-email').focus();
                return;
            }
            visitError.classList.add('hidden');

            // Loading state
            submitLabel.textContent = 'SENDING…';
            submitSpinner.classList.remove('hidden');
            visitSubmit.disabled = true;

            // Real Laravel submission
            fetch('/atelier/request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ name, email, message })
            })
            .then(res => res.json())
            .then(data => {
                submitLabel.textContent = 'REQUEST A VISIT';
                submitSpinner.classList.add('hidden');
                visitSubmit.disabled = false;

                // Show success
                visitFormWrap.style.display = 'none';
                document.getElementById('success-name').textContent = name + '.';
                visitSuccess.classList.add('show');
            })
            .catch(err => {
                submitLabel.textContent = 'REQUEST A VISIT';
                submitSpinner.classList.add('hidden');
                visitSubmit.disabled = false;
                visitError.textContent = 'Something went wrong. Please try again.';
                visitError.classList.remove('hidden');
            });
        });
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
