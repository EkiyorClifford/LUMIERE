{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\admin-login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUMIÈRE — Atelier</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'soft-gold': '#C9A84C',
                        'gold-light': '#E8C97A',
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
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% center' },
                            '100%': { backgroundPosition: '200% center' },
                        },
                        lineGrow: {
                            '0%': { width: '0' },
                            '100%': { width: '3rem' },
                        },
                        panLeft: {
                            '0%, 100%': { transform: 'scale(1.08) translateX(0)' },
                            '50%': { transform: 'scale(1.08) translateX(-2%)' },
                        },
                    },
                    animation: {
                        'fade-up-1': 'fadeUp 0.8s ease 0.1s both',
                        'fade-up-2': 'fadeUp 0.8s ease 0.25s both',
                        'fade-up-3': 'fadeUp 0.8s ease 0.4s both',
                        'fade-up-4': 'fadeUp 0.8s ease 0.55s both',
                        'fade-up-5': 'fadeUp 0.8s ease 0.7s both',
                        'shimmer': 'shimmer 4s linear infinite',
                        'line-grow': 'lineGrow 0.7s ease 0.8s both',
                        'pan-left': 'panLeft 30s ease-in-out infinite',
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Jost:wght@200;300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C97A;
            --charcoal: #1C1C1C;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--charcoal); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 2px; }
        ::selection { background: var(--gold); color: #fff; }

        /* Input field — borderline style, luxury minimal */
        .auth-input {
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            color: #fff;
            outline: none;
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.875rem;
            letter-spacing: 0.04em;
            transition: border-color 0.3s ease;
            width: 100%;
            padding: 0.75rem 0;
        }
        .auth-input::placeholder {
            color: rgba(255,255,255,0.2);
        }
        .auth-input:focus {
            border-bottom-color: var(--gold);
        }
        .auth-input:-webkit-autofill,
        .auth-input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 100px #1C1C1C inset;
            -webkit-text-fill-color: #fff;
        }

        /* Label float effect */
        .input-group {
            position: relative;
        }
        .input-label {
            position: absolute;
            top: 0.75rem;
            left: 0;
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.65rem;
            letter-spacing: 0.2em;
            color: rgba(255,255,255,0.3);
            pointer-events: none;
            transition: top 0.25s ease, font-size 0.25s ease, color 0.25s ease;
        }
        .auth-input:focus ~ .input-label,
        .auth-input:not(:placeholder-shown) ~ .input-label {
            top: -0.95rem;
            font-size: 0.55rem;
            color: var(--gold);
            letter-spacing: 0.25em;
        }

        /* Submit button */
        .btn-auth {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--gold);
            color: var(--gold);
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.65rem;
            letter-spacing: 0.28em;
            transition: color 0.35s ease;
            cursor: pointer;
        }
        .btn-auth::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gold);
            transform: translateX(-100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
            z-index: 0;
        }
        .btn-auth:hover::before { transform: translateX(0); }
        .btn-auth:hover { color: #1C1C1C; }
        .btn-auth span { position: relative; z-index: 1; }

        /* Gold shimmer wordmark */
        .gold-shimmer {
            background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 40%, var(--gold) 60%, var(--gold-light) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s linear infinite;
        }

        /* Gold rule */
        .gold-rule {
            display: block;
            width: 0;
            height: 1px;
            background: var(--gold);
            margin: 0 auto;
            animation: lineGrow 0.7s ease 0.8s both;
        }

        /* Noise overlay */
        .noise-overlay {
            position: absolute;
            inset: 0;
            opacity: 0.04;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Subtle grid lines on dark panel */
        .grid-lines {
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Error state */
        .input-error .auth-input {
            border-bottom-color: #e05252;
        }
        .input-error .input-label {
            color: #e05252 !important;
        }

        /* Checkbox custom */
        .custom-checkbox {
            appearance: none;
            width: 13px;
            height: 13px;
            border: 1px solid rgba(255,255,255,0.15);
            background: transparent;
            cursor: pointer;
            position: relative;
            transition: border-color 0.2s ease;
            flex-shrink: 0;
        }
        .custom-checkbox:checked {
            border-color: var(--gold);
            background: var(--gold);
        }
        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 3px;
            top: 1px;
            width: 5px;
            height: 8px;
            border: 1px solid #1C1C1C;
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
        }
    </style>
</head>
<body class="bg-charcoal font-jost overflow-hidden h-screen flex">

    <!-- ══════════════════════════════════
         LEFT PANEL — brand image
    ══════════════════════════════════ -->
    <div class="hidden lg:block relative w-[52%] overflow-hidden">
        <img
            src="https://images.unsplash.com/photo-1506630448388-4e683c67ddb0?q=80&w=2070&auto=format&fit=crop"
            alt="Lumière Atelier"
            class="absolute inset-0 w-full h-full object-cover animate-pan-left"
        >
        <!-- Dark gradient overlay — heavier at bottom + left edge -->
        <div class="absolute inset-0 bg-gradient-to-r from-charcoal/60 via-charcoal/20 to-charcoal/70"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-charcoal/70 via-transparent to-transparent"></div>
        <div class="noise-overlay"></div>

        <!-- Brand quote overlay -->
        <div class="absolute bottom-14 left-12 right-16">
            <span class="block w-8 h-px bg-soft-gold mb-6 opacity-70"></span>
            <p class="font-cormorant text-white/70 text-xl leading-relaxed italic font-light" style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">
                "Every piece is a conversation between the jeweler's hand and the light."
            </p>
            <p class="text-white/30 text-[10px] tracking-[0.25em] font-jost font-light mt-4">LUMIÈRE ATELIER, PARIS</p>
        </div>

        <!-- Decorative corner mark -->
        <div class="absolute top-10 left-10">
            <span class="text-soft-gold/30 text-[9px] tracking-[0.4em] font-jost font-light">ATELIER</span>
        </div>
    </div>

    <!-- ══════════════════════════════════
         RIGHT PANEL — login form
    ══════════════════════════════════ -->
    <div class="flex-1 relative flex flex-col items-center justify-center px-8 md:px-14 bg-[#161616] grid-lines overflow-y-auto">
        <div class="noise-overlay"></div>

        <!-- Gold vertical accent line — decorative -->
        <div class="absolute left-0 top-0 w-px h-full bg-gradient-to-b from-transparent via-soft-gold/20 to-transparent hidden lg:block"></div>

        <div class="relative z-10 w-full max-w-sm">

            <!-- Wordmark -->
            <div class="text-center mb-10 animate-fade-up-1">
                <a href="/" class="font-playfair text-3xl tracking-[0.3em] gold-shimmer inline-block">LUMIÈRE</a>
                <span class="gold-rule block mx-auto mt-4 mb-5"></span>
                <p class="text-white/25 text-[9px] tracking-[0.35em] font-jost font-light">ATELIER ADMINISTRATION</p>
            </div>

            <!-- Heading -->
            <div class="text-center mb-12 animate-fade-up-2">
                <h1 class="font-playfair text-2xl font-light text-white mb-2 tracking-wide">Welcome Back</h1>
                <p class="text-white/30 text-xs font-jost font-light tracking-wide">
                    Sign in to your atelier dashboard
                </p>
            </div>

            <!-- ── Laravel: if ($errors->any()) ── -->
            @if(isset($errors) && $errors->any())
            <div class="bg-red-900/20 border border-red-800/30 text-red-300 text-xs font-jost font-light px-4 py-3 mb-8 tracking-wide animate-fade-up-2">
                {{ $errors->first() }}
            </div>
            @endif

            <!-- ── Laravel: if (session('status')) ── -->
            @if (session('status'))
            <div class="bg-green-900/20 border border-green-800/30 text-green-300 text-xs font-jost font-light px-4 py-3 mb-8 tracking-wide animate-fade-up-2">
                {{ session('status') }}
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('admin.login') }}" novalidate class="animate-fade-up-3">
                @csrf

                <!-- Email -->
                <div class="input-group mb-10">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder=" "
                        autocomplete="email"
                        class="auth-input"
                        required
                    >
                    <label for="email" class="input-label">EMAIL ADDRESS</label>
                </div>

                <!-- Password -->
                <div class="input-group mb-3">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder=" "
                        autocomplete="current-password"
                        class="auth-input pr-8"
                        required
                    >
                    <label for="password" class="input-label">PASSWORD</label>
                    <!-- Toggle password visibility -->
                    <button
                        type="button"
                        id="toggle-password"
                        class="absolute right-0 bottom-2.5 text-white/25 hover:text-soft-gold transition-colors duration-200"
                        tabindex="-1"
                    >
                        <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                    </button>
                </div>

                <!-- Remember me + Forgot password -->
                <div class="flex items-center justify-between mb-12 animate-fade-up-4">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                        <input type="checkbox" name="remember" value="1" class="custom-checkbox">
                        <span class="text-white/30 text-[10px] tracking-[0.15em] font-jost font-light">REMEMBER ME</span>
                    </label>
                    <!-- Laravel: forgot password link -->
                    <a href="{{ route('password.request') }}" class="text-[10px] tracking-[0.15em] text-soft-gold/60 hover:text-soft-gold transition-colors duration-300 font-jost font-light">
                        FORGOT PASSWORD?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-auth w-full py-4 animate-fade-up-5">
                    <span>ENTER ATELIER</span>
                </button>

            </form>

            <!-- Footer note -->
            <p class="text-center text-white/15 text-[10px] tracking-[0.18em] font-jost font-light mt-12 animate-fade-up-5">
                RESTRICTED ACCESS &nbsp;·&nbsp; LUMIÈRE © 2026
            </p>

        </div>
    </div>

    <script>
        // Password visibility toggle
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('toggle-password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden', isPassword);
            eyeClosed.classList.toggle('hidden', !isPassword);
        });

        // Inline validation — highlight inputs on blur
        const inputs = document.querySelectorAll('.auth-input[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                const group = input.closest('.input-group');
                if (!input.value.trim()) {
                    group.classList.add('input-error');
                } else {
                    group.classList.remove('input-error');
                }
            });
            input.addEventListener('input', () => {
                const group = input.closest('.input-group');
                if (input.value.trim()) {
                    group.classList.remove('input-error');
                }
            });
        });
    </script>

</body>
</html>
