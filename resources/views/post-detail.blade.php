<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} | LUMIÈRE Fine Jewelry</title>
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
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        #mobile-menu { transform: translateX(100%); transition: transform 0.4s cubic-bezier(0.4,0,0.2,1); }
        #mobile-menu.open { transform: translateX(0); }
        .prose p { margin-bottom: 1.5rem; line-height: 1.8; }
        .prose h2 { margin-top: 2rem; margin-bottom: 1rem; }
        .prose h3 { margin-top: 1.5rem; margin-bottom: 0.75rem; }
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
                <button class="text-charcoal/60 hover:text-soft-gold"><i class="fa-regular fa-heart"></i></button>
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
                <button class="text-charcoal/60 hover:text-soft-gold relative">
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
        <div class="mt-auto flex gap-5 text-charcoal/40"><a href="javascript:void(0)"><i class="fa-brands fa-instagram text-lg hover:text-soft-gold"></i></a><a href="javascript:void(0)"><i class="fa-brands fa-pinterest text-lg hover:text-soft-gold"></i></a></div>
    </div>
    <div id="menu-overlay" class="fixed inset-0 bg-black/30 z-[55] hidden"></div>

    <!-- ARTICLE HEADER -->
    <article class="pt-40 pb-16 px-6 md:px-12">
        <div class="max-w-4xl mx-auto">
            <nav class="mb-8 animate-fade-up">
                <a href="{{ route('journal') }}" class="text-[9px] tracking-[0.3em] text-warm-gray hover:text-soft-gold transition-colors">← BACK TO JOURNAL</a>
            </nav>
            
            <header class="text-center mb-16 animate-fade-up" style="animation-delay: 0.1s;">
                <p class="text-soft-gold text-[10px] tracking-[0.4em] mb-6">{{ strtoupper($post->category->name ?? 'Uncategorized') }}</p>
                <h1 class="font-playfair text-4xl md:text-6xl font-light tracking-tighter mb-8 leading-tight">{{ $post->title }}</h1>
                
                <div class="flex flex-col md:flex-row items-center justify-center gap-6 text-[9px] text-warm-gray font-jost mb-8">
                    <span><i class="fa-regular fa-calendar mr-2"></i> {{ $post->published_at->format('F j, Y') }}</span>
                    <span><i class="fa-regular fa-clock mr-2"></i> {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                    <span><i class="fa-regular fa-pen mr-2"></i> {{ $post->author ?? 'Lumière Team' }}</span>
                </div>
                
                @if($post->featured_image)
                    <div class="w-full aspect-[16/9] overflow-hidden mb-8">
                        <img src="{{ $resolveImageUrl($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                @endif
            </header>

            <!-- ARTICLE CONTENT -->
            <div class="prose prose-lg max-w-none text-charcoal font-jost font-light leading-relaxed reveal" style="animation-delay: 0.2s;">
                <p class="text-xl font-cormorant italic text-center text-warm-gray mb-12">{{ $post->excerpt }}</p>
                
                <div class="text-left">
                    {!! $post->content !!}
                </div>
            </div>

            <!-- ARTICLE FOOTER -->
            <footer class="mt-20 pt-12 border-t border-charcoal/10 reveal" style="animation-delay: 0.3s;">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-center md:text-left">
                        <p class="text-[10px] tracking-[0.3em] text-soft-gold mb-2">SHARE THIS STORY</p>
                        <div class="flex gap-4">
                            <a href="javascript:void(0)" class="text-charcoal/60 hover:text-soft-gold transition-colors"><i class="fa-brands fa-pinterest"></i></a>
                            <a href="javascript:void(0)" class="text-charcoal/60 hover:text-soft-gold transition-colors"><i class="fa-brands fa-facebook"></i></a>
                            <a href="javascript:void(0)" class="text-charcoal/60 hover:text-soft-gold transition-colors"><i class="fa-brands fa-twitter"></i></a>
                            <a href="javascript:void(0)" class="text-charcoal/60 hover:text-soft-gold transition-colors"><i class="fa-solid fa-envelope"></i></a>
                        </div>
                    </div>
                    
                    <div class="text-center md:text-right">
                        <p class="text-[10px] tracking-[0.3em] text-soft-gold mb-2">VOLUME {{ $post->volume_label ?? 'Journal Issue' }}</p>
                        <p class="text-warm-gray text-xs">The Lumière Journal</p>
                    </div>
                </div>
            </footer>
        </div>
    </article>

    <!-- RELATED ARTICLES -->
    @if($relatedPosts->count() > 0)
        <section class="py-20 px-6 md:px-12 bg-deep-ivory">
            <div class="max-w-screen-xl mx-auto">
                <header class="text-center mb-16 reveal">
                    <p class="text-soft-gold text-[10px] tracking-[0.4em] mb-4">MORE STORIES</p>
                    <h2 class="font-playfair text-3xl md:text-4xl font-light tracking-tighter">You may also <span class="font-cormorant italic">enjoy</span></h2>
                </header>
                
                <div class="grid md:grid-cols-3 gap-12">
                    @foreach($relatedPosts as $relatedPost)
                        <div class="group reveal">
                            <a href="{{ route('post.show', $relatedPost->slug) }}">
                                @if($relatedPost->featured_image)
                                    <div class="aspect-[4/3] overflow-hidden mb-6">
                                        <img src="{{ $resolveImageUrl($relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    </div>
                                @endif
                                <p class="text-[9px] tracking-[0.3em] text-soft-gold mb-3">{{ strtoupper($relatedPost->category->name ?? 'Uncategorized') }}</p>
                                <h3 class="font-playfair text-xl mb-3 leading-tight group-hover:text-soft-gold transition-colors">{{ $relatedPost->title }}</h3>
                                <p class="text-warm-gray text-xs font-light line-clamp-3">{{ $relatedPost->excerpt }}</p>
                                <span class="text-[9px] tracking-[0.2em] text-charcoal/50 hover:text-soft-gold transition-colors mt-4 inline-block">CONTINUE READING →</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- NEWSLETTER -->
    <section class="py-20 px-6 bg-cream">
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
        .line-clamp-3{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
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
        openBtn.addEventListener('click', openMenu); closeBtn.addEventListener('click', closeMenu); menuOverlay.addEventListener('click', closeMenu);

        // Scroll reveal
        const reveals = document.querySelectorAll('.reveal');
        const obs = new IntersectionObserver(entries => { entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); }); }, { threshold: 0.1 });
        reveals.forEach(el => obs.observe(el));
    </script>
</body>
</html>
