<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collections | LUMIÈRE Fine Jewelry</title>
    <meta name="description" content="Explore our signature collections — L'Éclat, L'Or, La Perle. Handcrafted fine jewelry from Paris.">

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
                        shimmer: {
                            '0%': { backgroundPosition: '-200% center' },
                            '100%': { backgroundPosition: '200% center' },
                        },
                        lineGrow: {
                            '0%': { width: '0' },
                            '100%': { width: '4rem' },
                        },
                        floatY: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-8px)' },
                        },
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.9s ease both',
                        'fade-up-2': 'fadeUp 0.9s ease 0.15s both',
                        'fade-up-3': 'fadeUp 0.9s ease 0.3s both',
                        'fade-up-4': 'fadeUp 0.9s ease 0.45s both',
                        'shimmer': 'shimmer 4s linear infinite',
                        'line-grow': 'lineGrow 0.8s ease 0.5s both',
                        'float': 'floatY 6s ease-in-out infinite',
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

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }
        ::selection { background: var(--gold); color: #fff; }
        html { scroll-behavior: smooth; }

        /* ── Nav ── */
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
            bottom: -3px; left: 0;
            width: 0; height: 1px;
            background: var(--gold);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }
        .nav-link.active::after { width: 100%; }

        /* ── Page hero ── */
        .page-hero {
            background: linear-gradient(160deg, #1C1C1C 0%, #2a2318 50%, #1C1C1C 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-grid-lines {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(201,168,76,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,168,76,0.06) 1px, transparent 1px);
            background-size: 80px 80px;
        }
        .hero-glow {
            position: absolute;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        /* ── Gold shimmer ── */
        .gold-shimmer {
            background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 40%, var(--gold) 60%, var(--gold-light) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s linear infinite;
        }

        /* ── Breadcrumb ── */
        .breadcrumb-sep { color: rgba(201,168,76,0.4); }

        /* ── Collection cards ── */
        .collection-hero-card {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .collection-hero-card .hero-img {
            transition: transform 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .collection-hero-card:hover .hero-img {
            transform: scale(1.07);
        }
        .collection-hero-card .card-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
            transition: background 0.5s ease;
        }
        .collection-hero-card:hover .card-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.80) 0%, rgba(0,0,0,0.3) 60%, rgba(0,0,0,0.05) 100%);
        }

        /* Card reveal line */
        .card-line {
            width: 0;
            height: 1px;
            background: var(--gold);
            transition: width 0.5s ease 0.1s;
        }
        .collection-hero-card:hover .card-line { width: 3rem; }

        /* Explore btn */
        .explore-btn {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
        .collection-hero-card:hover .explore-btn {
            opacity: 1;
            transform: translateY(0);
        }

        /* Collection number */
        .coll-number {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 300;
            color: rgba(201,168,76,0.35);
            font-size: 5rem;
            line-height: 1;
            position: absolute;
            top: 1.5rem;
            right: 1.75rem;
            transition: color 0.4s ease;
            pointer-events: none;
        }
        .collection-hero-card:hover .coll-number {
            color: rgba(201,168,76,0.6);
        }

        /* ── Side-by-side layout for L'OR and LA PERLE ── */
        .split-card {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .split-card .split-img {
            transition: transform 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .split-card:hover .split-img { transform: scale(1.06); }
        .split-card .split-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);
        }
        .split-card .split-line {
            width: 0;
            height: 1px;
            background: var(--gold);
            transition: width 0.5s ease;
        }
        .split-card:hover .split-line { width: 2.5rem; }

        /* ── Coming Soon card ── */
        .coming-soon-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #252018 100%);
            border: 1px solid rgba(201,168,76,0.15);
            position: relative;
            overflow: hidden;
        }
        .coming-soon-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(201,168,76,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,168,76,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .coming-soon-badge {
            border: 1px solid rgba(201,168,76,0.3);
            color: rgba(201,168,76,0.7);
            font-size: 0.6rem;
            letter-spacing: 0.3em;
            padding: 0.4rem 1rem;
            display: inline-block;
        }

        /* ── Stat strip ── */
        .stat-strip {
            background: linear-gradient(90deg, #1C1C1C 0%, #252018 50%, #1C1C1C 100%);
        }

        /* ── Buttons ── */
        .btn-outline-white {
            position: relative; overflow: hidden;
            border: 1px solid rgba(255,255,255,0.4);
            color: #fff;
            transition: color 0.35s ease;
        }
        .btn-outline-white::before {
            content: ''; position: absolute; inset: 0;
            background: #fff;
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-outline-white:hover::before { transform: translateY(0); }
        .btn-outline-white:hover { color: var(--charcoal); }
        .btn-outline-white span { position: relative; z-index: 1; }

        .btn-gold {
            position: relative; overflow: hidden;
            background: var(--gold); color: #fff;
            transition: color 0.35s ease;
        }
        .btn-gold::before {
            content: ''; position: absolute; inset: 0;
            background: #A8862E;
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-gold:hover::before { transform: translateY(0); }
        .btn-gold span { position: relative; z-index: 1; }

        .btn-outline-dark {
            position: relative; overflow: hidden;
            border: 1px solid var(--charcoal);
            color: var(--charcoal);
            transition: color 0.35s ease;
        }
        .btn-outline-dark::before {
            content: ''; position: absolute; inset: 0;
            background: var(--charcoal);
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-outline-dark:hover::before { transform: translateY(0); }
        .btn-outline-dark:hover { color: #fff; }
        .btn-outline-dark span { position: relative; z-index: 1; }

        /* ── Scroll reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }

        /* ── Mobile menu ── */
        #mobile-menu {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        #mobile-menu.open { transform: translateX(0); }

        /* Noise overlay */
        .noise-overlay {
            position: absolute; inset: 0;
            opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-cream font-jost text-charcoal overflow-x-hidden">

    <!-- ══════════════════════════════════
         NAVIGATION
    ══════════════════════════════════ -->
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">
            <a href="index.html" class="font-playfair text-2xl tracking-widest text-charcoal hover:text-soft-gold transition-colors duration-300">
                LUMIÈRE
            </a>
            <div class="hidden md:flex items-center gap-10">
                <a href="#" class="nav-link active text-xs tracking-[0.18em] text-charcoal transition-colors duration-300 font-jost">COLLECTIONS</a>
                <a href="#" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal transition-colors duration-300 font-jost">SHOP</a>
                <a href="#" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal transition-colors duration-300 font-jost">ABOUT</a>
                <a href="#" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal transition-colors duration-300 font-jost">JOURNAL</a>
            </div>
            <div class="flex items-center gap-5">
                <button class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300">
                    <i class="fa-regular fa-heart text-base"></i>
                </button>
                <button class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300">
                    <i class="fa-regular fa-user text-base"></i>
                </button>
                <button class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300 relative">
                    <i class="fa-regular fa-bag-shopping text-base"></i>
                    <span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center font-jost">2</span>
                </button>
                <button id="menu-open" class="md:hidden text-charcoal/70 ml-1">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-cream z-[60] shadow-2xl flex flex-col px-10 py-12">
        <button id="menu-close" class="self-end text-charcoal/50 hover:text-charcoal mb-10">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
        <a href="index.html" class="font-playfair text-2xl tracking-widest text-charcoal mb-10 block">LUMIÈRE</a>
        <div class="flex flex-col gap-7">
            <a href="#" class="text-xs tracking-[0.18em] text-soft-gold font-jost">COLLECTIONS</a>
            <a href="#" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold transition-colors duration-300 font-jost">SHOP</a>
            <a href="#" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold transition-colors duration-300 font-jost">ABOUT</a>
            <a href="#" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold transition-colors duration-300 font-jost">JOURNAL</a>
        </div>
        <div class="mt-auto flex gap-5 text-charcoal/40">
            <a href="#"><i class="fa-brands fa-instagram text-lg hover:text-soft-gold transition-colors"></i></a>
            <a href="#"><i class="fa-brands fa-pinterest text-lg hover:text-soft-gold transition-colors"></i></a>
        </div>
    </div>
    <div id="menu-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden"></div>


    <!-- ══════════════════════════════════
         PAGE HERO
    ══════════════════════════════════ -->
    <section class="page-hero pt-36 pb-24 px-6 md:px-12">
        <div class="hero-grid-lines"></div>
        <div class="hero-glow"></div>
        <div class="noise-overlay"></div>

        <div class="relative z-10 max-w-screen-xl mx-auto">

            <!-- Breadcrumb -->
            <div class="flex items-center gap-3 mb-12 animate-fade-up">
                <a href="index.html" class="text-white/35 text-[10px] tracking-[0.25em] font-jost font-light hover:text-soft-gold transition-colors duration-300">HOME</a>
                <span class="breadcrumb-sep text-[10px]">✦</span>
                <span class="text-soft-gold text-[10px] tracking-[0.25em] font-jost font-light">COLLECTIONS</span>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-end">
                <div>
                    <p class="text-soft-gold text-[10px] tracking-[0.4em] mb-5 font-jost font-light animate-fade-up">NOS COLLECTIONS</p>
                    <h1 class="font-playfair font-light text-white leading-none mb-0 animate-fade-up-2">
                        <span class="block text-5xl md:text-7xl tracking-tight">Every piece,</span>
                        <span class="block text-5xl md:text-7xl tracking-tight" style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">a story.</span>
                    </h1>
                    <span class="block w-0 h-px bg-soft-gold mt-8 animate-line-grow"></span>
                </div>
                <div class="animate-fade-up-3">
                    <p class="text-white/45 font-jost font-light text-sm leading-relaxed max-w-md">
                        Three worlds of fine jewelry, each born from a different element of light. Diamonds that capture brilliance, gold that holds warmth, pearls that carry the sea.
                    </p>
                    <div class="flex items-center gap-8 mt-10">
                        <div class="text-center">
                            <p class="font-playfair text-2xl text-white font-light">3</p>
                            <p class="text-white/35 text-[9px] tracking-[0.2em] font-jost mt-1">COLLECTIONS</p>
                        </div>
                        <div class="w-px h-10 bg-white/10"></div>
                        <div class="text-center">
                            <p class="font-playfair text-2xl text-white font-light">60+</p>
                            <p class="text-white/35 text-[9px] tracking-[0.2em] font-jost mt-1">PIECES</p>
                        </div>
                        <div class="w-px h-10 bg-white/10"></div>
                        <div class="text-center">
                            <p class="font-playfair text-2xl text-white font-light">Paris</p>
                            <p class="text-white/35 text-[9px] tracking-[0.2em] font-jost mt-1">CRAFTED</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ══════════════════════════════════
         COLLECTIONS GRID
    ══════════════════════════════════ -->
    <section class="bg-cream py-24 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto">


            <!-- ── L'ÉCLAT — Full width feature ── -->
            <div class="reveal mb-6">
                <div class="collection-hero-card rounded-sm" style="height: 600px;">
                    <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=2187&auto=format&fit=crop"
                         alt="L'Éclat — Diamond Collection"
                         class="hero-img w-full h-full object-cover absolute inset-0">
                    <div class="card-overlay absolute inset-0"></div>

                    <!-- Number watermark -->
                    <span class="coll-number">01</span>

                    <!-- Content -->
                    <div class="absolute inset-0 flex flex-col justify-end p-10 md:p-14">
                        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                            <div>
                                <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-3 font-jost font-light">DIAMOND COLLECTION</p>
                                <h2 class="font-playfair text-5xl md:text-6xl font-light text-white mb-2 tracking-tight">L'ÉCLAT</h2>
                                <div class="card-line mb-4"></div>
                                <p class="text-white/60 font-jost font-light text-sm max-w-md leading-relaxed">
                                    The brilliance collection. Flawless diamonds set in 18k gold, each stone hand-selected for its fire and clarity. Pieces that catch every light in every room.
                                </p>
                            </div>
                            <div class="flex flex-col items-start md:items-end gap-4 shrink-0">
                                <p class="text-white/40 text-xs font-jost tracking-wide">Starting from</p>
                                <p class="font-playfair text-3xl text-white font-light">$2,800</p>
                                <a href="#" class="explore-btn btn-outline-white inline-block px-8 py-3 text-[10px] tracking-[0.25em] font-jost font-light">
                                    <span>EXPLORE COLLECTION</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ── L'OR + LA PERLE — Side by side ── -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">

                <!-- L'OR -->
                <div class="reveal reveal-delay-1">
                    <div class="split-card rounded-sm" style="height: 480px;">
                        <img src="https://images.unsplash.com/photo-1602751584552-8ba73aad9250?q=80&w=2187&auto=format&fit=crop"
                             alt="L'Or — Gold Collection"
                             class="split-img w-full h-full object-cover absolute inset-0">
                        <div class="split-overlay absolute inset-0"></div>
                        <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300; color:rgba(201,168,76,0.3); font-size:4rem; line-height:1;" class="absolute top-5 right-6 pointer-events-none transition-colors duration-400">02</span>

                        <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-10">
                            <p class="text-soft-gold text-[10px] tracking-[0.3em] mb-2 font-jost font-light">GOLD COLLECTION</p>
                            <h2 class="font-playfair text-4xl font-light text-white mb-2 tracking-tight">L'OR</h2>
                            <div class="split-line mb-4"></div>
                            <p class="text-white/55 font-jost font-light text-xs leading-relaxed mb-5 max-w-xs">
                                Pure warmth in every form. Sculpted in 18k and 22k gold by master artisans who have spent lifetimes understanding the metal's temperament.
                            </p>
                            <div class="flex items-center justify-between">
                                <p class="font-playfair text-2xl text-white font-light">From $1,200</p>
                                <a href="#" class="explore-btn text-[10px] tracking-[0.2em] font-jost text-soft-gold hover:text-gold-light transition-colors duration-300 flex items-center gap-2">
                                    EXPLORE <i class="fa-regular fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LA PERLE -->
                <div class="reveal reveal-delay-2">
                    <div class="split-card rounded-sm" style="height: 480px;">
                        <img src="https://images.unsplash.com/photo-1619856699906-09e1f58c98a1?q=80&w=2070&auto=format&fit=crop"
                             alt="La Perle — Pearl Collection"
                             class="split-img w-full h-full object-cover absolute inset-0">
                        <div class="split-overlay absolute inset-0"></div>
                        <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300; color:rgba(201,168,76,0.3); font-size:4rem; line-height:1;" class="absolute top-5 right-6 pointer-events-none">03</span>

                        <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-10">
                            <p class="text-soft-gold text-[10px] tracking-[0.3em] mb-2 font-jost font-light">PEARL COLLECTION</p>
                            <h2 class="font-playfair text-4xl font-light text-white mb-2 tracking-tight">LA PERLE</h2>
                            <div class="split-line mb-4"></div>
                            <p class="text-white/55 font-jost font-light text-xs leading-relaxed mb-5 max-w-xs">
                                The ocean's quiet luxury. South Sea and Akoya pearls, sourced from sustainable farms, set in gold to frame their natural luminescence.
                            </p>
                            <div class="flex items-center justify-between">
                                <p class="font-playfair text-2xl text-white font-light">From $900</p>
                                <a href="#" class="explore-btn text-[10px] tracking-[0.2em] font-jost text-soft-gold hover:text-gold-light transition-colors duration-300 flex items-center gap-2">
                                    EXPLORE <i class="fa-regular fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ── LA NUIT — Coming soon ── -->
            <div class="reveal reveal-delay-3">
                <div class="coming-soon-card rounded-sm" style="height: 240px;">
                    <div class="noise-overlay" style="opacity:0.04;"></div>
                    <div class="relative z-10 h-full flex flex-col md:flex-row items-center justify-between px-10 md:px-16 py-10 gap-8">
                        <div>
                            <span class="coming-soon-badge font-jost mb-5 block w-fit">COMING SOON</span>
                            <p class="text-white/25 text-[10px] tracking-[0.3em] mb-2 font-jost font-light">DARK STONES COLLECTION</p>
                            <h2 class="font-playfair text-4xl md:text-5xl font-light text-white/80 tracking-tight">LA NUIT</h2>
                        </div>
                        <div class="md:text-right max-w-sm">
                            <p class="text-white/30 font-jost font-light text-sm leading-relaxed mb-6">
                                Obsidian, black diamond, and midnight sapphire. A collection for those who find beauty in darkness. Arriving 2026.
                            </p>
                            <button class="text-[10px] tracking-[0.25em] font-jost text-soft-gold/60 hover:text-soft-gold transition-colors duration-300 border-b border-soft-gold/20 hover:border-soft-gold/50 pb-0.5">
                                NOTIFY ME WHEN AVAILABLE →
                            </button>
                        </div>
                        <!-- Floating ornament -->
                        <div class="hidden md:block absolute right-10 top-1/2 -translate-y-1/2 animate-float opacity-10">
                            <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300; color:var(--gold); font-size:9rem; line-height:1;">04</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- ══════════════════════════════════
         CRAFTSMANSHIP STRIP
    ══════════════════════════════════ -->
    <div class="stat-strip py-14 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-0 md:divide-x md:divide-white/8">
                <div class="text-center reveal">
                    <p class="font-playfair text-3xl text-white font-light mb-2">18k</p>
                    <p class="text-white/30 text-[10px] tracking-[0.25em] font-jost">GOLD STANDARD</p>
                </div>
                <div class="text-center reveal reveal-delay-1 md:py-0">
                    <p class="font-playfair text-3xl text-white font-light mb-2">40h</p>
                    <p class="text-white/30 text-[10px] tracking-[0.25em] font-jost">PER PIECE</p>
                </div>
                <div class="text-center reveal reveal-delay-2">
                    <p class="font-playfair text-3xl text-white font-light mb-2">100%</p>
                    <p class="text-white/30 text-[10px] tracking-[0.25em] font-jost">ETHICALLY SOURCED</p>
                </div>
                <div class="text-center reveal reveal-delay-3">
                    <p class="font-playfair text-3xl text-white font-light mb-2">∞</p>
                    <p class="text-white/30 text-[10px] tracking-[0.25em] font-jost">LIFETIME GUARANTEE</p>
                </div>
            </div>
        </div>
    </div>


    <!-- ══════════════════════════════════
         EDITORIAL FEATURE — The Atelier
    ══════════════════════════════════ -->
    <section class="py-24 px-6 md:px-12 bg-deep-ivory">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid md:grid-cols-2 gap-16 items-center">

                <div class="reveal">
                    <div class="relative overflow-hidden rounded-sm shadow-[0_24px_60px_rgba(0,0,0,0.1)]" style="height:520px;">
                        <img src="https://images.unsplash.com/photo-1506630448388-4e683c67ddb0?q=80&w=2070&auto=format&fit=crop"
                             alt="The Lumière Atelier"
                             class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                        <!-- Corner accent -->
                        <div class="absolute top-5 left-5 w-12 h-12 border-t border-l border-soft-gold/50"></div>
                        <div class="absolute bottom-5 right-5 w-12 h-12 border-b border-r border-soft-gold/50"></div>
                    </div>
                </div>

                <div class="reveal reveal-delay-2 max-w-lg">
                    <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-6 font-jost font-light">L'ATELIER</p>
                    <h2 class="font-playfair text-4xl md:text-5xl font-light text-charcoal mb-2 leading-tight">
                        Where each collection
                        <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;"> begins.</span>
                    </h2>
                    <span class="block w-12 h-px bg-soft-gold mt-6 mb-8"></span>
                    <p class="text-warm-gray font-jost font-light text-sm leading-relaxed mb-5">
                        Every Lumière collection starts as a sketch on paper in our Paris atelier. Our master jewellers — some carrying four generations of craft — translate these ideas into wax, then metal, then light.
                    </p>
                    <p class="text-warm-gray font-jost font-light text-sm leading-relaxed mb-10">
                        The collections you see here took between eight months and two years to develop. That is not delay — that is the pace of excellence.
                    </p>
                    <a href="#" class="btn-outline-dark inline-block px-8 py-3.5 text-[11px] tracking-[0.22em] font-jost">
                        <span>VISIT THE ATELIER</span>
                    </a>
                </div>

            </div>
        </div>
    </section>


    <!-- ══════════════════════════════════
         NEWSLETTER CTA
    ══════════════════════════════════ -->
    <section class="py-20 px-6 md:px-12 bg-charcoal">
        <div class="max-w-xl mx-auto text-center reveal">
            <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-5 font-jost font-light">FIRST ACCESS</p>
            <h2 class="font-playfair text-3xl md:text-4xl font-light text-white mb-4 leading-tight">
                Be the first to see<br>
                <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">La Nuit.</span>
            </h2>
            <span class="block w-12 h-px bg-soft-gold mx-auto my-7"></span>
            <p class="text-white/40 font-jost font-light text-sm mb-8 leading-relaxed">
                Join our inner circle and receive early access to new collections, private previews, and bespoke offers.
            </p>
            <div class="flex gap-0 max-w-sm mx-auto border-b border-white/20 pb-0 mb-5">
                <input type="email"
                       placeholder="Your email address"
                       class="flex-1 py-3 px-1 text-sm font-jost font-light bg-transparent text-white outline-none border-none placeholder-white/25">
                <button class="text-soft-gold text-[10px] tracking-[0.25em] font-jost font-light hover:text-gold-light transition-colors duration-300 pb-3 pl-4 whitespace-nowrap">
                    SUBSCRIBE →
                </button>
            </div>
            <p class="text-white/20 text-[10px] font-jost tracking-wide">By subscribing, you agree to our Privacy Policy.</p>
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
                    <h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">COLLECTIONS</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">L'Éclat — Diamonds</a></li>
                        <li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">L'Or — Gold</a></li>
                        <li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">La Perle — Pearls</a></li>
                        <li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide flex items-center gap-2">La Nuit <span class="text-soft-gold/50 text-[9px] tracking-wider">SOON</span></a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">SUPPORT</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">Contact Us</a></li>
                        <li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">FAQs</a></li>
                        <li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">Shipping & Returns</a></li>
                        <li><a href="#" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors duration-300 tracking-wide">Size Guide</a></li>
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
        const openMenu = () => { mobileMenu.classList.add('open'); overlay.classList.remove('hidden'); document.body.style.overflow = 'hidden'; };
        const closeMenu = () => { mobileMenu.classList.remove('open'); overlay.classList.add('hidden'); document.body.style.overflow = ''; };
        openBtn.addEventListener('click', openMenu);
        closeBtn.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);

        // Scroll reveal
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        reveals.forEach(el => observer.observe(el));
    </script>

</body>
</html>
