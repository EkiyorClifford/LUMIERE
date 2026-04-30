{{-- resources/views/errors/500.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error | LUMIÈRE</title>
    
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
                        pulse: { '0%,100%': { opacity: 0.4 }, '50%': { opacity: 0.8 } }
                    },
                    animation: { 'fade-up': 'fadeUp 0.9s ease both', 'pulse': 'pulse 3s ease-in-out infinite' }
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
            background: linear-gradient(135deg, #1a1812 0%, #0a0a08 50%, #1a1812 100%);
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
        
        .pulse-ring {
            position: absolute;
            width: 200px; height: 200px;
            border-radius: 50%;
            border: 1px solid rgba(201,168,76,0.15);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse 4s ease-out infinite;
        }
        .pulse-ring:nth-child(2) { animation-delay: 1.5s; width: 300px; height: 300px; }
        .pulse-ring:nth-child(3) { animation-delay: 3s; width: 400px; height: 400px; }
        
        @keyframes pulse {
            0% { opacity: 0.5; transform: translate(-50%, -50%) scale(0.8); }
            100% { opacity: 0; transform: translate(-50%, -50%) scale(1.5); }
        }
    </style>
</head>
<body class="font-jost overflow-x-hidden">

    <div class="error-bg min-h-screen flex flex-col items-center justify-center px-6 relative">
        
        <!-- Pulse rings -->
        <div class="pulse-ring"></div>
        <div class="pulse-ring"></div>
        <div class="pulse-ring"></div>
        
        <div class="relative z-10 max-w-2xl mx-auto text-center">
            <p class="font-cormorant italic text-soft-gold text-lg tracking-[0.3em] mb-6 animate-fade-up">SERVER ERROR</p>
            
            <h1 class="font-playfair font-light text-white text-6xl md:text-7xl mb-6 animate-fade-up" style="animation-delay: 0.1s;">
                The atelier is<br>
                <span class="text-soft-gold">momentarily quiet.</span>
            </h1>
            
            <span class="block w-12 h-px bg-soft-gold mx-auto mb-8 animate-fade-up" style="animation-delay: 0.15s;"></span>
            
            <p class="text-white/45 font-jost font-light text-sm leading-relaxed max-w-md mx-auto mb-10 animate-fade-up" style="animation-delay: 0.2s;">
                Something interrupted the work. Our artisans have been notified and are returning to their benches. Please try again in a few moments.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-5 justify-center animate-fade-up" style="animation-delay: 0.25s;">
                <a href="javascript:location.reload()" class="btn-outline-white px-8 py-4 text-[11px] tracking-[0.25em] font-jost">
                    <span>TRY AGAIN</span>
                </a>
                <a href="{{ url('/') }}" class="btn-outline-white px-8 py-4 text-[11px] tracking-[0.25em] font-jost">
                    <span>RETURN HOME</span>
                </a>
            </div>
            
            <!-- Contact support -->
            <p class="text-white/25 text-[10px] font-jost mt-12">
                Persistent issue? Contact us at 
                <a href="mailto:support@lumiere.com" class="text-soft-gold/60 hover:text-soft-gold transition-colors">support@lumiere.com</a>
            </p>
        </div>
    </div>

</body>
</html>