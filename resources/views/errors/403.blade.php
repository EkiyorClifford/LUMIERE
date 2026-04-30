{{-- resources/views/errors/403.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied | LUMIÈRE</title>
    
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
                    },
                    animation: { 'fade-up': 'fadeUp 0.9s ease both' }
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
            background: linear-gradient(160deg, #1C1C1C 0%, #2a2318 50%, #1C1C1C 100%);
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
        
        .btn-gold {
            position: relative; overflow: hidden;
            background: #C9A84C;
            color: #fff;
            transition: color 0.3s;
            display: inline-block;
        }
        .btn-gold::before {
            content: ''; position: absolute; inset: 0;
            background: #A8862E;
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-gold:hover::before { transform: translateY(0); }
        .btn-gold span { position: relative; z-index: 1; }
        
        .pattern-dots {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(201,168,76,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }
    </style>
</head>
<body class="font-jost overflow-x-hidden">

    <div class="error-bg min-h-screen flex flex-col items-center justify-center px-6 relative">
        <div class="pattern-dots"></div>
        
        <div class="relative z-10 max-w-2xl mx-auto text-center">
            <div class="w-16 h-16 rounded-full bg-soft-gold/10 flex items-center justify-center mx-auto mb-8 animate-fade-up">
                <i class="fa-regular fa-lock text-soft-gold text-2xl"></i>
            </div>
            
            <p class="font-cormorant italic text-soft-gold text-lg tracking-[0.3em] mb-5 animate-fade-up" style="animation-delay: 0.05s;">ACCESS DENIED</p>
            
            <h1 class="font-playfair font-light text-white text-5xl md:text-6xl mb-6 animate-fade-up" style="animation-delay: 0.1s;">
                This path is<br>
                <span class="gold-shimmer">private.</span>
            </h1>
            
            <span class="block w-12 h-px bg-soft-gold mx-auto mb-8 animate-fade-up" style="animation-delay: 0.15s;"></span>
            
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-sm p-6 mb-10 max-w-md mx-auto animate-fade-up" style="animation-delay: 0.2s;">
                <p class="text-white/50 text-xs font-jost font-light leading-relaxed">
                    <i class="fa-regular fa-crown text-soft-gold mr-2"></i>
                    Gold Circle members have access to exclusive areas. 
                    <a href="#" class="text-soft-gold hover:text-gold-light transition-colors">Sign in</a> to your private suite.
                </p>
            </div>
            
            <p class="text-white/45 font-jost font-light text-sm leading-relaxed max-w-md mx-auto mb-10 animate-fade-up" style="animation-delay: 0.25s;">
                This area requires special access. If you believe you should be here, please contact your personal consultant.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-5 justify-center animate-fade-up" style="animation-delay: 0.3s;">
                <a href="{{ url('/') }}" class="btn-outline-white px-8 py-4 text-[11px] tracking-[0.25em] font-jost">
                    <span>RETURN HOME</span>
                </a>
                <a href="#" class="btn-gold px-8 py-4 text-[11px] tracking-[0.25em] font-jost">
                    <span>LOGIN TO ESPACE</span>
                </a>
            </div>
            
            <p class="text-white/25 text-[9px] font-jost mt-12 animate-fade-up" style="animation-delay: 0.35s;">
                © 2026 LUMIÈRE · ALL RIGHTS RESERVED
            </p>
        </div>
    </div>

</body>
</html>