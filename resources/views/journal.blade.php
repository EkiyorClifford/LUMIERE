<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal | LUMIÈRE Fine Jewelry</title>
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
                    },
                    animation: { 'fade-up': 'fadeUp 0.8s ease both' }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300&family=Jost:wght@200;300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #C9A84C; border-radius: 4px; }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -3px; left: 0; width: 0; height: 1px; background: #C9A84C; transition: width 0.3s ease; }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        #main-nav.scrolled { padding-top: 0.75rem; padding-bottom: 0.75rem; background: rgba(249,246,240,0.97); box-shadow: 0 1px 24px rgba(0,0,0,0.06); }
        .article-card:hover .article-img { transform: scale(1.05); }
        .article-img { transition: transform 0.7s cubic-bezier(0.25,0.46,0.45,0.94); }
        .category-btn.active { color: #C9A84C; border-bottom-color: #C9A84C; }
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        #mobile-menu { transform: translateX(100%); transition: transform 0.4s cubic-bezier(0.4,0,0.2,1); }
        #mobile-menu.open { transform: translateX(0); }
    </style>
</head>
<body class="bg-cream font-jost text-charcoal overflow-x-hidden">

    <!-- NAV -->
    <nav id="main-nav" class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12 transition-all duration-300">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">
            <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal hover:text-soft-gold transition-colors">LUMIÈRE</a>
            <div class="hidden md:flex items-center gap-10">
                <a href="{{ route('collections') }}" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal">COLLECTIONS</a>
                <a href="{{ route('shop') }}" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal">SHOP</a>
                <a href="{{ route('atelier') }}" class="nav-link text-xs tracking-[0.18em] text-charcoal/70 hover:text-charcoal">ATELIER</a>
                <a href="{{ route('journal') }}" class="nav-link active text-xs tracking-[0.18em] text-charcoal">JOURNAL</a>
            </div>
            <div class="flex items-center gap-5">
                <a href="{{ route('wishlist.index') }}" class="text-charcoal/60 hover:text-soft-gold relative">
                    <i class="fa-regular fa-heart"></i>
                    <span id="wishlist-count" class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center">{{ $wishlistCount ?? 0 }}</span>
                </a>
                @auth('web')
                    <div class="relative group">
                        <button class="text-charcoal/60 hover:text-soft-gold flex items-center gap-2">
                            <i class="fa-solid fa-user"></i>
                            <span class="text-xs font-jost hidden md:block">{{ auth('web')->user()?->name }}</span>
                        </button>
                        @if(auth('web')->user()?->is_gold_circle)
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
                    <a href="{{ route('login') }}" class="text-charcoal/60 hover:text-soft-gold">
                        <i class="fa-regular fa-user"></i>
                    </a>
                @endif
                <button onclick="toggleCart()" class="text-charcoal/60 hover:text-soft-gold relative"><i class="fa-solid fa-cart-shopping"></i><span id="cart-count" class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center">{{ $cartCount ?? 0 }}</span></button>
                <button id="menu-open" class="md:hidden text-charcoal/70"><i class="fa-solid fa-bars text-lg"></i></button>
            </div>
        </div>
    </nav>
    <div id="mobile-menu" class="fixed inset-y-0 right-0 w-72 bg-cream z-[60] shadow-2xl flex flex-col px-10 py-12">
        <button id="menu-close" class="self-end text-charcoal/50 hover:text-charcoal mb-10"><i class="fa-solid fa-xmark text-xl"></i></button>
        <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal mb-10 block">LUMIÈRE</a>
        <div class="flex flex-col gap-7">
            <a href="{{ route('collections') }}" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold">COLLECTIONS</a>
            <a href="{{ route('shop') }}" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold">SHOP</a>
            <a href="{{ route('atelier') }}" class="text-xs tracking-[0.18em] text-charcoal/70 hover:text-soft-gold">ATELIER</a>
            <a href="{{ route('journal') }}" class="text-xs tracking-[0.18em] text-soft-gold">JOURNAL</a>
        </div>
        <div class="mt-auto flex gap-5 text-charcoal/40"><a href="#"><i class="fa-brands fa-instagram text-lg hover:text-soft-gold"></i></a><a href="#"><i class="fa-brands fa-pinterest text-lg hover:text-soft-gold"></i></a></div>
    </div>
    <div id="menu-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden"></div>

    <!-- JOURNAL HEADER -->
    <header class="pt-40 pb-16 px-6 text-center">
        <div class="max-w-3xl mx-auto">
            <p class="text-soft-gold text-[10px] tracking-[0.4em] mb-4 animate-fade-up">THE LUMIÈRE JOURNAL</p>
            <h1 class="font-playfair text-5xl md:text-7xl font-light tracking-tighter mb-6 animate-fade-up" style="animation-delay: 0.1s;">Stories & <span class="font-cormorant italic">Visions</span></h1>
            <p class="text-warm-gray font-jost font-light text-sm leading-relaxed max-w-md mx-auto animate-fade-up" style="animation-delay: 0.2s;">Notes from the atelier, deep dives into craft, and the people who inspire us.</p>
            <span class="block w-10 h-px bg-soft-gold mx-auto mt-8 animate-fade-up" style="animation-delay: 0.3s;"></span>
        </div>
    </header>

    <!-- CATEGORY FILTERS -->
    <div class="sticky top-20 z-40 bg-cream/95 backdrop-blur-sm border-y border-charcoal/5 px-6 py-4">
        <div class="max-w-screen-xl mx-auto flex flex-wrap justify-center gap-6 md:gap-10">
            <a href="{{ route('journal') }}" class="category-btn {{ !request()->route('post.category') ? 'active' : '' }} text-[10px] tracking-[0.2em] font-jost text-charcoal/60 hover:text-charcoal transition-colors pb-2 border-b-2 border-transparent">ALL STORIES</a>
            <a href="{{ route('post.category', 'craftsmanship') }}" class="category-btn {{ request()->route('post.category')?->parameter('slug') == 'craftsmanship' ? 'active' : '' }} text-[10px] tracking-[0.2em] font-jost text-charcoal/60 hover:text-charcoal transition-colors pb-2 border-b-2 border-transparent" data-cat="craft">CRAFTSMANSHIP</a>
            <a href="{{ route('post.category', 'ethics-sourcing') }}" class="category-btn {{ request()->route('post.category')?->parameter('slug') == 'ethics-sourcing' ? 'active' : '' }} text-[10px] tracking-[0.2em] font-jost text-charcoal/60 hover:text-charcoal transition-colors pb-2 border-b-2 border-transparent" data-cat="ethics">ETHICS & SOURCING</a>
            <a href="{{ route('post.category', 'lifestyle') }}" class="category-btn {{ request()->route('post.category')?->parameter('slug') == 'lifestyle' ? 'active' : '' }} text-[10px] tracking-[0.2em] font-jost text-charcoal/60 hover:text-charcoal transition-colors pb-2 border-b-2 border-transparent" data-cat="lifestyle">LIFESTYLE</a>
            <a href="{{ route('post.category', 'people') }}" class="category-btn {{ request()->route('post.category')?->parameter('slug') == 'people' ? 'active' : '' }} text-[10px] tracking-[0.2em] font-jost text-charcoal/60 hover:text-charcoal transition-colors pb-2 border-b-2 border-transparent" data-cat="people">PEOPLE</a>
        </div>
    </div>

    <!-- FEATURED ARTICLE (always visible) -->
    <section class="px-6 md:px-12 max-w-screen-xl mx-auto mt-16 mb-20 reveal">
        <div class="group cursor-pointer relative overflow-hidden bg-white shadow-sm">
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-2/3 overflow-hidden aspect-[16/9]">
                    <img src="https://images.unsplash.com/photo-1530968033775-2c92736b131e?q=80&w=2071&auto=format&fit=crop" class="article-img w-full h-full object-cover">
                </div>
                <div class="w-full md:w-1/3 p-10 md:p-12 flex flex-col justify-center">
                    <p class="text-[9px] tracking-[0.3em] text-soft-gold mb-4 uppercase" data-cat-label>CRAFTSMANSHIP</p>
                    <h2 class="font-playfair text-2xl md:text-3xl mb-4 leading-tight">The Art of the Brilliant Cut: A Masterclass</h2>
                    <p class="text-warm-gray text-xs font-light leading-relaxed mb-4">Exploring the mathematical precision and human intuition required to release the fire within a raw diamond. A deep dive with our master gemologist.</p>
                    <div class="flex items-center gap-4 text-[9px] text-warm-gray font-jost mb-5">
                        <span><i class="fa-solid fa-calendar mr-1"></i> April 15, 2026</span>
                        <span><i class="fa-solid fa-clock mr-1"></i> 8 min read</span>
                        <span><i class="fa-solid fa-pen mr-1"></i> Michel Fontaine</span>
                    </div>
                    <a href="{{ route('journal') }}" class="text-[10px] tracking-[0.2em] border-b border-charcoal/20 pb-1 hover:border-soft-gold transition-colors inline-flex items-center gap-2">READ THE STORY <i class="fa-solid fa-arrow-right text-[9px]"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- ARTICLE GRID (filterable) -->
    <main class="px-6 md:px-12 max-w-screen-xl mx-auto pb-32">
        <div id="articles-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
            
            <!-- Article 1 -->
            <div class="article-card group cursor-pointer reveal" data-category="ethics">
                <div class="overflow-hidden aspect-[4/3] mb-5 bg-charcoal/5">
                    <img src="https://images.unsplash.com/photo-1582657050916-f91e9bd60ca1?q=80&w=1974&auto=format&fit=crop" class="article-img w-full h-full object-cover">
                </div>
                <p class="text-[9px] tracking-[0.3em] text-soft-gold mb-3 uppercase">ETHICS & SOURCING</p>
                <h3 class="font-playfair text-xl mb-2 leading-tight group-hover:text-soft-gold transition-colors">Tracing the Origin: Our Commitment to Ethical Sourcing</h3>
                <p class="text-warm-gray text-xs font-light leading-relaxed mb-3">How we ensure every stone in the Lumière collection supports the communities that mine them — and why we visit every supplier in person.</p>
                <div class="flex items-center gap-3 text-[9px] text-warm-gray font-jost mb-4">
                    <span><i class="fa-solid fa-calendar mr-1"></i> April 8, 2026</span>
                    <span><i class="fa-solid fa-clock mr-1"></i> 5 min read</span>
                </div>
                <a href="{{ route('journal') }}" class="text-[9px] tracking-[0.2em] text-charcoal/50 hover:text-soft-gold transition-colors">CONTINUE READING →</a>
            </div>

            <!-- Article 2 -->
            <div class="article-card group cursor-pointer reveal" data-category="lifestyle">
                <div class="overflow-hidden aspect-[4/3] mb-5 bg-charcoal/5">
                    <img src="https://images.unsplash.com/photo-1599643477877-530eb83abc8e?q=80&w=2070&auto=format&fit=crop" class="article-img w-full h-full object-cover">
                </div>
                <p class="text-[9px] tracking-[0.3em] text-soft-gold mb-3 uppercase">LIFESTYLE</p>
                <h3 class="font-playfair text-xl mb-2 leading-tight group-hover:text-soft-gold transition-colors">Morning in the 1er Arrondissement</h3>
                <p class="text-warm-gray text-xs font-light leading-relaxed mb-3">A visual diary of the light, architecture, and quiet rituals that inspired the L'Or Collection — photographed at dawn in Place Vendôme.</p>
                <div class="flex items-center gap-3 text-[9px] text-warm-gray font-jost mb-4">
                    <span><i class="fa-solid fa-calendar mr-1"></i> March 28, 2026</span>
                    <span><i class="fa-solid fa-clock mr-1"></i> 4 min read</span>
                </div>
                <a href="{{ route('journal') }}" class="text-[9px] tracking-[0.2em] text-charcoal/50 hover:text-soft-gold transition-colors">CONTINUE READING →</a>
            </div>

            <!-- Article 3 -->
            <div class="article-card group cursor-pointer reveal" data-category="craft">
                <div class="overflow-hidden aspect-[4/3] mb-5 bg-charcoal/5">
                    <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=2070&auto=format&fit=crop" class="article-img w-full h-full object-cover">
                </div>
                <p class="text-[9px] tracking-[0.3em] text-soft-gold mb-3 uppercase">CRAFTSMANSHIP</p>
                <h3 class="font-playfair text-xl mb-2 leading-tight group-hover:text-soft-gold transition-colors">The Lost Art of Wax Carving</h3>
                <p class="text-warm-gray text-xs font-light leading-relaxed mb-3">Why we still carve every initial model by hand — and how a single wax can take 20 hours to complete before a single gram of gold is melted.</p>
                <div class="flex items-center gap-3 text-[9px] text-warm-gray font-jost mb-4">
                    <span><i class="fa-solid fa-calendar mr-1"></i> March 15, 2026</span>
                    <span><i class="fa-solid fa-clock mr-1"></i> 7 min read</span>
                </div>
                <a href="{{ route('journal') }}" class="text-[9px] tracking-[0.2em] text-charcoal/50 hover:text-soft-gold transition-colors">CONTINUE READING →</a>
            </div>

            <!-- Article 4 -->
            <div class="article-card group cursor-pointer reveal" data-category="people">
                <div class="overflow-hidden aspect-[4/3] mb-5 bg-charcoal/5">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=600&auto=format&fit=crop" class="article-img w-full h-full object-cover">
                </div>
                <p class="text-[9px] tracking-[0.3em] text-soft-gold mb-3 uppercase">PEOPLE</p>
                <h3 class="font-playfair text-xl mb-2 leading-tight group-hover:text-soft-gold transition-colors">Meet Michel Fontaine: 34 Years at the Bench</h3>
                <p class="text-warm-gray text-xs font-light leading-relaxed mb-3">A conversation with our master goldsmith on how the craft has changed — and what has remained sacred — since he began his apprenticeship in 1992.</p>
                <div class="flex items-center gap-3 text-[9px] text-warm-gray font-jost mb-4">
                    <span><i class="fa-solid fa-calendar mr-1"></i> March 5, 2026</span>
                    <span><i class="fa-solid fa-clock mr-1"></i> 6 min read</span>
                </div>
                <a href="{{ route('journal') }}" class="text-[9px] tracking-[0.2em] text-charcoal/50 hover:text-soft-gold transition-colors">CONTINUE READING →</a>
            </div>

            <!-- Article 5 -->
            <div class="article-card group cursor-pointer reveal" data-category="ethics">
                <div class="overflow-hidden aspect-[4/3] mb-5 bg-charcoal/5">
                    <img src="https://images.unsplash.com/photo-1619856699906-09e1f58c98a1?q=80&w=2070&auto=format&fit=crop" class="article-img w-full h-full object-cover">
                </div>
                <p class="text-[9px] tracking-[0.3em] text-soft-gold mb-3 uppercase">ETHICS & SOURCING</p>
                <h3 class="font-playfair text-xl mb-2 leading-tight group-hover:text-soft-gold transition-colors">Pearls of Conscience: Our Journey to Japan</h3>
                <p class="text-warm-gray text-xs font-light leading-relaxed mb-3">Visiting the Akoya pearl farms that supply Lumière — and why we chose to work with a family that has cultivated oysters for five generations.</p>
                <div class="flex items-center gap-3 text-[9px] text-warm-gray font-jost mb-4">
                    <span><i class="fa-solid fa-calendar mr-1"></i> February 18, 2026</span>
                    <span><i class="fa-solid fa-clock mr-1"></i> 5 min read</span>
                </div>
                <a href="{{ route('journal') }}" class="text-[9px] tracking-[0.2em] text-charcoal/50 hover:text-soft-gold transition-colors">CONTINUE READING →</a>
            </div>

            <!-- Article 6 -->
            <div class="article-card group cursor-pointer reveal" data-category="craft">
                <div class="overflow-hidden aspect-[4/3] mb-5 bg-charcoal/5">
                    <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=2070&auto=format&fit=crop" class="article-img w-full h-full object-cover">
                </div>
                <p class="text-[9px] tracking-[0.3em] text-soft-gold mb-3 uppercase">CRAFTSMANSHIP</p>
                <h3 class="font-playfair text-xl mb-2 leading-tight group-hover:text-soft-gold transition-colors">The Pavé Technique: Microscopic Precision</h3>
                <p class="text-warm-gray text-xs font-light leading-relaxed mb-3">How our stone setters place diamonds smaller than a grain of sand — and the magnifying tools that make it possible. A look inside the most delicate stage of production.</p>
                <div class="flex items-center gap-3 text-[9px] text-warm-gray font-jost mb-4">
                    <span><i class="fa-solid fa-calendar mr-1"></i> February 3, 2026</span>
                    <span><i class="fa-solid fa-clock mr-1"></i> 6 min read</span>
                </div>
                <a href="{{ route('journal') }}" class="text-[9px] tracking-[0.2em] text-charcoal/50 hover:text-soft-gold transition-colors">CONTINUE READING →</a>
            </div>

        </div>

        <!-- Empty state (filtered) -->
        <div id="empty-state" class="hidden py-20 text-center">
            <p class="font-cormorant italic text-5xl text-charcoal/10 mb-4">∅</p>
            <p class="font-playfair text-xl font-light text-charcoal/40 mb-2">No stories found</p>
            <p class="text-warm-gray text-xs font-jost font-light mb-6">Try selecting a different category</p>
        </div>

        <!-- Load More button -->
        <div class="text-center mt-16">
            <button id="load-more" class="group relative overflow-hidden px-12 py-4 border border-charcoal text-[10px] tracking-[0.3em] uppercase transition-colors duration-500 hover:text-white">
                <span class="relative z-10">LOAD MORE ARTICLES</span>
                <div class="absolute inset-0 bg-charcoal translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
            </button>
        </div>
    </main>

    <!-- NEWSLETTER SIGNUP (added) -->
    <section class="py-20 px-6 bg-deep-ivory border-t border-charcoal/5">
        <div class="max-w-2xl mx-auto text-center">
            <p class="text-soft-gold text-[10px] tracking-[0.35em] mb-4 font-jost">THE JOURNAL LETTER</p>
            <h2 class="font-playfair text-3xl font-light mb-4">Stories delivered <span class="font-cormorant italic">to your door.</span></h2>
            <p class="text-warm-gray text-sm font-jost font-light mb-8 max-w-md mx-auto">Subscribe to receive new journal entries, atelier dispatches, and private collection previews — once a month, no exceptions.</p>
            <div class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" placeholder="YOUR EMAIL ADDRESS" class="flex-1 bg-transparent border-b border-charcoal/15 py-3 px-2 text-xs font-jost outline-none focus:border-soft-gold transition-colors">
                <button class="btn-gold px-8 py-3 text-[10px] tracking-[0.22em] whitespace-nowrap"><span>SUBSCRIBE</span></button>
            </div>
            <p class="text-[9px] text-warm-gray/50 mt-4 font-jost">No spam. Unsubscribe anytime.</p>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-[#161616] pt-16 pb-8 px-6 md:px-12">
        <div class="max-w-screen-xl mx-auto text-center text-white/20 text-[9px] tracking-[0.2em] font-jost">© 2026 LUMIÈRE JEWELRY · PARIS</div>
    </footer>

    <style>
        .btn-gold{position:relative;overflow:hidden;background:#C9A84C;color:#fff;transition:color .3s}
        .btn-gold::before{content:'';position:absolute;inset:0;background:#A8862E;transform:translateY(100%);transition:transform .32s cubic-bezier(.4,0,.2,1)}
        .btn-gold:hover::before{transform:translateY(0)}
        .btn-gold span{position:relative;z-index:1}
    </style>

    <script>
        // Nav scroll
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 60));

        // Mobile menu
        const openBtn = document.getElementById('menu-open'), closeBtn = document.getElementById('menu-close');
        const mobileMenu = document.getElementById('mobile-menu'), menuOverlay = document.getElementById('menu-overlay');
        const openMenu = () => { mobileMenu.classList.add('open'); menuOverlay.classList.remove('hidden'); document.body.style.overflow='hidden'; };
        const closeMenu = () => { mobileMenu.classList.remove('open'); menuOverlay.classList.add('hidden'); document.body.style.overflow=''; };
        if (openBtn) openBtn.addEventListener('click', openMenu);
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        if (menuOverlay) menuOverlay.addEventListener('click', closeMenu);

        // Category filtering
        const categoryBtns = document.querySelectorAll('.category-btn');
        const articles = document.querySelectorAll('.article-card');
        const emptyState = document.getElementById('empty-state');
        const articlesGrid = document.getElementById('articles-grid');

        function filterArticles(category) {
            let visibleCount = 0;
            articles.forEach(article => {
                const articleCat = article.dataset.category;
                if (category === 'all' || articleCat === category) {
                    article.style.display = 'block';
                    visibleCount++;
                } else {
                    article.style.display = 'none';
                }
            });
            emptyState.classList.toggle('hidden', visibleCount > 0);
        }

        categoryBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                categoryBtns.forEach(b => b.classList.remove('active', 'border-soft-gold', 'text-charcoal'));
                btn.classList.add('active', 'border-soft-gold', 'text-charcoal');
                filterArticles(btn.dataset.cat);
            });
        });

        // Scroll reveal
        const reveals = document.querySelectorAll('.reveal');
        const obs = new IntersectionObserver(entries => { entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); }); }, { threshold: 0.1 });
        reveals.forEach(el => obs.observe(el));

        // Load more (demo)
        const loadMoreButton = document.getElementById('load-more');
        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', () => {
                // Reserved for future pagination behavior.
            });
        }

        async function updateHeaderCounts() {
            try {
                const [cartResponse, wishlistResponse] = await Promise.all([
                    fetch('/api/cart/count'),
                    fetch('/api/wishlist/count'),
                ]);
                const cartData = await cartResponse.json();
                const wishlistData = await wishlistResponse.json();

                const cartCount = document.getElementById('cart-count');
                const wishlistCount = document.getElementById('wishlist-count');
                if (cartCount) {
                    cartCount.textContent = cartData.count ?? 0;
                }
                if (wishlistCount) {
                    wishlistCount.textContent = wishlistData.count ?? 0;
                }
            } catch (error) {
                console.error('Unable to update header counts', error);
            }
        }

        document.addEventListener('DOMContentLoaded', updateHeaderCounts);
    </script>

    @include('partials.cart-drawer')
</body>
</html>