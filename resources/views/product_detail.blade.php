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
                        fadeUp: { '0%': { opacity:'0', transform:'translateY(18px)' }, '100%': { opacity:'1', transform:'translateY(0)' } },
                        shimmer: { '0%': { backgroundPosition:'-200% center' }, '100%': { backgroundPosition:'200% center' } },
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.7s ease both',
                        'fade-up-2': 'fadeUp 0.7s ease 0.1s both',
                        'fade-up-3': 'fadeUp 0.7s ease 0.2s both',
                        'shimmer': 'shimmer 4s linear infinite',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300&family=Jost:wght@200;300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --gold:#C9A84C; --gold-light:#E8C97A; --cream:#F9F6F0; --charcoal:#1C1C1C; }
        ::-webkit-scrollbar{width:4px} ::-webkit-scrollbar-track{background:var(--cream)} ::-webkit-scrollbar-thumb{background:var(--gold);border-radius:4px}
        ::selection{background:var(--gold);color:#fff}

        #main-nav{transition:padding .4s ease,background .4s ease,box-shadow .4s ease}
        #main-nav.scrolled{padding-top:.75rem;padding-bottom:.75rem;background:rgba(249,246,240,.96);box-shadow:0 1px 20px rgba(0,0,0,.04)}
        .nav-link{position:relative}
        .nav-link::after{content:'';position:absolute;bottom:-3px;left:0;width:0;height:1px;background:var(--gold);transition:width .3s ease}
        .nav-link:hover::after,.nav-link.active::after{width:100%}

        .thumb{cursor:pointer;transition:opacity .2s,border-color .2s}
        .thumb:hover{opacity:.85}
        .thumb.active{border-color:var(--gold) !important}

        .size-btn{border:1px solid rgba(28,28,28,.12);font-size:.7rem;letter-spacing:.1em;padding:.5rem .85rem;cursor:pointer;transition:all .2s ease}
        .size-btn:hover,.size-btn.active{border-color:var(--gold);color:var(--gold);background:rgba(201,168,76,.04)}
        .size-btn.unavailable{opacity:.3;cursor:not-allowed;text-decoration:line-through}

        .qty-btn{width:36px;height:36px;border:1px solid rgba(28,28,28,.1);display:flex;align-items:center;justify-content:center;cursor:pointer}
        .qty-btn:hover{border-color:var(--gold);color:var(--gold)}
        .qty-input{width:44px;height:36px;border:none;border-top:1px solid rgba(28,28,28,.1);border-bottom:1px solid rgba(28,28,28,.1);text-align:center;font-size:.8rem;background:transparent;outline:none}

        .accord-body{max-height:0;overflow:hidden;transition:max-height .4s ease}
        .accord-body.open{max-height:300px;padding-top:.75rem}
        .accord-icon{transition:transform .3s ease}
        .accord-item.open .accord-icon{transform:rotate(45deg)}

        .btn-gold{position:relative;overflow:hidden;background:var(--gold);color:#fff;transition:color .3s}
        .btn-gold::before{content:'';position:absolute;inset:0;background:#A8862E;transform:translateY(100%);transition:transform .32s cubic-bezier(.4,0,.2,1)}
        .btn-gold:hover::before{transform:translateY(0)}
        .btn-gold span{position:relative;z-index:1}
        .btn-outline-dark{position:relative;overflow:hidden;border:1px solid var(--charcoal);color:var(--charcoal);transition:color .3s}
        .btn-outline-dark::before{content:'';position:absolute;inset:0;background:var(--charcoal);transform:translateY(100%);transition:transform .32s cubic-bezier(.4,0,.2,1)}
        .btn-outline-dark:hover::before{transform:translateY(0)}
        .btn-outline-dark:hover{color:#fff}
        .btn-outline-dark span{position:relative;z-index:1}

        .reveal{opacity:0;transform:translateY(20px);transition:opacity .7s ease,transform .7s ease}
        .reveal.visible{opacity:1;transform:translateY(0)}

        #mobile-menu{transform:translateX(100%);transition:transform .4s cubic-bezier(.4,0,.2,1)}
        #mobile-menu.open{transform:translateX(0)}

        #zoom-overlay{opacity:0;pointer-events:none;transition:opacity .25s}
        #zoom-overlay.open{opacity:1;pointer-events:all}

        /* Sticky bar — mobile only */
        #sticky-bar{transform:translateY(100%);transition:transform .4s ease;display:none}
        @media (max-width: 768px) { #sticky-bar { display:flex; } #sticky-bar.visible { transform:translateY(0); } }

        /* Gold Circle signal */
        .gold-circle-badge{background:rgba(201,168,76,.08);border-left:2px solid var(--gold);padding:.6rem 1rem}
    </style>
</head>
<body class="bg-cream font-jost text-charcoal overflow-x-hidden">

    <!-- NAV -->
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">
            <a href="index.html" class="font-playfair text-2xl tracking-widest text-charcoal hover:text-soft-gold transition-colors">LUMIÈRE</a>
            <div class="hidden md:flex items-center gap-10">
                <a href="collections.html" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal font-jost">COLLECTIONS</a>
                <a href="shop.html" class="nav-link active text-xs tracking-[0.18em] text-charcoal font-jost">SHOP</a>
                <a href="atelier.html" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal font-jost">ABOUT</a>
                <a href="journal.html" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal font-jost">JOURNAL</a>
            </div>
            <div class="flex items-center gap-5">
                <button class="text-charcoal/50 hover:text-soft-gold"><i class="fa-regular fa-heart text-base"></i></button>
                <button class="text-charcoal/50 hover:text-soft-gold"><i class="fa-regular fa-user text-base"></i></button>
                <button class="text-charcoal/50 hover:text-soft-gold relative"><i class="fa-regular fa-bag-shopping text-base"></i><span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center">2</span></button>
                <button id="menu-open" class="md:hidden text-charcoal/70 ml-1"><i class="fa-solid fa-bars text-lg"></i></button>
            </div>
        </div>
    </nav>
    <div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-cream z-[60] shadow-2xl flex flex-col px-10 py-12">
        <button id="menu-close" class="self-end text-charcoal/50 hover:text-charcoal mb-10"><i class="fa-solid fa-xmark text-xl"></i></button>
        <a href="index.html" class="font-playfair text-2xl tracking-widest text-charcoal mb-10 block">LUMIÈRE</a>
        <div class="flex flex-col gap-7">
            <a href="collections.html" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold">COLLECTIONS</a>
            <a href="shop.html" class="text-xs tracking-[0.18em] text-soft-gold">SHOP</a>
            <a href="atelier.html" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold">ABOUT</a>
            <a href="journal.html" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold">JOURNAL</a>
        </div>
        <div class="mt-auto flex gap-5 text-charcoal/40"><a href="#"><i class="fa-brands fa-instagram text-lg hover:text-soft-gold"></i></a><a href="#"><i class="fa-brands fa-pinterest text-lg hover:text-soft-gold"></i></a></div>
    </div>
    <div id="menu-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden"></div>

    <!-- BREADCRUMB -->
    <div class="pt-28 pb-6 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto flex items-center gap-2 text-[10px] tracking-[0.2em] font-jost">
            <a href="index.html" class="text-warm-gray hover:text-soft-gold">HOME</a><span class="text-soft-gold/40">✦</span>
            <a href="shop.html" class="text-warm-gray hover:text-soft-gold">SHOP</a><span class="text-soft-gold/40">✦</span>
            <span class="text-charcoal">CELESTIAL RING</span>
        </div>
    </div>

    <!-- PRODUCT DETAIL -->
    <section class="pb-16 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 xl:gap-20">
                <!-- LEFT: Gallery -->
                <div class="animate-fade-up">
                    <div class="relative overflow-hidden rounded-sm bg-deep-ivory mb-4 group" style="aspect-ratio:4/5">
                        <img id="main-img" src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=2188&auto=format&fit=crop" alt="Celestial Ring" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-102 cursor-zoom-in" id="zoom-trigger">
                        <span class="absolute top-4 left-4 bg-charcoal text-white text-[9px] tracking-[0.15em] px-3 py-1.5">LAST FEW</span>
                        <div class="absolute bottom-4 right-4 bg-white/80 backdrop-blur-sm text-[9px] tracking-[0.15em] text-charcoal/60 px-3 py-1.5 opacity-0 group-hover:opacity-100 transition-opacity"><i class="fa-regular fa-magnifying-glass mr-1"></i>ZOOM</div>
                    </div>
                    <div class="grid grid-cols-4 gap-3">
                        <div class="thumb active border-2 rounded-sm overflow-hidden aspect-square bg-deep-ivory" onclick="switchImg(this, 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=2188&auto=format&fit=crop')"><img src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover"></div>
                        <div class="thumb border-2 border-transparent rounded-sm overflow-hidden aspect-square bg-deep-ivory" onclick="switchImg(this, 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=2070&auto=format&fit=crop')"><img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover"></div>
                        <div class="thumb border-2 border-transparent rounded-sm overflow-hidden aspect-square bg-deep-ivory" onclick="switchImg(this, 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=2187&auto=format&fit=crop')"><img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover"></div>
                        <div class="thumb border-2 border-transparent rounded-sm overflow-hidden aspect-square bg-deep-ivory" onclick="switchImg(this, 'https://images.unsplash.com/photo-1602751584552-8ba73aad9250?q=80&w=2187&auto=format&fit=crop')"><img src="https://images.unsplash.com/photo-1602751584552-8ba73aad9250?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover"></div>
                    </div>
                </div>

                <!-- RIGHT: Product info — sticky -->
                <div class="lg:sticky lg:top-28">
                    <a href="collections.html" class="inline-flex items-center gap-2 text-[10px] tracking-[0.3em] text-soft-gold hover:text-gold-light mb-5 animate-fade-up">L'ÉCLAT COLLECTION <i class="fa-regular fa-arrow-right text-[9px]"></i></a>
                    <h1 class="font-playfair text-4xl md:text-5xl font-light text-charcoal leading-tight mb-2 animate-fade-up-2">Celestial Ring</h1>
                    <p class="text-warm-gray text-sm font-jost font-light mb-5 animate-fade-up-2">Sapphire & Diamond · 18k White Gold</p>
                    <div class="flex items-baseline gap-4 mb-6 animate-fade-up-2"><span class="font-playfair text-3xl text-charcoal font-light">$3,450</span><span class="text-xs text-soft-gold bg-soft-gold/10 px-2 py-1">LAST FEW</span></div>

                    <!-- Gold Circle Signal — added as promised -->
                    <div class="gold-circle-badge mb-6 animate-fade-up-2 text-[11px] font-jost text-charcoal/70 flex items-center gap-2">
                        <i class="fa-regular fa-crown text-soft-gold text-xs"></i> <span>Gold Circle members receive complimentary priority sizing & atelier consultation. <a href="#" class="text-soft-gold hover:underline">Learn more</a></span>
                    </div>

                    <span class="block w-8 h-px bg-soft-gold mb-6 animate-fade-up-2"></span>
                    <p class="text-warm-gray font-jost font-light text-sm leading-relaxed mb-8 animate-fade-up-3">1.2-carat Sri Lankan cornflower sapphire, encircled by pavé-set diamonds (0.45 ct). Hand-finished 18k gold. 38 hours to complete.</p>

                    <!-- Metal selector -->
                    <div class="mb-6 animate-fade-up-3">
                        <p class="text-[10px] tracking-[0.2em] mb-3 text-charcoal/60">METAL — <span class="text-charcoal" id="metal-label">White Gold</span></p>
                        <div class="flex gap-2"><button class="size-btn active" onclick="selectOption(this,'metal','White Gold','metal-label')">White Gold</button><button class="size-btn" onclick="selectOption(this,'metal','Yellow Gold','metal-label')">Yellow Gold</button><button class="size-btn" onclick="selectOption(this,'metal','Rose Gold','metal-label')">Rose Gold</button></div>
                    </div>

                    <!-- Size selector -->
                    <div class="mb-8 animate-fade-up-3">
                        <div class="flex justify-between mb-3"><p class="text-[10px] tracking-[0.2em] text-charcoal/60">RING SIZE — <span class="text-charcoal" id="size-label">Select a size</span></p><button class="text-[10px] tracking-[0.1em] text-soft-gold hover:underline">SIZE GUIDE</button></div>
                        <div class="flex flex-wrap gap-2">
                            <button class="size-btn" onclick="selectOption(this,'size','46','size-label')">46</button><button class="size-btn" onclick="selectOption(this,'size','48','size-label')">48</button>
                            <button class="size-btn" onclick="selectOption(this,'size','50','size-label')">50</button><button class="size-btn" onclick="selectOption(this,'size','52','size-label')">52</button>
                            <button class="size-btn unavailable">54</button><button class="size-btn" onclick="selectOption(this,'size','56','size-label')">56</button><button class="size-btn" onclick="selectOption(this,'size','58','size-label')">58</button>
                        </div>
                        <p class="text-[10px] font-jost text-warm-gray mt-2">Size 54 temporarily unavailable. <a href="#" class="text-soft-gold hover:underline">Notify me for waitlist</a></p>
                    </div>

                    <!-- Qty + Add -->
                    <div class="flex gap-3 mb-4 animate-fade-up-3">
                        <div class="flex items-center"><button class="qty-btn" onclick="changeQty(-1)"><i class="fa-solid fa-minus text-[9px]"></i></button><input type="text" class="qty-input" value="1" id="qty" readonly><button class="qty-btn" onclick="changeQty(1)"><i class="fa-solid fa-plus text-[9px]"></i></button></div>
                        <button class="btn-gold flex-1 py-3.5 text-[11px] tracking-[0.22em]"><span>ADD TO CART</span></button>
                        <button id="wish-btn" class="w-12 h-12 border border-charcoal/15 flex items-center justify-center text-charcoal/40 hover:text-soft-gold hover:border-soft-gold/40"><i class="fa-regular fa-heart text-sm"></i></button>
                    </div>

                    <!-- Engraving -->
                    <div class="mb-6 animate-fade-up-3"><label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" id="engrave-check" class="w-4 h-4 accent-yellow-600"><span class="text-xs font-jost text-charcoal/60">Included: personal engraving (up to 20 characters)</span></label><div id="engrave-input" class="hidden mt-3"><input type="text" maxlength="20" placeholder="Your message…" class="w-full border-b border-charcoal/15 py-2 text-sm bg-transparent outline-none focus:border-soft-gold"></div></div>

                    <!-- Trust badges -->
                    <div class="grid grid-cols-3 gap-4 py-6 border-t border-b border-charcoal/7 mb-6 animate-fade-up-3">
                        <div class="text-center"><i class="fa-regular fa-shield-check text-soft-gold text-lg mb-2"></i><p class="text-[9px] tracking-[0.12em] text-charcoal/50">CERTIFIED AUTHENTIC</p></div>
                        <div class="text-center"><i class="fa-regular fa-truck text-soft-gold text-lg mb-2"></i><p class="text-[9px] tracking-[0.12em] text-charcoal/50">FREE WORLDWIDE</p></div>
                        <div class="text-center"><i class="fa-regular fa-rotate-left text-soft-gold text-lg mb-2"></i><p class="text-[9px] tracking-[0.12em] text-charcoal/50">30-DAY RETURNS</p></div>
                    </div>

                    <!-- Accordion specs -->
                    <div class="space-y-0 animate-fade-up-3">
                        <div class="accord-item border-b border-charcoal/7"><button class="accord-toggle w-full flex justify-between py-4 text-left"><span class="text-[10px] tracking-[0.2em]">SPECIFICATIONS</span><i class="fa-solid fa-plus accord-icon text-soft-gold text-[10px]"></i></button><div class="accord-body"><div class="grid grid-cols-2 gap-3 pb-4 text-xs"><div><p class="text-warm-gray">Stone</p><p>Sri Lankan Sapphire 1.2ct</p></div><div><p class="text-warm-gray">Diamonds</p><p>Pavé 0.45ct</p></div><div><p class="text-warm-gray">Metal</p><p>18k White Gold</p></div><div><p class="text-warm-gray">Craft time</p><p>38 hours</p></div></div></div></div>
                        <div class="accord-item border-b border-charcoal/7"><button class="accord-toggle w-full flex justify-between py-4 text-left"><span class="text-[10px] tracking-[0.2em]">SHIPPING & DELIVERY</span><i class="fa-solid fa-plus accord-icon text-soft-gold text-[10px]"></i></button><div class="accord-body"><div class="pb-4 text-xs text-warm-gray"><p>Complimentary worldwide insured shipping. Standard 5–8 days. Express 2–3 days.</p></div></div></div>
                        <div class="accord-item"><button class="accord-toggle w-full flex justify-between py-4 text-left"><span class="text-[10px] tracking-[0.2em]">RETURNS & GUARANTEE</span><i class="fa-solid fa-plus accord-icon text-soft-gold text-[10px]"></i></button><div class="accord-body"><div class="pb-4 text-xs text-warm-gray"><p>30-day returns unworn. Lifetime guarantee against defects. Free resizing once within first year.</p></div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- REVIEWS — stripped down. No progress bars. Just named collectors. -->
    <section class="py-20 px-6 md:px-12 bg-deep-ivory">
        <div class="max-w-screen-xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-3 font-jost">COLLECTOR TESTIMONIALS</p>
                <h2 class="font-playfair text-3xl font-light text-charcoal">What they're saying</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-cream p-8 reveal"><p class="font-cormorant italic text-lg text-charcoal mb-4">"The stone glows differently in every light. I returned a ring from another house to buy this one. No comparison."</p><div><p class="text-xs font-jost text-charcoal font-medium mt-4">— Marguerite D., Geneva</p><p class="text-[9px] font-jost text-warm-gray">Collector since 2024</p></div></div>
                <div class="bg-cream p-8 reveal" style="transition-delay:.1s"><p class="font-cormorant italic text-lg text-charcoal mb-4">"The craftsmanship is evident the moment you open the box. My personal consultant followed up within 48 hours. Extraordinary service."</p><div><p class="text-xs font-jost text-charcoal font-medium mt-4">— Alexander V., London</p><p class="text-[9px] font-jost text-warm-gray">Gold Circle Member</p></div></div>
                <div class="bg-cream p-8 reveal" style="transition-delay:.2s"><p class="font-cormorant italic text-lg text-charcoal mb-4">"I ordered the engraving as a surprise. They called to confirm the spelling before proceeding. That level of care is rare."</p><div><p class="text-xs font-jost text-charcoal font-medium mt-4">— Céline B., Paris</p><p class="text-[9px] font-jost text-warm-gray">Bespoke client</p></div></div>
            </div>
        </div>
    </section>

    <!-- RELATED PRODUCTS -->
    <section class="py-20 px-6 md:px-12 bg-cream">
        <div class="max-w-screen-xl mx-auto text-center mb-12"><p class="text-soft-gold text-[10px] tracking-[0.35em] mb-2">COMPLETE THE LOOK</p><h2 class="font-playfair text-3xl font-light">You may also like</h2></div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-screen-xl mx-auto">
            <div class="group cursor-pointer"><div class="bg-deep-ivory aspect-[3/4] overflow-hidden mb-3"><img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"></div><h3 class="font-playfair text-base">Solitaire Pendant</h3><p class="text-soft-gold text-sm">$1,250</p></div>
            <div class="group cursor-pointer"><div class="bg-deep-ivory aspect-[3/4] overflow-hidden mb-3"><img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"></div><h3 class="font-playfair text-base">Lumière Signature Ring</h3><p class="text-soft-gold text-sm">$4,500</p></div>
            <div class="group cursor-pointer"><div class="bg-deep-ivory aspect-[3/4] overflow-hidden mb-3"><img src="https://images.unsplash.com/photo-1602173574767-37ac01994b2a?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"></div><h3 class="font-playfair text-base">Diamond Halo Studs</h3><p class="text-soft-gold text-sm">$1,680</p></div>
            <div class="group cursor-pointer"><div class="bg-deep-ivory aspect-[3/4] overflow-hidden mb-3"><img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"></div><h3 class="font-playfair text-base">Knot Signet Ring</h3><p class="text-soft-gold text-sm">$1,850</p></div>
        </div>
    </section>

    <!-- STICKY BAR (mobile only) -->
    <div id="sticky-bar" class="fixed bottom-0 left-0 right-0 bg-cream/97 backdrop-blur-sm border-t border-charcoal/8 z-40 px-6 py-3 flex items-center gap-4">
        <div class="flex-1"><p class="font-playfair text-base font-light">Celestial Ring</p><p class="text-soft-gold text-sm">$3,450</p></div>
        <button class="btn-gold px-6 py-2.5 text-[10px] tracking-[0.22em]"><span>ADD TO CART</span></button>
    </div>

    <!-- ZOOM OVERLAY -->
    <div id="zoom-overlay" class="fixed inset-0 z-[80] bg-black/90 flex items-center justify-center p-6" onclick="closeZoom()"><button class="absolute top-5 right-5 text-white/60 text-2xl"><i class="fa-solid fa-xmark"></i></button><img id="zoom-img" src="" class="max-w-full max-h-full object-contain"></div>

    <!-- FOOTER -->
    <footer class="bg-[#161616] pt-16 pb-8 px-6 md:px-12"><div class="max-w-screen-xl mx-auto text-center text-white/20 text-[9px] tracking-[0.2em]">© 2026 LUMIÈRE JEWELRY · PARIS</div></footer>

    <script>
        function switchImg(el, src) { document.getElementById('main-img').src = src; document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active')); el.classList.add('active'); }
        function selectOption(el, group, label, labelId) { document.querySelectorAll(`[onclick*="'${group}'"]`).forEach(b => b.classList.remove('active')); el.classList.add('active'); document.getElementById(labelId).textContent = label; }
        function changeQty(delta) { const input = document.getElementById('qty'); input.value = Math.max(1, parseInt(input.value) + delta); }
        document.getElementById('engrave-check')?.addEventListener('change', function(e) { document.getElementById('engrave-input').classList.toggle('hidden', !e.target.checked); });
        document.getElementById('wish-btn')?.addEventListener('click', function() { const i = this.querySelector('i'); i.classList.toggle('fa-regular'); i.classList.toggle('fa-solid'); this.classList.toggle('text-soft-gold'); });
        document.querySelectorAll('.accord-toggle').forEach(btn => { btn.addEventListener('click', () => { const item = btn.closest('.accord-item'); const body = item.querySelector('.accord-body'); const isOpen = item.classList.contains('open'); item.classList.toggle('open', !isOpen); body.classList.toggle('open', !isOpen); }); });
        document.getElementById('zoom-trigger')?.addEventListener('click', () => { document.getElementById('zoom-img').src = document.getElementById('main-img').src; document.getElementById('zoom-overlay').classList.add('open'); document.body.style.overflow = 'hidden'; });
        function closeZoom() { document.getElementById('zoom-overlay').classList.remove('open'); document.body.style.overflow = ''; }
        document.addEventListener('keydown', e => { if(e.key==='Escape') closeZoom(); });
        const nav = document.getElementById('main-nav'); window.addEventListener('scroll', () => { nav.classList.toggle('scrolled', window.scrollY > 60); const sticky = document.getElementById('sticky-bar'); if(sticky) sticky.classList.toggle('visible', window.scrollY > 400); });
        const openBtn = document.getElementById('menu-open'), closeBtn = document.getElementById('menu-close'), mobileMenu = document.getElementById('mobile-menu'), overlay = document.getElementById('menu-overlay');
        if(openBtn) openBtn.onclick = () => { mobileMenu.classList.add('open'); overlay.classList.remove('hidden'); document.body.style.overflow='hidden'; };
        if(closeBtn) closeBtn.onclick = () => { mobileMenu.classList.remove('open'); overlay.classList.add('hidden'); document.body.style.overflow=''; };
        if(overlay) overlay.onclick = () => { mobileMenu.classList.remove('open'); overlay.classList.add('hidden'); document.body.style.overflow=''; };
        const reveals = document.querySelectorAll('.reveal'); const obs = new IntersectionObserver(e => { e.forEach(entry => { if(entry.isIntersecting) { entry.target.classList.add('visible'); obs.unobserve(entry.target); } }); }, { threshold: 0.1 }); reveals.forEach(el => obs.observe(el));
    </script>
</body>
</html>