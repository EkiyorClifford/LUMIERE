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
    @php
        $resolveImageUrl = static function (?string $path): ?string {
            if (! $path) {
                return null;
            }

            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            return asset('storage/' . ltrim($path, '/'));
        };
    @endphp

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
                <a href="{{ route('wishlist.index') }}" class="text-charcoal/60 hover:text-soft-gold"><i class="fa-regular fa-heart"></i></a>
                @auth
                    <div class="relative group">
                        <button class="text-charcoal/60 hover:text-soft-gold flex items-center gap-2">
                            <i class="fa-solid fa-user"></i>
                            <span class="text-xs font-jost hidden md:block">{{ auth()->user()->name }}</span>
                        </button>
                        @if(auth()->user()->is_gold_circle)
                            <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-soft-gold"></span>
                        @endif
                        <div class="absolute top-full right-0 mt-2 w-48 bg-white shadow-lg rounded-sm py-2 hidden group-hover:block">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs text-charcoal hover:bg-cream">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-xs text-charcoal hover:bg-cream">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-charcoal/60 hover:text-soft-gold text-xs font-jost">Sign In</a>
                @endauth
                <button onclick="toggleCart()" class="text-charcoal/60 hover:text-soft-gold relative">
                    <i class="fa-regular fa-bag-shopping"></i>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-soft-gold text-white text-[8px] flex items-center justify-center">{{ count(session('cart')) }}</span>
                    @endif
                </button>
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
            @foreach($categories as $category)
                <a href="{{ route('post.category', $category->slug) }}" class="category-btn {{ request()->route('post.category')?->parameter('slug') == $category->slug ? 'active' : '' }} text-[10px] tracking-[0.2em] font-jost text-charcoal/60 hover:text-charcoal transition-colors pb-2 border-b-2 border-transparent">
                    {{ strtoupper($category->name) }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- FEATURED ARTICLE (always visible) -->
    @if($posts->count() > 0)
        <section class="px-6 md:px-12 max-w-screen-xl mx-auto mt-16 mb-20 reveal">
            <div class="group cursor-pointer relative overflow-hidden bg-white shadow-sm">
                <div class="flex flex-col md:flex-row">
                    <div class="w-full md:w-2/3 overflow-hidden aspect-[16/9]">
                        <img src="{{ $resolveImageUrl($featured->featured_image) ?? 'https://images.unsplash.com/photo-1530968033775-2c92736b131e?q=80&w=2071&auto=format&fit=crop' }}" class="article-img w-full h-full object-cover">
                    </div>
                    <div class="w-full md:w-1/3 p-10 md:p-12 flex flex-col justify-center">
                        <p class="text-[9px] tracking-[0.3em] text-soft-gold mb-4 uppercase">{{ $featured->category->name }}</p>
                        <h2 class="font-playfair text-2xl md:text-3xl mb-4 leading-tight">{{ $featured->title }}</h2>
                        <p class="text-warm-gray text-xs font-light leading-relaxed mb-4">{{ $featured->excerpt }}</p>
                        <div class="flex items-center gap-4 text-[9px] text-warm-gray font-jost mb-5">
                            <span><i class="fa-regular fa-calendar mr-1"></i> {{ $featured->published_at->format('F j, Y') }}</span>
                            <span><i class="fa-regular fa-clock mr-1"></i> {{ ceil(str_word_count(strip_tags($featured->content)) / 200) }} min read</span>
                            <span><i class="fa-regular fa-pen mr-1"></i> {{ $featured->author ?? 'Lumière Team' }}</span>
                        </div>
                        <a href="{{ route('post.show', $featured->slug) }}" class="text-[10px] tracking-[0.2em] border-b border-charcoal/20 pb-1 hover:border-soft-gold transition-colors inline-flex items-center gap-2">READ THE STORY <i class="fa-regular fa-arrow-right text-[9px]"></i></a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- ARTICLE GRID (filterable) -->
    <main class="px-6 md:px-12 max-w-screen-xl mx-auto pb-32">
        @if($posts->count() > 0)
            <div id="articles-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
                @foreach($posts->skip(1) as $post)
                    <div class="article-card group cursor-pointer reveal">
                        <a href="{{ route('post.show', $post->slug) }}">
                            <div class="overflow-hidden aspect-[4/3] mb-5 bg-charcoal/5">
                                <img src="{{ $resolveImageUrl($post->featured_image) ?? 'https://images.unsplash.com/photo-1582657050916-f91e9bd60ca1?q=80&w=1974&auto=format&fit=crop' }}" class="article-img w-full h-full object-cover">
                            </div>
                            <p class="text-[9px] tracking-[0.3em] text-soft-gold mb-3 uppercase">{{ $post->category->name }}</p>
                            <h3 class="font-playfair text-xl mb-2 leading-tight group-hover:text-soft-gold transition-colors">{{ $post->title }}</h3>
                            <p class="text-warm-gray text-xs font-light leading-relaxed mb-3">{{ $post->excerpt }}</p>
                            <div class="flex items-center gap-3 text-[9px] text-warm-gray font-jost mb-4">
                                <span><i class="fa-regular fa-calendar mr-1"></i> {{ $post->published_at->format('F j, Y') }}</span>
                                <span><i class="fa-regular fa-clock mr-1"></i> {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                            </div>
                            <span class="text-[9px] tracking-[0.2em] text-charcoal/50 hover:text-soft-gold transition-colors">CONTINUE READING →</span>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16 flex justify-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="py-20 text-center">
                <p class="font-cormorant italic text-5xl text-charcoal/10 mb-4">∅</p>
                <p class="font-playfair text-xl font-light text-charcoal/40 mb-2">No stories found</p>
                <p class="text-warm-gray text-xs font-jost font-light mb-6">Try selecting a different category</p>
            </div>
        @endif
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
    </script>
    @include('partials.cart-drawer')
</body>
</html>