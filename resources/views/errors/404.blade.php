{{-- resources/views/errors/404.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | LUMIÈRE</title>
    <meta name="description" content="The page you're looking for does not exist. Return to LUMIÈRE's world of fine jewelry.">
    
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
                        fadeUp: { '0%': { opacity:'0', transform:'translateY(24px)' }, '100%': { opacity:'1', transform:'translateY(0)' } },
                        floatY: { '0%,100%': { transform:'translateY(0px)' }, '50%': { transform:'translateY(-12px)' } },
                    },
                    animation: { 'fade-up': 'fadeUp 0.9s ease both', 'float': 'floatY 8s ease-in-out infinite' }
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
        
        .error-bg {
            background: linear-gradient(145deg, #0a0a08 0%, #161610 40%, #1a1812 100%);
            position: relative;
            overflow: hidden;
        }
        .error-grid {
            position: absolute; inset: 0;
            background-image: linear-gradient(rgba(201,168,76,0.04) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(201,168,76,0.04) 1px, transparent 1px);
            background-size: 55px 55px;
            pointer-events: none;
        }
        .error-vignette {
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at center, transparent 35%, rgba(0,0,0,0.6) 100%);
            pointer-events: none;
        }
        .noise-overlay {
            position: absolute; inset: 0;
            opacity: 0.02;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            pointer-events: none;
        }
        .gold-shimmer {
            background: linear-gradient(90deg, #C9A84C 0%, #E8C97A 40%, #C9A84C 60%, #E8C97A 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s linear infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .btn-outline-white {
            position: relative; overflow: hidden;
            border: 1px solid rgba(255,255,255,0.35);
            color: #fff;
            transition: color 0.3s;
            background: transparent;
            display: inline-block;
        }
        .btn-outline-white::before {
            content: ''; position: absolute; inset: 0;
            background: #fff;
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-outline-white:hover::before { transform: translateY(0); }
        .btn-outline-white:hover { color: #1C1C1C; }
        .btn-outline-white span { position: relative; z-index: 1; }
        
        .gold-dust {
            position: absolute;
            width: 3px; height: 3px;
            background: rgba(201,168,76,0.3);
            border-radius: 50%;
            pointer-events: none;
        }
    </style>
</head>
<body class="font-jost overflow-x-hidden">

    <div class="error-bg min-h-screen flex flex-col items-center justify-center px-6 relative">
        <div class="error-grid"></div>
        <div class="error-vignette"></div>
        <div class="noise-overlay"></div>
        
        <!-- Floating gold dust particles -->
        <div class="gold-dust" style="top: 15%; left: 10%; animation: floatY 12s ease-in-out infinite;"></div>
        <div class="gold-dust" style="top: 70%; left: 85%; width: 2px; height: 2px; animation: floatY 9s ease-in-out infinite 1s;"></div>
        <div class="gold-dust" style="top: 45%; left: 92%; width: 4px; height: 4px; animation: floatY 14s ease-in-out infinite 2s;"></div>
        <div class="gold-dust" style="top: 80%; left: 12%; width: 2px; height: 2px; animation: floatY 11s ease-in-out infinite 0.5s;"></div>
        <div class="gold-dust" style="top: 25%; left: 88%; animation: floatY 10s ease-in-out infinite 3s;"></div>
        
        <!-- Decorative large text (barely visible) -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none overflow-hidden">
            <span class="font-cormorant italic font-light text-[clamp(8rem,20vw,20rem)] text-[rgba(201,168,76,0.02)] leading-none whitespace-nowrap">
                404
            </span>
        </div>

        <div class="relative z-10 max-w-2xl mx-auto text-center">
            <!-- Error code with gold shimmer -->
            <p class="font-cormorant italic text-soft-gold text-lg tracking-[0.3em] mb-6 animate-fade-up">ERROR 404</p>
            
            <h1 class="font-playfair font-light text-white text-6xl md:text-7xl mb-6 animate-fade-up" style="animation-delay: 0.1s;">
                The page you're<br>
                <span class="gold-shimmer">searching for</span><br>
                does not exist.
            </h1>
            
            <span class="block w-12 h-px bg-soft-gold mx-auto mb-8 animate-fade-up" style="animation-delay: 0.2s;"></span>
            
            <p class="text-white/45 font-jost font-light text-sm leading-relaxed max-w-md mx-auto mb-10 animate-fade-up" style="animation-delay: 0.3s;">
                Perhaps the link has changed, or the page never existed. Our atelier continues its work — and you're always welcome here.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-5 justify-center animate-fade-up" style="animation-delay: 0.4s;">
                <a href="{{ url('/') }}" class="btn-outline-white px-8 py-4 text-[11px] tracking-[0.25em] font-jost">
                    <span>RETURN HOME</span>
                </a>
                <a href="{{ route('shop') }}" class="btn-outline-white px-8 py-4 text-[11px] tracking-[0.25em] font-jost">
                    <span>EXPLORE COLLECTIONS</span>
                </a>
            </div>
            
            <!-- Suggestion links -->
            <div class="mt-16 pt-8 border-t border-white/5 text-center">
                <p class="text-white/30 text-[9px] tracking-[0.2em] font-jost mb-4">PERHAPS YOU'RE LOOKING FOR</p>
                <div class="flex flex-wrap gap-6 justify-center">
                    <a href="{{ route('shop', ['category' => 'rings']) }}" class="text-white/40 hover:text-soft-gold text-[10px] tracking-[0.15em] font-jost transition-colors">RINGS</a>
                    <a href="{{ route('shop', ['category' => 'necklaces']) }}" class="text-white/40 hover:text-soft-gold text-[10px] tracking-[0.15em] font-jost transition-colors">NECKLACES</a>
                    <a href="{{ route('shop', ['category' => 'earrings']) }}" class="text-white/40 hover:text-soft-gold text-[10px] tracking-[0.15em] font-jost transition-colors">EARRINGS</a>
                    <a href="{{ route('atelier') }}" class="text-white/40 hover:text-soft-gold text-[10px] tracking-[0.15em] font-jost transition-colors">THE ATELIER</a>
                    <a href="{{ route('bespoke') }}" class="text-white/40 hover:text-soft-gold text-[10px] tracking-[0.15em] font-jost transition-colors">BESPOKE</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>