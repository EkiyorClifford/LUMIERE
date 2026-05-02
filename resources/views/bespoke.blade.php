<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bespoke Commission | LUMIÈRE</title>
    <meta name="description" content="Commission a one-of-a-kind piece, handcrafted exclusively for you.">

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
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=Jost:wght@200;300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        /* ── Progress bar ── */
        #progress-fill {
            transition: width 0.6s cubic-bezier(0.4,0,0.2,1);
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
        }

        /* ── Step panels ── */
        .step-panel {
            display: none;
            animation: stepIn 0.45s cubic-bezier(0.4,0,0.2,1) both;
        }
        .step-panel.active { display: block; }
        @keyframes stepIn {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes stepOut {
            from { opacity: 1; transform: translateY(0); }
            to   { opacity: 0; transform: translateY(-18px); }
        }

        /* ── Category cards ── */
        .cat-card {
            position: relative;
            cursor: pointer;
            border: 1px solid transparent;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
        }
        .cat-card input[type="radio"] { display: none; }
        .cat-card:hover {
            border-color: var(--gold);
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(201,168,76,0.12);
        }
        .cat-card.selected {
            border-color: var(--gold);
            box-shadow: 0 0 0 1px var(--gold), 0 12px 32px rgba(201,168,76,0.15);
        }
        .cat-card.selected .cat-check { opacity: 1; transform: scale(1); }
        .cat-check {
            opacity: 0;
            transform: scale(0.5);
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .cat-img {
            transition: transform 0.6s cubic-bezier(0.25,0.46,0.45,0.94);
        }
        .cat-card:hover .cat-img { transform: scale(1.05); }

        /* ── Option pills ── */
        .opt-pill {
            cursor: pointer;
            border: 1px solid rgba(28,28,28,0.15);
            transition: border-color 0.25s ease, background 0.25s ease, color 0.25s ease;
            user-select: none;
        }
        .opt-pill:hover { border-color: var(--gold); color: var(--charcoal); }
        .opt-pill.selected {
            background: var(--charcoal);
            border-color: var(--charcoal);
            color: #fff;
        }
        .opt-pill input { display: none; }

        /* ── Range slider ── */
        input[type="range"] {
            -webkit-appearance: none;
            width: 100%;
            height: 2px;
            background: rgba(28,28,28,0.12);
            outline: none;
            border-radius: 2px;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--gold);
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(201,168,76,0.4);
            transition: transform 0.2s ease;
        }
        input[type="range"]::-webkit-slider-thumb:hover { transform: scale(1.2); }

        /* ── Text inputs ── */
        .lux-input {
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(28,28,28,0.18);
            padding: 10px 0;
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.875rem;
            color: var(--charcoal);
            outline: none;
            transition: border-color 0.3s ease;
            width: 100%;
        }
        .lux-input:focus { border-bottom-color: var(--gold); }
        .lux-input::placeholder { color: rgba(28,28,28,0.3); letter-spacing: 0.05em; }
        .lux-textarea {
            background: var(--ivory);
            border: 1px solid transparent;
            padding: 14px 16px;
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.875rem;
            color: var(--charcoal);
            outline: none;
            resize: none;
            transition: border-color 0.3s ease;
            width: 100%;
        }
        .lux-textarea:focus { border-color: var(--gold); }
        .lux-textarea::placeholder { color: rgba(28,28,28,0.3); }

        /* ── Buttons ── */
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

        .btn-outline-dark {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(28,28,28,0.3);
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

        /* ── Step indicator dots ── */
        .step-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(28,28,28,0.15);
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .step-dot.active { background: var(--gold); transform: scale(1.4); }
        .step-dot.done { background: rgba(201,168,76,0.4); }

        /* ── Shimmer on gold text ── */
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        .gold-shimmer {
            background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 40%, var(--gold) 60%, var(--gold-light) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s linear infinite;
        }

        /* ── Nav scroll ── */
        #main-nav { transition: padding 0.4s ease, background 0.4s ease, box-shadow 0.4s ease; }
        #main-nav.scrolled {
            padding-top: 0.75rem; padding-bottom: 0.75rem;
            background: rgba(249,246,240,0.97);
            box-shadow: 0 1px 24px rgba(0,0,0,0.06);
        }
        .nav-link { position: relative; }
        .nav-link::after {
            content: ''; position: absolute; bottom: -3px; left: 0;
            width: 0; height: 1px; background: var(--gold);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }

        /* ── Success state ── */
        @keyframes checkDraw {
            from { stroke-dashoffset: 60; }
            to   { stroke-dashoffset: 0; }
        }
        .check-path {
            stroke-dasharray: 60;
            stroke-dashoffset: 60;
            animation: checkDraw 0.6s ease 0.3s forwards;
        }
        @keyframes circlePop {
            0%   { transform: scale(0); opacity: 0; }
            70%  { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        .success-circle {
            animation: circlePop 0.5s cubic-bezier(0.34,1.56,0.64,1) both;
        }

        /* ── Left panel image parallax ── */
        .panel-img {
            object-position: center;
            transition: object-position 0.1s linear;
        }
    </style>
</head>
<body class="bg-cream font-jost text-charcoal overflow-x-hidden">

    <!-- NAV (inherited from homepage) -->
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12 bg-cream/90 backdrop-blur-sm">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">
            <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal hover:text-soft-gold transition-colors duration-300">LUMIÈRE</a>
            <div class="hidden md:flex items-center gap-10">
                <a href="{{ route('collections') }}" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal transition-colors duration-300 font-jost">COLLECTIONS</a>
                <a href="{{ route('shop') }}"        class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal transition-colors duration-300 font-jost">SHOP</a>
                <a href="{{ route('atelier') }}"       class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal transition-colors duration-300 font-jost">ABOUT</a>
                <a href="{{ route('bespoke') }}"                        class="nav-link text-xs tracking-[0.18em] text-soft-gold font-jost">BESPOKE</a>
            </div>
            <div class="flex items-center gap-5">
                <button class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300"><i class="fa-regular fa-heart text-base"></i></button>
                @auth
                    <div class="relative group">
                        <button class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300 flex items-center gap-2">
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
                    <a href="{{ route('login') }}" class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300">
                        <i class="fa-regular fa-user text-base"></i>
                    </a>
                @endif
                <button class="text-charcoal/60 hover:text-soft-gold transition-colors duration-300 relative">
                    <i class="fa-solid fa-cart-shopping text-base"></i>
                    <span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center">{{ $cartCount ?? 0 }}</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- MAIN LAYOUT: left image panel + right form panel -->
    <div class="min-h-screen pt-[72px] md:pt-0 flex flex-col md:flex-row">

        <!-- ── LEFT PANEL (sticky image + copy) ── -->
        <div class="hidden md:flex md:w-[42%] lg:w-[38%] sticky top-0 h-screen flex-col overflow-hidden">
            <div class="absolute inset-0">
                <img id="panel-img"
                     src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=2070&auto=format&fit=crop"
                     alt="Bespoke Jewelry"
                     class="panel-img w-full h-full object-cover transition-all duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-black/30"></div>
            </div>
            <!-- Overlay copy -->
            <div class="relative z-10 flex flex-col justify-end h-full p-12 pb-16">
                <p class="text-white/50 text-[10px] tracking-[0.4em] mb-4 font-jost font-light">LUMIÈRE ATELIER</p>
                <h1 class="font-playfair text-4xl lg:text-5xl font-light text-white leading-tight mb-4">
                    Your Vision,<br>
                    <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">Our Craft</span>
                </h1>
                <div class="w-10 h-px bg-soft-gold mb-6"></div>
                <p class="text-white/55 text-sm font-jost font-light leading-relaxed max-w-xs">
                    Every bespoke commission begins with a conversation. Tell us your story — we'll craft the piece that tells it forever.
                </p>
                <!-- Trust signals -->
                <div class="mt-10 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-gem text-soft-gold text-xs"></i>
                        <span class="text-white/45 text-[11px] font-jost font-light tracking-wide">Ethically sourced gemstones</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-clock text-soft-gold text-xs"></i>
                        <span class="text-white/45 text-[11px] font-jost font-light tracking-wide">6–10 week crafting timeline</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-shield-halved text-soft-gold text-xs"></i>
                        <span class="text-white/45 text-[11px] font-jost font-light tracking-wide">Lifetime guarantee on every piece</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── RIGHT PANEL (form) ── -->
        <div class="flex-1 flex flex-col bg-cream overflow-y-auto">

            <!-- Progress bar (top of right panel) -->
            <div class="sticky top-0 z-20 bg-cream/95 backdrop-blur-sm pt-6 md:pt-10 px-8 md:px-14 lg:px-20 pb-0">
                <!-- Step counter -->
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10px] tracking-[0.25em] text-warm-gray font-jost font-light" id="step-label">STEP 1 OF 4</p>
                    <div class="flex items-center gap-2">
                        <div class="step-dot active" id="dot-1"></div>
                        <div class="step-dot" id="dot-2"></div>
                        <div class="step-dot" id="dot-3"></div>
                        <div class="step-dot" id="dot-4"></div>
                    </div>
                </div>
                <!-- Bar -->
                <div class="w-full h-px bg-charcoal/8 rounded-full mb-0 relative overflow-hidden" style="background:rgba(28,28,28,0.08);">
                    <div id="progress-fill" class="h-full rounded-full" style="width: 25%;"></div>
                </div>
            </div>

            <!-- Form body -->
            <div class="flex-1 px-8 md:px-14 lg:px-20 py-10 md:py-14">

                <!-- ════════════════════
                     STEP 1 — CATEGORY
                ════════════════════ -->
                <div class="step-panel active" id="step-1">
                    <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-3 font-jost font-light">BEGIN YOUR JOURNEY</p>
                    <h2 class="font-playfair text-3xl md:text-4xl font-light text-charcoal mb-2 leading-tight">
                        What would you like<br>
                        <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">us to create?</span>
                    </h2>
                    <div class="w-10 h-px bg-soft-gold mt-5 mb-10"></div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Ring -->
                        <label class="cat-card bg-deep-ivory rounded-sm overflow-hidden" data-value="ring">
                            <input type="radio" name="category" value="ring">
                            <div class="overflow-hidden aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=800&auto=format&fit=crop"
                                     class="cat-img w-full h-full object-cover" alt="Ring">
                            </div>
                            <div class="p-4 flex items-center justify-between">
                                <div>
                                    <p class="font-playfair text-base font-light text-charcoal">Ring</p>
                                    <p class="text-warm-gray text-[10px] font-jost font-light tracking-wide mt-0.5">From $1,200</p>
                                </div>
                                <div class="cat-check w-5 h-5 rounded-full bg-soft-gold flex items-center justify-center">
                                    <i class="fa-solid fa-check text-white text-[9px]"></i>
                                </div>
                            </div>
                        </label>
                        <!-- Necklace -->
                        <label class="cat-card bg-deep-ivory rounded-sm overflow-hidden" data-value="necklace">
                            <input type="radio" name="category" value="necklace">
                            <div class="overflow-hidden aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=800&auto=format&fit=crop"
                                     class="cat-img w-full h-full object-cover" alt="Necklace">
                            </div>
                            <div class="p-4 flex items-center justify-between">
                                <div>
                                    <p class="font-playfair text-base font-light text-charcoal">Necklace</p>
                                    <p class="text-warm-gray text-[10px] font-jost font-light tracking-wide mt-0.5">From $900</p>
                                </div>
                                <div class="cat-check w-5 h-5 rounded-full bg-soft-gold flex items-center justify-center">
                                    <i class="fa-solid fa-check text-white text-[9px]"></i>
                                </div>
                            </div>
                        </label>
                        <!-- Earrings -->
                        <label class="cat-card bg-deep-ivory rounded-sm overflow-hidden" data-value="earrings">
                            <input type="radio" name="category" value="earrings">
                            <div class="overflow-hidden aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1603561591411-07134e719f5d?q=80&w=800&auto=format&fit=crop"
                                     class="cat-img w-full h-full object-cover" alt="Earrings">
                            </div>
                            <div class="p-4 flex items-center justify-between">
                                <div>
                                    <p class="font-playfair text-base font-light text-charcoal">Earrings</p>
                                    <p class="text-warm-gray text-[10px] font-jost font-light tracking-wide mt-0.5">From $750</p>
                                </div>
                                <div class="cat-check w-5 h-5 rounded-full bg-soft-gold flex items-center justify-center">
                                    <i class="fa-solid fa-check text-white text-[9px]"></i>
                                </div>
                            </div>
                        </label>
                        <!-- Bracelet -->
                        <label class="cat-card bg-deep-ivory rounded-sm overflow-hidden" data-value="bracelet">
                            <input type="radio" name="category" value="bracelet">
                            <div class="overflow-hidden aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1589128777073-263566ae5e4d?q=80&w=800&auto=format&fit=crop"
                                     class="cat-img w-full h-full object-cover" alt="Bracelet">
                            </div>
                            <div class="p-4 flex items-center justify-between">
                                <div>
                                    <p class="font-playfair text-base font-light text-charcoal">Bracelet</p>
                                    <p class="text-warm-gray text-[10px] font-jost font-light tracking-wide mt-0.5">From $650</p>
                                </div>
                                <div class="cat-check w-5 h-5 rounded-full bg-soft-gold flex items-center justify-center">
                                    <i class="fa-solid fa-check text-white text-[9px]"></i>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="mt-10 flex justify-end">
                        <button class="btn-gold px-10 py-3.5 text-[11px] tracking-[0.22em] font-jost" id="next-1" disabled>
                            <span>CONTINUE &nbsp;→</span>
                        </button>
                    </div>
                </div>


                <!-- ════════════════════
                     STEP 2 — VISION
                ════════════════════ -->
                <div class="step-panel" id="step-2">
                    <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-3 font-jost font-light">DESIGN VISION</p>
                    <h2 class="font-playfair text-3xl md:text-4xl font-light text-charcoal mb-2 leading-tight">
                        Describe your<br>
                        <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">ideal piece</span>
                    </h2>
                    <div class="w-10 h-px bg-soft-gold mt-5 mb-10"></div>

                    <!-- Metal -->
                    <div class="mb-8">
                        <p class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost mb-4">METAL</p>
                        <div class="flex flex-wrap gap-2" id="metal-group">
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="metal">
                                <input type="radio" name="metal" value="18k Yellow Gold"> 18K YELLOW GOLD
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="metal">
                                <input type="radio" name="metal" value="18k White Gold"> 18K WHITE GOLD
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="metal">
                                <input type="radio" name="metal" value="Rose Gold"> ROSE GOLD
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="metal">
                                <input type="radio" name="metal" value="Platinum"> PLATINUM
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="metal">
                                <input type="radio" name="metal" value="Undecided"> UNDECIDED
                            </label>
                        </div>
                    </div>

                    <!-- Stone -->
                    <div class="mb-8">
                        <p class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost mb-4">PRIMARY STONE</p>
                        <div class="flex flex-wrap gap-2" id="stone-group">
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="stone">
                                <input type="radio" name="stone" value="Diamond"> DIAMOND
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="stone">
                                <input type="radio" name="stone" value="Sapphire"> SAPPHIRE
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="stone">
                                <input type="radio" name="stone" value="Emerald"> EMERALD
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="stone">
                                <input type="radio" name="stone" value="Ruby"> RUBY
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="stone">
                                <input type="radio" name="stone" value="Pearl"> PEARL
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="stone">
                                <input type="radio" name="stone" value="No Stone"> NO STONE
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="stone">
                                <input type="radio" name="stone" value="Open to advice"> OPEN TO ADVICE
                            </label>
                        </div>
                    </div>

                    <!-- Style -->
                    <div class="mb-8">
                        <p class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost mb-4">STYLE <span class="text-charcoal/30">(select all that apply)</span></p>
                        <div class="flex flex-wrap gap-2" id="style-group">
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="style" data-multi="true">
                                <input type="checkbox" name="style_preferences[]" value="Classic"> CLASSIC
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="style" data-multi="true">
                                <input type="checkbox" name="style_preferences[]" value="Minimalist"> MINIMALIST
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="style" data-multi="true">
                                <input type="checkbox" name="style_preferences[]" value="Art Deco"> ART DECO
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="style" data-multi="true">
                                <input type="checkbox" name="style_preferences[]" value="Romantic"> ROMANTIC
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="style" data-multi="true">
                                <input type="checkbox" name="style_preferences[]" value="Bold & Sculptural"> BOLD &amp; SCULPTURAL
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="style" data-multi="true">
                                <input type="checkbox" name="style_preferences[]" value="Vintage"> VINTAGE
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="style" data-multi="true">
                                <input type="checkbox" name="style_preferences[]" value="Nature-inspired"> NATURE-INSPIRED
                            </label>
                        </div>
                    </div>

                    <!-- Occasion -->
                    <div class="mb-10">
                        <p class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost mb-4">OCCASION</p>
                        <div class="flex flex-wrap gap-2" id="occasion-group">
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="occasion">
                                <input type="radio" name="occasion" value="Engagement"> ENGAGEMENT
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="occasion">
                                <input type="radio" name="occasion" value="Anniversary"> ANNIVERSARY
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="occasion">
                                <input type="radio" name="occasion" value="Self-gift"> SELF-GIFT
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="occasion">
                                <input type="radio" name="occasion" value="Birthday"> BIRTHDAY
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="occasion">
                                <input type="radio" name="occasion" value="Wedding"> WEDDING
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="occasion">
                                <input type="radio" name="occasion" value="Other"> OTHER
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <button class="btn-outline-dark px-8 py-3.5 text-[11px] tracking-[0.22em] font-jost" id="back-2">
                            <span>← &nbsp;BACK</span>
                        </button>
                        <button class="btn-gold px-10 py-3.5 text-[11px] tracking-[0.22em] font-jost" id="next-2">
                            <span>CONTINUE &nbsp;→</span>
                        </button>
                    </div>
                </div>


                <!-- ════════════════════
                     STEP 3 — DETAILS
                ════════════════════ -->
                <div class="step-panel" id="step-3">
                    <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-3 font-jost font-light">THE DETAILS</p>
                    <h2 class="font-playfair text-3xl md:text-4xl font-light text-charcoal mb-2 leading-tight">
                        A few more<br>
                        <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">considerations</span>
                    </h2>
                    <div class="w-10 h-px bg-soft-gold mt-5 mb-10"></div>

                    <!-- Budget -->
                    <div class="mb-10">
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost">BUDGET</p>
                            <p class="text-soft-gold font-playfair text-lg font-light" id="budget-display">$3,000</p>
                        </div>
                        <input type="range" id="budget-slider" min="500" max="20000" step="500" value="3000" class="w-full">
                        <div class="flex justify-between mt-2">
                            <span class="text-charcoal/30 text-[10px] font-jost">$500</span>
                            <span class="text-charcoal/30 text-[10px] font-jost">$20,000+</span>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="mb-10">
                        <p class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost mb-4">TIMELINE</p>
                        <div class="flex flex-wrap gap-2" id="timeline-group">
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="timeline">
                                <input type="radio" name="timeline" value="Flexible"> FLEXIBLE
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="timeline">
                                <input type="radio" name="timeline" value="3 months"> WITHIN 3 MONTHS
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="timeline">
                                <input type="radio" name="timeline" value="6 weeks"> WITHIN 6 WEEKS
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="timeline">
                                <input type="radio" name="timeline" value="Urgent"> URGENT (RUSH FEE)
                            </label>
                        </div>
                    </div>

                    <!-- Engraving / notes -->
                    <div class="mb-10">
                        <p class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost mb-4">YOUR STORY <span class="text-charcoal/30">(optional)</span></p>
                        <textarea id="notes" rows="4"
                                  placeholder="Share any inspirations, sentimental details, or specific wishes. A date, initials, a place — anything that makes this piece yours."
                                  class="lux-textarea rounded-sm"></textarea>
                    </div>

                    <!-- Engraving text -->
                    <div class="mb-10">
                        <p class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost mb-4">ENGRAVING <span class="text-charcoal/30">(optional, complimentary)</span></p>
                        <input type="text" id="engraving" maxlength="40"
                               placeholder="e.g. &quot;Pour toujours&quot; or initials"
                               class="lux-input">
                        <p class="text-charcoal/25 text-[10px] font-jost mt-2 text-right" id="engraving-count">0 / 40</p>
                    </div>

                    <div class="flex justify-between">
                        <button class="btn-outline-dark px-8 py-3.5 text-[11px] tracking-[0.22em] font-jost" id="back-3">
                            <span>← &nbsp;BACK</span>
                        </button>
                        <button class="btn-gold px-10 py-3.5 text-[11px] tracking-[0.22em] font-jost" id="next-3">
                            <span>CONTINUE &nbsp;→</span>
                        </button>
                    </div>
                </div>


                <!-- ════════════════════
                     STEP 4 — CONTACT
                ════════════════════ -->
                <div class="step-panel" id="step-4">
                    <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-3 font-jost font-light">ALMOST THERE</p>
                    <h2 class="font-playfair text-3xl md:text-4xl font-light text-charcoal mb-2 leading-tight">
                        How shall we<br>
                        <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">reach you?</span>
                    </h2>
                    <div class="w-10 h-px bg-soft-gold mt-5 mb-10"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-8 mb-8">
                        <div>
                            <label class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost block mb-1">FIRST NAME *</label>
                            <input type="text" id="fname" placeholder="Isabelle" class="lux-input">
                        </div>
                        <div>
                            <label class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost block mb-1">LAST NAME *</label>
                            <input type="text" id="lname" placeholder="Moreau" class="lux-input">
                        </div>
                        <div>
                            <label class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost block mb-1">EMAIL ADDRESS *</label>
                            <input type="email" id="email" placeholder="isabelle@example.com" class="lux-input">
                        </div>
                        <div>
                            <label class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost block mb-1">PHONE <span class="text-charcoal/30">(optional)</span></label>
                            <input type="tel" id="phone" placeholder="+33 6 00 00 00 00" class="lux-input">
                        </div>
                    </div>

                    <!-- Preferred contact -->
                    <div class="mb-8">
                        <p class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost mb-4">PREFERRED CONTACT METHOD</p>
                        <div class="flex flex-wrap gap-2" id="contact-group">
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="contact">
                                <input type="radio" name="contact" value="Email"> EMAIL
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="contact">
                                <input type="radio" name="contact" value="Phone"> PHONE
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="contact">
                                <input type="radio" name="contact" value="WhatsApp"> WHATSAPP
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="contact">
                                <input type="radio" name="contact" value="Video Call"> VIDEO CALL
                            </label>
                        </div>
                    </div>

                    <!-- Preferred time -->
                    <div class="mb-10">
                        <p class="text-[10px] tracking-[0.25em] text-charcoal/50 font-jost mb-4">BEST TIME TO REACH YOU</p>
                        <div class="flex flex-wrap gap-2" id="time-group">
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="time">
                                <input type="radio" name="time" value="Morning"> MORNING (9–12)
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="time">
                                <input type="radio" name="contact_time" value="Afternoon"> AFTERNOON (12–17)
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="time">
                                <input type="radio" name="contact_time" value="Evening"> EVENING (17–20)
                            </label>
                            <label class="opt-pill px-4 py-2 text-xs tracking-[0.15em] font-jost font-light rounded-sm" data-group="time">
                                <input type="radio" name="contact_time" value="Anytime"> ANYTIME
                            </label>
                        </div>
                    </div>

                    <!-- Error msg -->
                    <p id="form-error" class="text-red-400 text-xs font-jost mb-4 hidden">Please fill in your name and a valid email address.</p>

                    <!-- Privacy -->
                    <p class="text-charcoal/30 text-[10px] font-jost font-light leading-relaxed mb-8">
                        By submitting this form you agree to be contacted by our atelier team. We never share your information. 
                        <a href="#" class="underline hover:text-soft-gold transition-colors">Privacy Policy</a>
                    </p>

                    <div class="flex justify-between items-center">
                        <button class="btn-outline-dark px-8 py-3.5 text-[11px] tracking-[0.22em] font-jost" id="back-4">
                            <span>← &nbsp;BACK</span>
                        </button>
                        <button class="btn-gold px-10 py-3.5 text-[11px] tracking-[0.22em] font-jost" id="submit-btn">
                            <span>SUBMIT COMMISSION &nbsp;✦</span>
                        </button>
                    </div>
                </div>


                <!-- ════════════════════
                     SUCCESS STATE
                ════════════════════ -->
                <div class="step-panel" id="step-success">
                    <div class="text-center py-10">
                        <!-- Animated check -->
                        <div class="success-circle w-20 h-20 rounded-full border border-soft-gold/30 flex items-center justify-center mx-auto mb-10">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 16L13 23L26 9" stroke="#C9A84C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="check-path"/>
                            </svg>
                        </div>

                        <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-4 font-jost font-light">COMMISSION RECEIVED</p>
                        <h2 class="font-playfair text-3xl md:text-4xl font-light text-charcoal mb-4 leading-tight">
                            Your journey begins<br>
                            <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">right now</span>
                        </h2>
                        <div class="w-10 h-px bg-soft-gold mx-auto my-8"></div>
                        <p class="text-warm-gray text-sm font-jost font-light leading-relaxed max-w-sm mx-auto mb-2">
                            Thank you, <span id="success-name" class="text-charcoal font-normal"></span>. Our atelier team will reach out within <strong class="text-charcoal font-normal">24 hours</strong> to begin your consultation.
                        </p>
                        <p class="text-warm-gray text-sm font-jost font-light leading-relaxed max-w-sm mx-auto mb-12">
                            A confirmation has been sent to <span id="success-email" class="text-charcoal font-normal"></span>.
                        </p>

                        <!-- Summary card -->
                        <div class="bg-deep-ivory rounded-sm p-6 text-left max-w-sm mx-auto mb-12" id="summary-card">
                            <p class="text-[10px] tracking-[0.25em] text-charcoal/40 font-jost mb-4">YOUR COMMISSION SUMMARY</p>
                            <div class="space-y-2" id="summary-lines"></div>
                        </div>

                        <a href="{{ route('home') }}" class="btn-outline-dark inline-block px-10 py-3.5 text-[11px] tracking-[0.22em] font-jost">
                            <span>RETURN TO LUMIÈRE</span>
                        </a>
                    </div>
                </div>

            </div><!-- /form body -->
        </div><!-- /right panel -->
    </div><!-- /layout -->


    <script>
        // ── State ──
        const state = {
            category: null,
            metal: null,
            stone: null,
            style: [],
            occasion: null,
            budget: 3000,
            timeline: null,
            notes: '',
            engraving: '',
            contact: null,
            time: null,
            fname: '',
            lname: '',
            email: '',
            phone: '',
        };

        let currentStep = 1;
        const totalSteps = 4;

        // ── Panel images per step ──
        const panelImages = {
            1: 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=2188&auto=format&fit=crop',
            2: 'https://images.unsplash.com/photo-1602751584552-8ba73aad9250?q=80&w=2187&auto=format&fit=crop',
            3: 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=2187&auto=format&fit=crop',
            4: 'https://images.unsplash.com/photo-1530968033775-2c92736b131e?q=80&w=2071&auto=format&fit=crop',
        };

        // ── Go to step ──
        function goToStep(n) {
            document.getElementById(`step-${currentStep}`).classList.remove('active');
            currentStep = n;
            const target = n === 'success' ? 'step-success' : `step-${n}`;
            document.getElementById(target).classList.add('active');
            updateProgress(n);
            if (n !== 'success') updatePanelImage(n);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updateProgress(n) {
            if (n === 'success') {
                document.getElementById('progress-fill').style.width = '100%';
                document.getElementById('step-label').textContent = 'COMPLETE';
                [1,2,3,4].forEach(i => {
                    document.getElementById(`dot-${i}`).classList.remove('active');
                    document.getElementById(`dot-${i}`).classList.add('done');
                });
                return;
            }
            const pct = (n / totalSteps) * 100;
            document.getElementById('progress-fill').style.width = pct + '%';
            document.getElementById('step-label').textContent = `STEP ${n} OF ${totalSteps}`;
            [1,2,3,4].forEach(i => {
                const dot = document.getElementById(`dot-${i}`);
                dot.classList.remove('active','done');
                if (i < n) dot.classList.add('done');
                if (i === n) dot.classList.add('active');
            });
        }

        function updatePanelImage(n) {
            const img = document.getElementById('panel-img');
            img.style.opacity = '0';
            img.style.transform = 'scale(1.03)';
            setTimeout(() => {
                img.src = panelImages[n];
                img.style.transition = 'opacity 0.6s ease, transform 0.8s ease';
                img.style.opacity = '1';
                img.style.transform = 'scale(1)';
            }, 200);
        }

        // ── Category cards ──
        document.querySelectorAll('.cat-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                card.querySelector('input').checked = true;
                state.category = card.dataset.value;
                document.getElementById('next-1').disabled = false;
                document.getElementById('next-1').style.opacity = '1';
            });
        });
        document.getElementById('next-1').style.opacity = '0.45';

        // ── Option pills (radio) ──
        document.querySelectorAll('.opt-pill:not([data-multi])').forEach(pill => {
            pill.addEventListener('click', () => {
                const group = pill.dataset.group;
                document.querySelectorAll(`.opt-pill[data-group="${group}"]:not([data-multi])`).forEach(p => p.classList.remove('selected'));
                pill.classList.add('selected');
                const inp = pill.querySelector('input');
                inp.checked = true;
                state[group] = inp.value;
            });
        });

        // ── Option pills (checkbox / multi) ──
        document.querySelectorAll('.opt-pill[data-multi]').forEach(pill => {
            pill.addEventListener('click', () => {
                pill.classList.toggle('selected');
                const inp = pill.querySelector('input');
                inp.checked = !inp.checked;
                // rebuild style array
                state.style = Array.from(document.querySelectorAll('.opt-pill[data-multi].selected'))
                    .map(p => p.querySelector('input').value);
            });
        });

        // ── Budget slider ──
        const slider = document.getElementById('budget-slider');
        const budgetDisplay = document.getElementById('budget-display');
        slider.addEventListener('input', () => {
            const v = parseInt(slider.value);
            state.budget = v;
            budgetDisplay.textContent = v >= 20000 ? '$20,000+' : `$${v.toLocaleString()}`;
        });

        // ── Engraving counter ──
        const engravingInput = document.getElementById('engraving');
        engravingInput.addEventListener('input', () => {
            const len = engravingInput.value.length;
            document.getElementById('engraving-count').textContent = `${len} / 40`;
            state.engraving = engravingInput.value;
        });

        document.getElementById('notes').addEventListener('input', e => state.notes = e.target.value);

        // ── Navigation ──
        document.getElementById('next-1').addEventListener('click', () => {
            if (state.category) goToStep(2);
        });
        document.getElementById('back-2').addEventListener('click', () => goToStep(1));
        document.getElementById('next-2').addEventListener('click', () => goToStep(3));
        document.getElementById('back-3').addEventListener('click', () => goToStep(2));
        document.getElementById('next-3').addEventListener('click', () => goToStep(4));
        document.getElementById('back-4').addEventListener('click', () => goToStep(3));

        // ── Submit ──
        document.getElementById('submit-btn').addEventListener('click', () => {
            const fname = document.getElementById('fname').value.trim();
            const lname = document.getElementById('lname').value.trim();
            const email = document.getElementById('email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const errEl = document.getElementById('form-error');

            if (!fname || !lname || !emailRegex.test(email)) {
                errEl.classList.remove('hidden');
                return;
            }
            errEl.classList.add('hidden');

            state.fname = fname;
            state.lname = lname;
            state.email = email;
            state.phone = document.getElementById('phone').value.trim();

            // Populate success screen
            document.getElementById('success-name').textContent = fname;
            document.getElementById('success-email').textContent = email;

            const summaryData = [
                { label: 'Piece', value: capitalize(state.category) || '—' },
                { label: 'Metal', value: state.metal || 'TBD with artisan' },
                { label: 'Stone', value: state.stone || 'TBD with artisan' },
                { label: 'Style', value: state.style.length ? state.style.join(', ') : '—' },
                { label: 'Occasion', value: state.occasion || '—' },
                { label: 'Budget', value: state.budget >= 20000 ? '$20,000+' : `$${state.budget.toLocaleString()}` },
                { label: 'Timeline', value: state.timeline || 'Flexible' },
            ];
            if (state.engraving) summaryData.push({ label: 'Engraving', value: `"${state.engraving}"` });

            const summaryEl = document.getElementById('summary-lines');
            summaryEl.innerHTML = summaryData.map(d => `
                <div class="flex justify-between items-start gap-4 py-1.5 border-b border-charcoal/5 last:border-0">
                    <span class="text-[10px] tracking-[0.15em] text-charcoal/40 font-jost font-light whitespace-nowrap">${d.label.toUpperCase()}</span>
                    <span class="text-xs text-charcoal font-jost font-light text-right">${d.value}</span>
                </div>
            `).join('');

            // Hide progress indicators on success
            document.querySelector('.sticky').style.display = 'none';

            goToStep('success');
        });

        function capitalize(s) {
            if (!s) return '';
            return s.charAt(0).toUpperCase() + s.slice(1);
        }

        // ── Nav scroll ──
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 60);
        });
    </script>
</body>
</html>

