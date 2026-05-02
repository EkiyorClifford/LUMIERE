<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Size & Fit Guide | LUMIÈRE Fine Jewelry</title>
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
                    animation: { 'fade-up': 'fadeUp 0.8s ease both', 'shimmer': 'shimmer 4s linear infinite' }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@200;300;400;500&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #F9F6F0; }
        ::-webkit-scrollbar-thumb { background: #C9A84C; border-radius: 4px; }

        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -3px; left: 0; width: 0; height: 1px; background: #C9A84C; transition: width 0.3s ease; }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        #main-nav.scrolled { padding-top: 0.75rem; padding-bottom: 0.75rem; background: rgba(249,246,240,0.97); box-shadow: 0 1px 24px rgba(0,0,0,0.06); }

        .tab-content { display: none; opacity: 0; transform: translateY(10px); transition: opacity 0.4s ease, transform 0.4s ease; }
        .tab-content.active { display: block; opacity: 1; transform: translateY(0); }
        .tab-btn { position: relative; padding-bottom: 0.75rem; cursor: pointer; transition: color 0.25s; }
        .tab-btn::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background: #C9A84C; transition: width 0.3s ease; }
        .tab-btn.active { color: #C9A84C; }
        .tab-btn.active::after { width: 2rem; }

        .size-card { background: white; transition: box-shadow 0.3s ease, transform 0.3s ease; }
        .size-card:hover { box-shadow: 0 20px 35px -12px rgba(0,0,0,0.08); transform: translateY(-2px); }

        .method-step { position: relative; padding-left: 2.5rem; }
        .method-step::before { content: counter(step); counter-increment: step; position: absolute; left: 0; top: 0; width: 1.5rem; height: 1.5rem; background: rgba(201,168,76,0.1); color: #C9A84C; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-family: 'Playfair Display', serif; }
        .method-list { counter-reset: step; }

        .conversion-table th { font-weight: 400; letter-spacing: 0.1em; font-size: 0.65rem; color: #8A8580; padding: 1rem 0.75rem 0.75rem 0.75rem; border-bottom: 1px solid rgba(28,28,28,0.06); }
        .conversion-table td { padding: 0.75rem; border-bottom: 1px solid rgba(28,28,28,0.04); font-size: 0.8rem; }
        .conversion-table tr:last-child td { border-bottom: none; }

        .guide-hero { background: linear-gradient(135deg, #1a1a14 0%, #231f14 50%, #1C1C1C 100%); }
        .hero-dots { position: absolute; inset: 0; background-image: radial-gradient(rgba(201,168,76,0.06) 1px, transparent 1px); background-size: 40px 40px; pointer-events: none; }

        .reveal { opacity: 0; transform: translateY(24px); transition: all 0.8s cubic-bezier(0.2,0.9,0.4,1.1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        #mobile-menu { transform: translateX(100%); transition: transform 0.4s cubic-bezier(0.4,0,0.2,1); }
        #mobile-menu.open { transform: translateX(0); }

        .btn-outline-dark { position: relative; overflow: hidden; border: 1px solid #1C1C1C; color: #1C1C1C; transition: color 0.3s; background: transparent; }
        .btn-outline-dark::before { content: ''; position: absolute; inset: 0; background: #1C1C1C; transform: translateY(100%); transition: transform 0.32s cubic-bezier(0.4,0,0.2,1); }
        .btn-outline-dark:hover::before { transform: translateY(0); }
        .btn-outline-dark:hover { color: #fff; }
        .btn-outline-dark span { position: relative; z-index: 1; }

        .btn-gold { position: relative; overflow: hidden; background: #C9A84C; color: #fff; transition: color 0.3s; }
        .btn-gold::before { content: ''; position: absolute; inset: 0; background: #A8862E; transform: translateY(100%); transition: transform 0.32s cubic-bezier(0.4,0,0.2,1); }
        .btn-gold:hover::before { transform: translateY(0); }
        .btn-gold span { position: relative; z-index: 1; }

        .gold-shimmer { background: linear-gradient(90deg, #C9A84C 0%, #E8C97A 40%, #C9A84C 60%, #E8C97A 100%); background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; animation: shimmer 4s linear infinite; }

        /* ── Modals shared ── */
        .lumiere-modal { opacity:0; pointer-events:none; transition:opacity .4s ease; }
        .lumiere-modal.open { opacity:1; pointer-events:all; }
        .lumiere-panel { transform:translateY(32px); transition:transform .45s cubic-bezier(.4,0,.2,1); }
        .lumiere-modal.open .lumiere-panel { transform:translateY(0); }

        /* Floating label fields */
        .field-wrap { position:relative; }
        .field-input { width:100%; background:transparent; border:none; border-bottom:1px solid rgba(28,28,28,.15); padding:1.25rem 0 .5rem; font-family:'Jost',sans-serif; font-size:.85rem; font-weight:300; color:#1C1C1C; outline:none; transition:border-color .3s; }
        .field-input:focus { border-bottom-color:#C9A84C; }
        .field-label { position:absolute; top:1.1rem; left:0; font-family:'Jost',sans-serif; font-size:.7rem; font-weight:300; letter-spacing:.12em; color:rgba(138,133,128,.7); pointer-events:none; transition:top .25s,font-size .25s,color .25s,letter-spacing .25s; }
        .field-input:focus ~ .field-label,
        .field-input:not(:placeholder-shown) ~ .field-label { top:0; font-size:.6rem; letter-spacing:.2em; color:#C9A84C; }
        textarea.field-input { resize:none; }
        select.field-input { cursor:pointer; }

        /* Modal gold top line */
        .modal-top-line { height:1px; background:linear-gradient(to right, transparent, #C9A84C, transparent); }

        /* Success state */
        .modal-success { display:none; }
        .modal-success.show { display:flex; }
    </style>
</head>
<body class="bg-cream font-jost text-charcoal overflow-x-hidden">

    <!-- NAVIGATION -->
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12 transition-all duration-300">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">
            <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-white hover:text-soft-gold transition-colors">LUMIÈRE</a>
            <div class="hidden md:flex items-center gap-10">
                <a href="{{ route('collections') }}" class="nav-link text-xs tracking-[0.18em] text-white/70 hover:text-white">COLLECTIONS</a>
                <a href="{{ route('shop') }}" class="nav-link text-xs tracking-[0.18em] text-white/70 hover:text-white">SHOP</a>
                <a href="{{ route('atelier') }}" class="nav-link text-xs tracking-[0.18em] text-white/70 hover:text-white">ATELIER</a>
                <a href="{{ route('journal') }}" class="nav-link text-xs tracking-[0.18em] text-white/70 hover:text-white">JOURNAL</a>
                <a href="{{ route('size-guide') }}" class="nav-link active text-xs tracking-[0.18em] text-white">SIZE GUIDE</a>
            </div>
            <div class="flex items-center gap-5">
                <button class="text-white/50 hover:text-soft-gold"><i class="fa-regular fa-heart"></i></button>
                @auth
                    <div class="relative group">
                        <button class="text-white/50 hover:text-soft-gold flex items-center gap-2">
                            <i class="fa-solid fa-user"></i>
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
                    <a href="{{ route('login') }}" class="text-white/50 hover:text-soft-gold">
                        <i class="fa-regular fa-user"></i>
                    </a>
                @endif
                <button class="text-white/50 hover:text-soft-gold relative"><i class="fa-solid fa-cart-shopping"></i><span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center">{{ $cartCount ?? 0 }}</span></button>
                <button id="menu-open" class="md:hidden text-white/70"><i class="fa-solid fa-bars text-lg"></i></button>
            </div>
        </div>
    </nav>

    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-cream z-[60] shadow-2xl flex flex-col px-10 py-12">
        <button id="menu-close" class="self-end text-charcoal/50 hover:text-charcoal mb-10"><i class="fa-solid fa-xmark text-xl"></i></button>
        <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal mb-10 block">LUMIÈRE</a>
        <div class="flex flex-col gap-7">
            <a href="{{ route('collections') }}" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold">COLLECTIONS</a>
            <a href="{{ route('shop') }}" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold">SHOP</a>
            <a href="{{ route('atelier') }}" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold">ATELIER</a>
            <a href="{{ route('journal') }}" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold">JOURNAL</a>
            <a href="{{ route('size-guide') }}" class="text-xs tracking-[0.18em] text-soft-gold">SIZE GUIDE</a>
        </div>
        <div class="mt-auto flex gap-5 text-charcoal/40"><a href="#"><i class="fa-brands fa-instagram text-lg hover:text-soft-gold"></i></a><a href="#"><i class="fa-brands fa-pinterest text-lg hover:text-soft-gold"></i></a></div>
    </div>
    <div id="menu-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden"></div>

    <!-- HERO SECTION — editorial, luxurious -->
    <section class="guide-hero relative pt-40 pb-24 px-6 overflow-hidden">
        <div class="hero-dots"></div>
        <div class="absolute inset-0 opacity-10"><img src="https://images.unsplash.com/photo-1506630448388-4e683c67ddb0?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover grayscale"></div>
        <div class="relative z-10 max-w-screen-xl mx-auto text-center">
            <p class="text-soft-gold text-[10px] tracking-[0.4em] mb-6 animate-fade-up">LUMIÈRE · PLACE VENDÔME</p>
            <h1 class="font-playfair font-light text-white text-5xl md:text-7xl mb-6 animate-fade-up" style="animation-delay: 0.1s;">The Art of <span class="font-cormorant italic gold-shimmer">Perfect Fit</span></h1>
            <span class="block w-12 h-px bg-soft-gold mx-auto mb-6 animate-fade-up" style="animation-delay: 0.2s;"></span>
            <p class="text-white/45 font-jost font-light text-sm max-w-xl mx-auto leading-relaxed animate-fade-up" style="animation-delay: 0.3s;">A guide to finding your ideal size — because a piece that fits perfectly feels like it was made only for you.</p>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <div class="max-w-6xl mx-auto px-6 py-20">

        <!-- TABS — elegant underline style -->
        <div class="flex justify-center gap-8 md:gap-12 mb-16 border-b border-charcoal/8 pb-0">
            <button class="tab-btn active text-[11px] tracking-[0.25em] uppercase font-jost font-light text-charcoal/50 transition-all" onclick="openTab(event, 'rings')">Rings</button>
            <button class="tab-btn text-[11px] tracking-[0.25em] uppercase font-jost font-light text-charcoal/50 transition-all" onclick="openTab(event, 'necklaces')">Necklaces</button>
            <button class="tab-btn text-[11px] tracking-[0.25em] uppercase font-jost font-light text-charcoal/50 transition-all" onclick="openTab(event, 'bracelets')">Bracelets</button>
            <button class="tab-btn text-[11px] tracking-[0.25em] uppercase font-jost font-light text-charcoal/50 transition-all" onclick="openTab(event, 'earrings')">Earrings</button>
        </div>

        <!-- ========== RINGS TAB ========== -->
        <div id="rings" class="tab-content active">
            <div class="grid lg:grid-cols-2 gap-16">
                <!-- Left: How to measure -->
                <div class="reveal">
                    <div class="mb-8">
                        <h2 class="font-playfair text-2xl font-light mb-4">Finding your ring size</h2>
                        <p class="text-warm-gray text-sm font-light leading-relaxed">A well-fitted ring should slide over your knuckle with gentle resistance — not too tight, not too loose. Follow these steps for an accurate measurement.</p>
                    </div>

                    <div class="space-y-6 method-list">
                        <div class="method-step">
                            <h3 class="font-jost text-[10px] tracking-[0.2em] uppercase mb-1 text-charcoal/60">Step 01</h3>
                            <p class="text-sm font-light text-warm-gray">Wrap a strip of paper or string around the base of your finger where the ring will sit.</p>
                        </div>
                        <div class="method-step">
                            <h3 class="font-jost text-[10px] tracking-[0.2em] uppercase mb-1 text-charcoal/60">Step 02</h3>
                            <p class="text-sm font-light text-warm-gray">Mark where the paper meets. Straighten and measure the length in millimeters.</p>
                        </div>
                        <div class="method-step">
                            <h3 class="font-jost text-[10px] tracking-[0.2em] uppercase mb-1 text-charcoal/60">Step 03</h3>
                            <p class="text-sm font-light text-warm-gray">Use the conversion chart to find your corresponding ring size.</p>
                        </div>
                        <div class="method-step">
                            <h3 class="font-jost text-[10px] tracking-[0.2em] uppercase mb-1 text-charcoal/60">Pro Tip</h3>
                            <p class="text-sm font-light text-warm-gray">Measure at the end of the day when your fingers are slightly larger. For wider bands (5mm+), consider going up half a size.</p>
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <a href="#" class="btn-outline-dark inline-flex items-center justify-center gap-2 px-6 py-3 text-[10px] tracking-[0.2em]"><span><i class="fa-solid fa-print mr-2"></i> PRINTABLE RING SIZER</span></a>
                        <a href="#" class="btn-gold inline-flex items-center justify-center gap-2 px-6 py-3 text-[10px] tracking-[0.2em]"><span><i class="fa-solid fa-envelope mr-2"></i> REQUEST FREE SIZER KIT</span></a>
                    </div>
                </div>

                <!-- Right: Conversion Table -->
                <div class="reveal" style="transition-delay: 0.15s;">
                    <div class="size-card p-6 md:p-8 rounded-sm">
                        <h3 class="font-playfair text-xl font-light mb-6 text-center">International Conversion Chart</h3>
                        <table class="conversion-table w-full text-center">
                            <thead>
                                <tr><th>US/Canada</th><th>UK/Australia</th><th>Europe</th><th>Japan</th><th>mm Ø</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>4</td><td>H</td><td>47</td><td>7</td><td>14.9</td></tr>
                                <tr><td>4.5</td><td>I ½</td><td>48</td><td>8</td><td>15.3</td></tr>
                                <tr><td>5</td><td>J ½</td><td>49</td><td>9</td><td>15.7</td></tr>
                                <tr><td>5.5</td><td>K ½</td><td>50.5</td><td>10</td><td>16.1</td></tr>
                                <tr><td>6</td><td>L ½</td><td>52</td><td>11</td><td>16.5</td></tr>
                                <tr><td>6.5</td><td>M ½</td><td>53</td><td>12</td><td>16.9</td></tr>
                                <tr><td>7</td><td>N ½</td><td>54</td><td>13</td><td>17.3</td></tr>
                                <tr><td>7.5</td><td>O ½</td><td>55.5</td><td>14</td><td>17.7</td></tr>
                                <tr><td>8</td><td>P ½</td><td>57</td><td>15</td><td>18.1</td></tr>
                                <tr><td>8.5</td><td>Q ½</td><td>58</td><td>16</td><td>18.5</td></tr>
                                <tr><td>9</td><td>R ½</td><td>59</td><td>17</td><td>18.9</td></tr>
                                <tr><td>10</td><td>T ½</td><td>62</td><td>19</td><td>19.8</td></tr>
                            </tbody>
                        </table>
                        <p class="text-[9px] text-warm-gray/60 text-center mt-6 font-jost">If you're between sizes, we recommend sizing up for comfort.</p>
                    </div>
                </div>
            </div>

            <!-- Sizing tip card -->
            <div class="mt-16 p-8 bg-deep-ivory rounded-sm flex flex-col md:flex-row items-center justify-between gap-6 reveal">
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-rotate text-soft-gold text-2xl"></i>
                    <div>
                        <p class="font-playfair text-lg font-light">Free resizing within your first year</p>
                        <p class="text-xs text-warm-gray font-light">Every Lumière ring comes with one complimentary resize — no questions asked.</p>
                    </div>
                </div>
                <button id="open-concierge-rings" class="text-[10px] tracking-[0.2em] text-soft-gold border-b border-soft-gold/30 pb-0.5 hover:border-soft-gold transition-all whitespace-nowrap">CONTACT CONCIERGE →</button>
            </div>
        </div>

        <!-- ========== NECKLACES TAB ========== -->
        <div id="necklaces" class="tab-content">
            <div class="grid lg:grid-cols-2 gap-16">
                <div class="reveal">
                    <h2 class="font-playfair text-2xl font-light mb-4">Choosing your necklace length</h2>
                    <p class="text-warm-gray text-sm font-light leading-relaxed mb-8">The same necklace can look completely different depending on length. Here's where each length sits and what neckline it pairs with.</p>
                    <div class="space-y-6">
                        <div><div class="flex justify-between items-center border-b border-charcoal/10 py-3"><span class="font-jost text-xs tracking-wide">14–16" (Choker)</span><span class="text-xs text-warm-gray font-light">Sits high on neck, best with off-shoulder or plunging necklines</span></div></div>
                        <div><div class="flex justify-between items-center border-b border-charcoal/10 py-3"><span class="font-jost text-xs tracking-wide">18" (Princess)</span><span class="text-xs text-warm-gray font-light">Sits at collarbone — the most versatile, everyday length</span></div></div>
                        <div><div class="flex justify-between items-center border-b border-charcoal/10 py-3"><span class="font-jost text-xs tracking-wide">20–22" (Matinee)</span><span class="text-xs text-warm-gray font-light">Falls just above the bust, ideal for high necklines or layering</span></div></div>
                        <div><div class="flex justify-between items-center border-b border-charcoal/10 py-3"><span class="font-jost text-xs tracking-wide">24–26" (Opera)</span><span class="text-xs text-warm-gray font-light">Hits below the bust — dramatic, perfect for evening wear</span></div></div>
                        <div><div class="flex justify-between items-center border-b border-charcoal/10 py-3"><span class="font-jost text-xs tracking-wide">30–36" (Rope)</span><span class="text-xs text-warm-gray font-light">Can be worn as a single long strand or doubled as a collar</span></div></div>
                    </div>
                </div>
                <div class="reveal bg-white p-8 rounded-sm flex flex-col items-center text-center" style="transition-delay: 0.15s;">
                    <div class="w-full aspect-[2/5] max-w-[120px] mx-auto mb-6 relative">
                        <div class="absolute top-0 w-1 h-8 bg-soft-gold/30 left-1/2 -translate-x-1/2"></div>
                        <div class="absolute top-10 w-2 h-2 rounded-full bg-soft-gold left-1/2 -translate-x-1/2"></div>
                        <!-- Visual guide would go here in production -->
                        <i class="fa-solid fa-gem text-5xl text-soft-gold/20 absolute bottom-0 left-1/2 -translate-x-1/2"></i>
                    </div>
                    <p class="text-sm font-light text-warm-gray mb-4">Not sure which length suits you?</p>
                    <button id="open-concierge-necklaces" class="text-[10px] tracking-[0.2em] text-soft-gold border-b border-soft-gold/30 pb-0.5 hover:border-soft-gold transition-all">WRITE TO OUR CONCIERGE</button>
                    <p class="text-[9px] text-warm-gray/50 mt-4 font-jost">We'll help you find the right length before you order.</p>
                </div>
            </div>
        </div>

        <!-- ========== BRACELETS TAB ========== -->
        <div id="bracelets" class="tab-content">
            <div class="grid lg:grid-cols-2 gap-16">
                <div class="reveal">
                    <h2 class="font-playfair text-2xl font-light mb-4">Bracelet & Bangle Sizing</h2>
                    <p class="text-warm-gray text-sm font-light leading-relaxed mb-8">For chain bracelets, add 1.5–2cm to your wrist measurement. For bangles, you'll need to measure the widest part of your hand.</p>
                    <div class="bg-white p-6 rounded-sm mb-6">
                        <p class="text-[10px] tracking-[0.2em] font-jost text-soft-gold mb-3">CHAIN BRACELETS</p>
                        <div class="space-y-3">
                            <div class="flex justify-between"><span class="text-sm">Wrist 14–15cm</span><span class="text-sm font-light">→ Order 17cm</span></div>
                            <div class="flex justify-between"><span class="text-sm">Wrist 15–16cm</span><span class="text-sm font-light">→ Order 18cm</span></div>
                            <div class="flex justify-between"><span class="text-sm">Wrist 16–17cm</span><span class="text-sm font-light">→ Order 19cm</span></div>
                            <div class="flex justify-between"><span class="text-sm">Wrist 17–18cm</span><span class="text-sm font-light">→ Order 20cm</span></div>
                            <div class="flex justify-between"><span class="text-sm">Wrist 18–19cm</span><span class="text-sm font-light">→ Order 21cm</span></div>
                        </div>
                    </div>
                    <div class="bg-deep-ivory p-6 rounded-sm">
                        <p class="text-[10px] tracking-[0.2em] font-jost text-soft-gold mb-3">BANGLES</p>
                        <p class="text-sm font-light text-warm-gray">Measure the widest part of your hand by bringing your thumb and fingers together. For most women, a 6.5cm–7cm bangle fits comfortably. For men, 7.5cm–8cm.</p>
                    </div>
                </div>
                <div class="reveal size-card p-8 flex flex-col items-center text-center" style="transition-delay: 0.15s;">
                    <i class="fa-solid fa-hand-peace text-4xl text-soft-gold/40 mb-4"></i>
                    <p class="text-sm font-light text-charcoal mb-4">Need a specific fit for a gift?</p>
                    <p class="text-xs text-warm-gray font-light mb-6">We offer complimentary resizing within the first 60 days for all chain bracelets.</p>
                    <button id="open-concierge-bracelets" class="btn-outline-dark inline-block px-8 py-3 text-[10px] tracking-[0.2em]"><span>CONTACT CONCIERGE</span></button>
                </div>
            </div>
        </div>

        <!-- ========== EARRINGS TAB ========== -->
        <div id="earrings" class="tab-content">
            <div class="grid lg:grid-cols-2 gap-16">
                <div class="reveal">
                    <h2 class="font-playfair text-2xl font-light mb-4">Earring sizing & fit</h2>
                    <p class="text-warm-gray text-sm font-light leading-relaxed mb-8">All Lumière earrings are crafted with comfort as a priority. Hypoallergenic posts and secure closures are standard across every piece.</p>
                    <div class="space-y-5">
                        <div><span class="text-soft-gold text-xs tracking-wide block mb-1">STUDS</span><p class="text-sm font-light text-warm-gray">4–6mm: Subtle, everyday. 7–10mm: Noticeable, elegant. Our most popular size is 6mm.</p></div>
                        <div><span class="text-soft-gold text-xs tracking-wide block mb-1">HOOPS</span><p class="text-sm font-light text-warm-gray">10–15mm: Minimal, delicate. 20–25mm: Classic, versatile. 30–40mm: Statement, evening.</p></div>
                        <div><span class="text-soft-gold text-xs tracking-wide block mb-1">DROP & CHANDELIER</span><p class="text-sm font-light text-warm-gray">25–50mm: Dramatic, formal. Best for special occasions and evening events.</p></div>
                    </div>
                </div>
                <div class="reveal size-card p-8" style="transition-delay: 0.15s;">
                    <div class="flex items-start gap-4 mb-6">
                        <i class="fa-solid fa-ear-listen text-soft-gold text-2xl"></i>
                        <div>
                            <p class="text-sm font-medium">For sensitive ears</p>
                            <p class="text-xs text-warm-gray font-light">All posts are 14k gold or platinum — no nickel, no alloys. If you have known sensitivities, please note it during checkout and we'll ensure your piece is made with extra care.</p>
                        </div>
                    </div>
                    <hr class="my-6 border-charcoal/5">
                    <div class="flex items-start gap-4">
                        <i class="fa-solid fa-clock text-soft-gold text-2xl"></i>
                        <div>
                            <p class="text-sm font-medium">First piercing?</p>
                            <p class="text-xs text-warm-gray font-light">We recommend waiting 6 weeks before wearing heavier earrings. Start with our stud collection — each piece weighs under 2 grams.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONCIERGE SECTION — consistent across all tabs -->
        <div class="mt-24 text-center reveal pt-12 border-t border-charcoal/8">
            <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-4 font-jost">STILL UNCERTAIN?</p>
            <h2 class="font-playfair text-3xl md:text-4xl font-light mb-4">Your personal <span class="font-cormorant italic">consultant awaits</span></h2>
            <p class="text-warm-gray text-sm font-light max-w-md mx-auto mb-10">Not sure about sizing? Our team is here to help before your piece ships. Write to us and we'll respond within 24 hours.</p>
            <div class="flex flex-col sm:flex-row gap-5 justify-center">
                <button id="open-fitting" class="btn-gold px-10 py-4 text-[10px] tracking-[0.25em]"><span>REQUEST A FITTING CONSULTATION</span></button>
                <button id="open-concierge-main" class="btn-outline-dark px-10 py-4 text-[10px] tracking-[0.25em]"><span>WRITE TO OUR CONCIERGE</span></button>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-[#161616] pt-16 pb-8 px-6 md:px-12 mt-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div><h3 class="font-playfair text-2xl font-light text-white mb-4 tracking-widest">LUMIÈRE</h3><p class="text-white/35 text-xs font-jost font-light leading-relaxed max-w-[180px]">Timeless elegance crafted for the discerning soul.</p></div>
                <div><h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">SHOP</h4><ul class="space-y-3"><li><a href="shop.html" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Necklaces</a></li><li><a href="shop.html" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Rings</a></li><li><a href="shop.html" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Earrings</a></li><li><a href="shop.html" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Bracelets</a></li></ul></div>
                <div><h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">SUPPORT</h4><ul class="space-y-3"><li><a href="{{ route('contact') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Contact Us</a></li><li><a href="{{ route('faq') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">FAQs</a></li><li><a href="{{ route('shipping') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Shipping & Returns</a></li><li><a href="{{ route('size-guide') }}" class="text-white/35 hover:text-soft-gold text-xs font-jost font-light transition-colors">Size Guide</a></li></ul></div>
                <div><h4 class="text-white/60 text-[9px] font-jost tracking-[0.3em] mb-5">FOLLOW</h4><div class="flex gap-5"><a href="#" class="text-white/35 hover:text-soft-gold transition-colors"><i class="fa-brands fa-instagram text-base"></i></a><a href="#" class="text-white/35 hover:text-soft-gold transition-colors"><i class="fa-brands fa-pinterest text-base"></i></a><a href="#" class="text-white/35 hover:text-soft-gold transition-colors"><i class="fa-brands fa-x-twitter text-base"></i></a></div></div>
            </div>
            <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center gap-3">
                <p class="text-white/20 text-[10px] font-jost font-light tracking-wide">© 2026 Lumière Jewelry. All rights reserved.</p>
                <p class="text-white/20 text-[10px] font-jost font-light tracking-wide">Crafted with elegance in Paris.</p>
            </div>
        </div>
    </footer>


    <!-- ══════════════════════════════════
         MODAL 1 — FITTING CONSULTATION
    ══════════════════════════════════ -->
    <div id="fitting-modal" class="lumiere-modal fixed inset-0 z-[80] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-black/55 backdrop-blur-sm" id="fitting-backdrop"></div>
        <div class="lumiere-panel relative w-full max-w-lg bg-cream shadow-[0_40px_100px_rgba(0,0,0,0.2)] overflow-hidden">
            <div class="modal-top-line"></div>
            <button class="modal-close-btn absolute top-5 right-5 w-8 h-8 flex items-center justify-center text-charcoal/30 hover:text-charcoal transition-colors z-10" data-modal="fitting-modal">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>

            <!-- Form -->
            <div class="fitting-form-wrap p-10 md:p-12">
                <p class="text-soft-gold text-[10px] tracking-[0.35em] font-jost font-light mb-5">LUMIÈRE · SIZING SERVICE</p>
                <h2 class="font-playfair text-3xl font-light text-charcoal leading-tight mb-1">Fitting Consultation</h2>
                <p class="font-cormorant italic text-warm-gray text-lg font-light mb-1" style="font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:300">— we'll help you get it right</p>
                <div class="w-10 h-px bg-soft-gold my-6"></div>
                <p class="text-warm-gray font-jost font-light text-xs leading-relaxed mb-8">Tell us which piece you're sizing for and your measurement. We'll respond within 24 hours with a personal recommendation.</p>

                <div class="space-y-7">
                    <div class="field-wrap">
                        <input type="text" id="fit-name" class="field-input" placeholder=" ">
                        <label for="fit-name" class="field-label">YOUR NAME</label>
                    </div>
                    <div class="field-wrap">
                        <input type="email" id="fit-email" class="field-input" placeholder=" ">
                        <label for="fit-email" class="field-label">EMAIL ADDRESS</label>
                    </div>
                    <div class="field-wrap">
                        <select id="fit-category" class="field-input" style="padding-top:1.1rem">
                            <option value="" disabled selected></option>
                            <option value="ring">Ring</option>
                            <option value="bracelet">Bracelet</option>
                            <option value="bangle">Bangle</option>
                            <option value="necklace">Necklace</option>
                        </select>
                        <label for="fit-category" class="field-label" id="fit-category-label">PIECE CATEGORY</label>
                    </div>
                    <div class="field-wrap">
                        <input type="text" id="fit-measurement" class="field-input" placeholder=" ">
                        <label for="fit-measurement" class="field-label">YOUR MEASUREMENT (optional)</label>
                    </div>
                    <div class="field-wrap">
                        <textarea id="fit-notes" class="field-input" placeholder=" " rows="2"></textarea>
                        <label for="fit-notes" class="field-label">SPECIFIC PIECE OR NOTES (optional)</label>
                    </div>
                </div>

                <p class="fitting-error hidden text-[11px] font-jost text-red-400 mt-4"></p>

                <button class="fitting-submit btn-gold w-full mt-8 py-4 text-[11px] tracking-[0.25em] font-jost flex items-center justify-center gap-3">
                    <span class="submit-label">SEND REQUEST</span>
                    <span class="submit-spinner hidden"><i class="fa-solid fa-circle-notch fa-spin text-sm"></i></span>
                </button>
                <p class="text-warm-gray/50 text-[10px] font-jost text-center mt-5">We respond personally within 24 hours.</p>
            </div>

            <!-- Success -->
            <div class="fitting-success modal-success p-10 md:p-12 flex-col items-center justify-center text-center" style="min-height:420px">
                <div class="w-14 h-14 border border-soft-gold/40 flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-check text-soft-gold text-lg"></i>
                </div>
                <p class="text-soft-gold text-[10px] tracking-[0.35em] font-jost font-light mb-4">REQUEST RECEIVED</p>
                <h3 class="font-playfair text-2xl font-light text-charcoal mb-1">Thank you,</h3>
                <p class="fitting-success-name font-cormorant italic text-charcoal text-xl font-light mb-1" style="font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:300"></p>
                <div class="w-8 h-px bg-soft-gold mx-auto my-6"></div>
                <p class="text-warm-gray font-jost font-light text-xs leading-relaxed max-w-xs mx-auto mb-8">We've noted your sizing request. One of our team will be in touch personally within 24 hours with a recommendation tailored to you.</p>
                <button class="modal-close-btn btn-outline-dark inline-block px-8 py-3 text-[10px] tracking-[0.22em] font-jost" data-modal="fitting-modal"><span>CLOSE</span></button>
            </div>
        </div>
    </div>


    <!-- ══════════════════════════════════
         MODAL 2 — CONCIERGE
    ══════════════════════════════════ -->
    <div id="concierge-modal" class="lumiere-modal fixed inset-0 z-[80] flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-black/55 backdrop-blur-sm" id="concierge-backdrop"></div>
        <div class="lumiere-panel relative w-full max-w-lg bg-cream shadow-[0_40px_100px_rgba(0,0,0,0.2)] overflow-hidden">
            <div class="modal-top-line"></div>
            <button class="modal-close-btn absolute top-5 right-5 w-8 h-8 flex items-center justify-center text-charcoal/30 hover:text-charcoal transition-colors z-10" data-modal="concierge-modal">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>

            <!-- Form -->
            <div class="concierge-form-wrap p-10 md:p-12">
                <p class="text-soft-gold text-[10px] tracking-[0.35em] font-jost font-light mb-5">LUMIÈRE · CONCIERGE</p>
                <h2 class="font-playfair text-3xl font-light text-charcoal leading-tight mb-1">Write to Us</h2>
                <p class="font-cormorant italic text-warm-gray text-lg font-light mb-1" style="font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:300">— a real person will reply</p>
                <div class="w-10 h-px bg-soft-gold my-6"></div>
                <p class="text-warm-gray font-jost font-light text-xs leading-relaxed mb-8">Any question about sizing, gifting, a specific piece, or anything else. We read every message and reply personally.</p>

                <div class="space-y-7">
                    <div class="field-wrap">
                        <input type="text" id="con-name" class="field-input" placeholder=" ">
                        <label for="con-name" class="field-label">YOUR NAME</label>
                    </div>
                    <div class="field-wrap">
                        <input type="email" id="con-email" class="field-input" placeholder=" ">
                        <label for="con-email" class="field-label">EMAIL ADDRESS</label>
                    </div>
                    <div class="field-wrap">
                        <select id="con-subject" class="field-input" style="padding-top:1.1rem">
                            <option value="" disabled selected></option>
                            <option value="sizing">Sizing question</option>
                            <option value="gift">Buying a gift</option>
                            <option value="product">Question about a piece</option>
                            <option value="order">Existing order</option>
                            <option value="other">Something else</option>
                        </select>
                        <label for="con-subject" class="field-label" id="con-subject-label">SUBJECT</label>
                    </div>
                    <div class="field-wrap">
                        <textarea id="con-message" class="field-input" placeholder=" " rows="3"></textarea>
                        <label for="con-message" class="field-label">YOUR MESSAGE</label>
                    </div>
                </div>

                <p class="concierge-error hidden text-[11px] font-jost text-red-400 mt-4"></p>

                <button class="concierge-submit btn-gold w-full mt-8 py-4 text-[11px] tracking-[0.25em] font-jost flex items-center justify-center gap-3">
                    <span class="submit-label">SEND MESSAGE</span>
                    <span class="submit-spinner hidden"><i class="fa-solid fa-circle-notch fa-spin text-sm"></i></span>
                </button>
                <p class="text-warm-gray/50 text-[10px] font-jost text-center mt-5">We reply within 24 hours. Always personally.</p>
            </div>

            <!-- Success -->
            <div class="concierge-success modal-success p-10 md:p-12 flex-col items-center justify-center text-center" style="min-height:400px">
                <div class="w-14 h-14 border border-soft-gold/40 flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-envelope-open text-soft-gold text-lg"></i>
                </div>
                <p class="text-soft-gold text-[10px] tracking-[0.35em] font-jost font-light mb-4">MESSAGE RECEIVED</p>
                <h3 class="font-playfair text-2xl font-light text-charcoal mb-1">Thank you,</h3>
                <p class="concierge-success-name font-cormorant italic text-charcoal text-xl font-light mb-1" style="font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:300"></p>
                <div class="w-8 h-px bg-soft-gold mx-auto my-6"></div>
                <p class="text-warm-gray font-jost font-light text-xs leading-relaxed max-w-xs mx-auto mb-8">Your message is with our team. We'll reply personally within 24 hours — keep an eye on your inbox.</p>
                <button class="modal-close-btn btn-outline-dark inline-block px-8 py-3 text-[10px] tracking-[0.22em] font-jost" data-modal="concierge-modal"><span>CLOSE</span></button>
            </div>
        </div>
    </div>


    <script>
        // Nav scroll
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 60));

        // Mobile menu
        const openBtn = document.getElementById('menu-open'), closeBtn = document.getElementById('menu-close');
        const mobileMenu = document.getElementById('mobile-menu'), menuOverlay = document.getElementById('menu-overlay');
        const openMenu = () => { mobileMenu.classList.add('open'); menuOverlay.classList.remove('hidden'); document.body.style.overflow = 'hidden'; };
        const closeMenu = () => { mobileMenu.classList.remove('open'); menuOverlay.classList.add('hidden'); document.body.style.overflow = ''; };
        openBtn.addEventListener('click', openMenu); closeBtn.addEventListener('click', closeMenu); menuOverlay.addEventListener('click', closeMenu);

        // Tab switching
        function openTab(evt, tabName) {
            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById(tabName).classList.add('active');
            evt.currentTarget.classList.add('active');
        }

        // Scroll reveal
        const reveals = document.querySelectorAll('.reveal');
        const obs = new IntersectionObserver(entries => { entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); }); }, { threshold: 0.1 });
        reveals.forEach(el => obs.observe(el));

        // ── Modal helpers ──
        function openModal(id) {
            document.getElementById(id).classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
            document.body.style.overflow = '';
        }

        // Close buttons (shared class)
        document.querySelectorAll('.modal-close-btn').forEach(btn => {
            btn.addEventListener('click', () => closeModal(btn.dataset.modal));
        });

        // Backdrop clicks
        document.getElementById('fitting-backdrop').addEventListener('click', () => closeModal('fitting-modal'));
        document.getElementById('concierge-backdrop').addEventListener('click', () => closeModal('concierge-modal'));

        // Escape key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeModal('fitting-modal');
                closeModal('concierge-modal');
            }
        });

        // ── Open triggers ──
        // Fitting modal triggers
        ['open-fitting'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('click', () => {
                // Reset
                document.querySelector('.fitting-form-wrap').style.display = 'block';
                document.querySelector('.fitting-success').classList.remove('show');
                document.querySelector('.fitting-error').classList.add('hidden');
                openModal('fitting-modal');
            });
        });

        // Concierge modal triggers — all buttons that open concierge
        ['open-concierge-main','open-concierge-rings','open-concierge-necklaces','open-concierge-bracelets'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('click', () => {
                // Reset
                document.querySelector('.concierge-form-wrap').style.display = 'block';
                document.querySelector('.concierge-success').classList.remove('show');
                document.querySelector('.concierge-error').classList.add('hidden');
                openModal('concierge-modal');
            });
        });

        // ── Select label float fix ──
        ['fit-category','con-subject'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('change', () => el.classList.add('has-value'));
        });

        // ── Generic submit handler ──
        function handleSubmit(formWrapSel, successSel, successNameSel, errorSel, submitBtnSel, nameId, emailId, requiredIds) {
            const submitBtn = document.querySelector(submitBtnSel);
            submitBtn.addEventListener('click', () => {
                const name    = document.getElementById(nameId).value.trim();
                const email   = document.getElementById(emailId).value.trim();
                const errorEl = document.querySelector(errorSel);

                // Validate
                if (!name) { errorEl.textContent = 'Please enter your name.'; errorEl.classList.remove('hidden'); document.getElementById(nameId).focus(); return; }
                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { errorEl.textContent = 'Please enter a valid email address.'; errorEl.classList.remove('hidden'); document.getElementById(emailId).focus(); return; }
                errorEl.classList.add('hidden');

                // Loading
                const label   = submitBtn.querySelector('.submit-label');
                const spinner = submitBtn.querySelector('.submit-spinner');
                label.textContent = 'SENDING…';
                spinner.classList.remove('hidden');
                submitBtn.disabled = true;

                // Mock — replace with fetch('/route', {...}) in Laravel
                const isFittingRequest = submitBtnSel.includes('fitting');
                const payload = isFittingRequest
                    ? {
                        name,
                        email,
                        subject: 'Fitting consultation',
                        piece_category: document.getElementById('fit-category').value,
                        measurement: document.getElementById('fit-measurement').value.trim(),
                        piece: document.getElementById('fit-notes').value.trim(),
                        message: document.getElementById('fit-notes').value.trim() || 'Fitting consultation requested from the size guide.',
                        source: 'size_guide_fitting',
                    }
                    : {
                        name,
                        email,
                        subject: document.getElementById('con-subject').value || 'Concierge request',
                        message: document.getElementById('con-message').value.trim(),
                        source: 'contact_page',
                    };

                if (isFittingRequest && !payload.piece_category) {
                    label.textContent = 'SEND REQUEST';
                    spinner.classList.add('hidden');
                    submitBtn.disabled = false;
                    errorEl.textContent = 'Please select a piece category.';
                    errorEl.classList.remove('hidden');
                    document.getElementById('fit-category').focus();
                    return;
                }

                fetch('{{ route('concierge-requests.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(payload),
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Unable to send request.');
                    }

                    label.textContent = submitBtnSel.includes('fitting') ? 'SEND REQUEST' : 'SEND MESSAGE';
                    spinner.classList.add('hidden');
                    submitBtn.disabled = false;
                    document.querySelector(formWrapSel).style.display = 'none';
                    document.querySelector(successNameSel).textContent = name + '.';
                    document.querySelector(successSel).classList.add('show');
                }).catch(() => {
                    label.textContent = submitBtnSel.includes('fitting') ? 'SEND REQUEST' : 'SEND MESSAGE';
                    spinner.classList.add('hidden');
                    submitBtn.disabled = false;
                    errorEl.textContent = 'We could not send this just now. Please try again.';
                    errorEl.classList.remove('hidden');
                });
            });
        }

        handleSubmit('.fitting-form-wrap', '.fitting-success', '.fitting-success-name', '.fitting-error', '.fitting-submit', 'fit-name', 'fit-email');
        handleSubmit('.concierge-form-wrap', '.concierge-success', '.concierge-success-name', '.concierge-error', '.concierge-submit', 'con-name', 'con-email');
    </script>
</body>
</html>
