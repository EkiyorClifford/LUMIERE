<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUMIÈRE | Sign In</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=Jost:wght@200;300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold:        #C9A84C;
            --gold-light:  #E8C97A;
            --gold-dim:    rgba(201,168,76,0.15);
            --charcoal:    #141414;
            --charcoal-2:  #1E1E1E;
            --charcoal-3:  #2A2A2A;
            --cream:       #F9F6F0;
            --ivory:       #F2EDE4;
            --warm-gray:   #8A8580;
            --text-muted:  rgba(255,255,255,0.35);
            --text-dim:    rgba(255,255,255,0.55);
            --text-bright: rgba(255,255,255,0.88);
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Jost', sans-serif;
            background: var(--charcoal);
            color: #fff;
        }

        /* Layout */
        .layout {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Left — Image Panel */
        .image-panel {
            flex: 0 0 48%;
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 900px) { .image-panel { display: none; } }

        .image-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transform: scale(1.06);
            transition: opacity 1.4s cubic-bezier(0.4,0,0.2,1),
                        transform 8s cubic-bezier(0.4,0,0.2,1);
        }
        .image-slide.active {
            opacity: 1;
            transform: scale(1);
        }

        /* Cinematic vignette */
        .image-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(to right,  transparent 55%, var(--charcoal) 100%),
                linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, transparent 30%, transparent 60%, rgba(0,0,0,0.6) 100%),
                linear-gradient(to left,   transparent 80%, rgba(0,0,0,0.2) 100%);
            pointer-events: none;
            z-index: 2;
        }

        /* Noise grain overlay */
        .image-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 3;
            opacity: 0.04;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        .panel-content {
            position: absolute;
            inset: 0;
            z-index: 4;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px;
        }

        .panel-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            letter-spacing: 0.22em;
            color: #fff;
            text-decoration: none;
            opacity: 0.9;
        }

        .panel-quote-block {
            max-width: 320px;
        }

        .quote-mark {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            line-height: 1;
            color: var(--gold);
            opacity: 0.5;
            display: block;
            margin-bottom: -12px;
        }

        .panel-quote {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 300;
            font-size: 1.45rem;
            line-height: 1.55;
            color: rgba(255,255,255,0.82);
        }

        .panel-attribution {
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.65rem;
            letter-spacing: 0.28em;
            color: var(--gold);
            margin-top: 14px;
            display: block;
        }

        /* Image indicator dots */
        .slide-dots {
            display: flex;
            gap: 6px;
            margin-top: 28px;
        }
        .slide-dot {
            width: 18px;
            height: 1px;
            background: rgba(255,255,255,0.25);
            transition: background 0.4s ease, width 0.4s ease;
            cursor: pointer;
        }
        .slide-dot.active {
            background: var(--gold);
            width: 30px;
        }

        /* Right — Form Panel */
        .form-panel {
            flex: 1;
            background: var(--charcoal);
            position: relative;
            overflow-y: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
        }

        /* Subtle radial glow behind form */
        .form-panel::before {
            content: '';
            position: fixed;
            top: 30%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(201,168,76,0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        .form-inner {
            width: 100%;
            max-width: 380px;
            position: relative;
        }

        /* Mobile logo */
        .mobile-logo {
            display: none;
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            letter-spacing: 0.2em;
            color: #fff;
            text-align: center;
            margin-bottom: 36px;
            text-decoration: none;
        }
        @media (max-width: 900px) { .mobile-logo { display: block; } }

        /* Tab switcher */
        .tab-bar {
            display: flex;
            gap: 0;
            margin-bottom: 44px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            position: relative;
        }

        .tab-btn {
            flex: 1;
            background: none;
            border: none;
            padding: 0 0 16px;
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.65rem;
            letter-spacing: 0.28em;
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.3s ease;
            position: relative;
        }
        .tab-btn.active { color: #fff; }

        /* Gold underline indicator */
        .tab-indicator {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 50%;
            height: 1px;
            background: var(--gold);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .tab-indicator.register { transform: translateX(100%); }

        /* Form panels */
        .auth-form { display: none; }
        .auth-form.active {
            display: block;
            animation: formReveal 0.5s ease both;
        }
        @keyframes formReveal {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Stagger children */
        .auth-form.active .field-row:nth-child(1) { animation: fieldIn 0.45s ease 0.05s both; }
        .auth-form.active .field-row:nth-child(2) { animation: fieldIn 0.45s ease 0.12s both; }
        .auth-form.active .field-row:nth-child(3) { animation: fieldIn 0.45s ease 0.19s both; }
        .auth-form.active .field-row:nth-child(4) { animation: fieldIn 0.45s ease 0.26s both; }
        .auth-form.active .field-row:nth-child(5) { animation: fieldIn 0.45s ease 0.33s both; }
        .auth-form.active .form-footer           { animation: fieldIn 0.45s ease 0.4s  both; }
        @keyframes fieldIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Form heading */
        .form-heading {
            margin-bottom: 36px;
        }
        .form-eyebrow {
            font-size: 0.6rem;
            letter-spacing: 0.32em;
            color: var(--gold);
            font-weight: 300;
            display: block;
            margin-bottom: 10px;
        }
        .form-title {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 300;
            font-size: 2.4rem;
            line-height: 1.15;
            color: #fff;
        }

        /* Field rows */
        .field-row { margin-bottom: 28px; }

        .field-label {
            display: block;
            font-size: 0.6rem;
            letter-spacing: 0.28em;
            color: var(--text-muted);
            margin-bottom: 10px;
            font-weight: 300;
        }

        .field-wrap {
            position: relative;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            transition: border-color 0.3s ease;
        }
        .field-wrap:focus-within {
            border-bottom-color: var(--gold);
        }
        .field-wrap i {
            color: var(--text-muted);
            font-size: 0.75rem;
            margin-right: 12px;
            transition: color 0.3s ease;
            flex-shrink: 0;
        }
        .field-wrap:focus-within i { color: var(--gold); }

        .lux-input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            padding: 10px 0;
            font-family: 'Jost', sans-serif;
            font-weight: 300;
            font-size: 0.85rem;
            color: var(--text-bright);
            letter-spacing: 0.04em;
        }
        .lux-input::placeholder { color: rgba(255,255,255,0.2); }

        /* Password toggle */
        .pw-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 0.75rem;
            padding: 4px;
            transition: color 0.3s ease;
        }
        .pw-toggle:hover { color: var(--gold); }

        /* Name grid */
        .name-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Checkbox */
        .check-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 28px;
        }
        .custom-check {
            width: 14px;
            height: 14px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
            cursor: pointer;
            transition: border-color 0.3s ease, background 0.3s ease;
            position: relative;
        }
        .custom-check input { display: none; }
        .custom-check.checked {
            background: var(--gold);
            border-color: var(--gold);
        }
        .custom-check.checked::after {
            content: '';
            width: 6px;
            height: 4px;
            border-left: 1.5px solid #fff;
            border-bottom: 1.5px solid #fff;
            transform: rotate(-45deg) translate(0.5px, -0.5px);
        }
        .check-label {
            font-size: 0.72rem;
            font-weight: 300;
            color: var(--text-muted);
            line-height: 1.5;
            letter-spacing: 0.02em;
        }
        .check-label a {
            color: var(--gold);
            text-decoration: none;
            transition: opacity 0.2s ease;
        }
        .check-label a:hover { opacity: 0.75; }

        /* Forgot link */
        .forgot-link {
            display: block;
            text-align: right;
            font-size: 0.62rem;
            letter-spacing: 0.18em;
            color: var(--text-muted);
            text-decoration: none;
            margin-top: -16px;
            margin-bottom: 32px;
            transition: color 0.3s ease;
        }
        .forgot-link:hover { color: var(--gold); }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: var(--gold);
            border: none;
            color: #fff;
            font-family: 'Jost', sans-serif;
            font-weight: 400;
            font-size: 0.65rem;
            letter-spacing: 0.32em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: color 0.35s ease;
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: #A8862E;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-submit:hover::before { transform: translateY(0); }
        .btn-submit span { position: relative; z-index: 1; }

        /* Divider */
        .or-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 24px 0;
        }
        .or-divider::before,
        .or-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.07);
        }
        .or-divider span {
            font-size: 0.6rem;
            letter-spacing: 0.2em;
            color: var(--text-muted);
        }

        /* Social buttons */
        .social-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 28px;
        }
        .btn-social {
            padding: 11px;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-dim);
            font-family: 'Jost', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 0.18em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: border-color 0.3s ease, color 0.3s ease, background 0.3s ease;
        }
        .btn-social:hover {
            border-color: rgba(255,255,255,0.25);
            color: #fff;
            background: rgba(255,255,255,0.04);
        }
        .btn-social i { font-size: 0.85rem; }

        /* Form footer */
        .form-footer {
            text-align: center;
        }
        .switch-link {
            font-size: 0.65rem;
            color: var(--text-muted);
            letter-spacing: 0.12em;
        }
        .switch-link a {
            color: var(--gold);
            text-decoration: underline;
            transition: opacity 0.2s ease;
        }
        .switch-link a:hover { opacity: 0.7; }

        /* Back to site */
        .back-link {
            position: absolute;
            top: 32px;
            right: 32px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.6rem;
            letter-spacing: 0.22em;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .back-link:hover { color: var(--gold); }
        .back-link i { font-size: 0.7rem; }

        /* Shimmer on gold */
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

        /* Scrollbar */
        .form-panel::-webkit-scrollbar { width: 3px; }
        .form-panel::-webkit-scrollbar-track { background: transparent; }
        .form-panel::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.3); border-radius: 3px; }

        /* Error shake */
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%     { transform: translateX(-6px); }
            40%     { transform: translateX(6px); }
            60%     { transform: translateX(-4px); }
            80%     { transform: translateX(4px); }
        }
        .shake { animation: shake 0.4s ease; }

        .field-error {
            font-size: 0.6rem;
            color: #e57373;
            letter-spacing: 0.1em;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>

<div class="layout">

    <!-- LEFT — IMAGE PANEL -->
    <div class="image-panel">

        <!-- Slides -->
        <div class="image-slide active" style="background-image: url('https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=2070&auto=format&fit=crop')"></div>
        <div class="image-slide" style="background-image: url('https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=2187&auto=format&fit=crop')"></div>
        <div class="image-slide" style="background-image: url('https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=2070&auto=format&fit=crop')"></div>

        <div class="panel-content">
            <a href="{{ route('home') }}" class="panel-logo">LUMIÈRE</a>

            <div class="panel-quote-block">
                <span class="quote-mark">"</span>
                <p class="panel-quote" id="panel-quote">
                    Jewelry is a way of keeping memories alive and worn close to the heart.
                </p>
                <span class="panel-attribution" id="panel-attr">— THE LUMIÈRE ATELIER</span>
                <div class="slide-dots" id="slide-dots">
                    <div class="slide-dot active" data-index="0"></div>
                    <div class="slide-dot" data-index="1"></div>
                    <div class="slide-dot" data-index="2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT — FORM PANEL -->
    <div class="form-panel">
        <a href="{{ route('home') }}" class="back-link">
            <i class="fa-regular fa-arrow-left"></i> RETURN TO SITE
        </a>

        <div class="form-inner">
            <!-- Mobile logo -->
            <a href="{{ route('home') }}" class="mobile-logo">LUMIÈRE</a>

            <!-- Tab bar -->
            <div class="tab-bar">
                <button class="tab-btn active" id="tab-login" onclick="switchTab('login')">SIGN IN</button>
                <button class="tab-btn" id="tab-register" onclick="switchTab('register')">CREATE ACCOUNT</button>
                <div class="tab-indicator" id="tab-indicator"></div>
            </div>

            <!-- LOGIN FORM -->
            <form method="POST" action="{{ route('login') }}" class="auth-form active" id="form-login">
                @csrf

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 text-center text-[#C9A84C] text-xs font-jost">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="form-heading">
                    <span class="form-eyebrow">WELCOME BACK</span>
                    <h1 class="form-title">Sign in to<br>your account</h1>
                </div>

                <!-- Social login -->
                <div class="social-row field-row">
                    <button type="button" class="btn-social">
                        <i class="fa-brands fa-google"></i> GOOGLE
                    </button>
                    <button type="button" class="btn-social">
                        <i class="fa-brands fa-apple"></i> APPLE
                    </button>
                </div>

                <div class="or-divider field-row">
                    <span>OR CONTINUE WITH EMAIL</span>
                </div>

                <!-- Email -->
                <div class="field-row">
                    <label class="field-label" for="email">EMAIL ADDRESS</label>
                    <div class="field-wrap">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="email" name="email" class="lux-input" placeholder="you@example.com" 
                               value="{{ old('email') }}" required autofocus autocomplete="email">
                    </div>
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="field-row">
                    <label class="field-label" for="password">PASSWORD</label>
                    <div class="field-wrap">
                        <i class="fa-regular fa-lock"></i>
                        <input type="password" id="password" name="password" class="lux-input" placeholder="••••••••" 
                               required autocomplete="current-password">
                        <button type="button" class="pw-toggle" onclick="togglePw('password', this)" tabindex="-1">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">FORGOT PASSWORD?</a>
                @endif

                <!-- Remember me -->
                <div class="check-row field-row">
                    <div class="custom-check" onclick="toggleCheck(this)">
                        <input type="checkbox" name="remember" id="remember">
                    </div>
                    <label for="remember" class="check-label">Keep me signed in on this device</label>
                </div>

                <button type="submit" class="btn-submit">
                    <span>SIGN IN</span>
                </button>

                <div class="form-footer" style="margin-top:24px;">
                    <p class="switch-link">Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
                </div>
            </form>

        </div><!-- /form-inner -->
    </div><!-- /form-panel -->
</div><!-- /layout -->


<script>
    // TAB SWITCHING
    function switchTab(tab) {
        const loginForm    = document.getElementById('form-login');
        const tabLogin     = document.getElementById('tab-login');
        const tabRegister  = document.getElementById('tab-register');
        const indicator    = document.getElementById('tab-indicator');

        loginForm.classList.remove('active');
        tabLogin.classList.remove('active');
        tabRegister.classList.remove('active');

        if (tab === 'login') {
            loginForm.classList.add('active');
            tabLogin.classList.add('active');
            indicator.classList.remove('register');
        } else {
            tabRegister.classList.add('active');
            indicator.classList.add('register');
            // Redirect to register page
            window.location.href = '{{ route("register") }}';
        }
    }

    // PASSWORD TOGGLE
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        btn.querySelector('i').className = isText ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
    }

    // CHECKBOX TOGGLE
    function toggleCheck(el) {
        el.classList.toggle('checked');
        const inp = el.querySelector('input');
        inp.checked = !inp.checked;
    }

    // IMAGE SLIDESHOW
    let currentSlide = 0;
    const slides = document.querySelectorAll('.image-slide');
    const dots = document.querySelectorAll('.slide-dot');
    const quotes = [
        "Jewelry is a way of keeping memories alive and worn close to the heart.",
        "Every piece tells a story, every design holds a dream.",
        "Luxury is not about being seen, it's about being remembered."
    ];
    const attrs = [
        "— THE LUMIÈRE ATELIER",
        "— CRAFTED WITH PASSION",
        "— TIMELESS ELEGANCE"
    ];

    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        
        currentSlide = (currentSlide + 1) % slides.length;
        
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
        
        document.getElementById('panel-quote').textContent = quotes[currentSlide];
        document.getElementById('panel-attr').textContent = attrs[currentSlide];
    }

    // Auto-advance slides
    setInterval(nextSlide, 5000);

    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');
            
            currentSlide = index;
            
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
            
            document.getElementById('panel-quote').textContent = quotes[currentSlide];
            document.getElementById('panel-attr').textContent = attrs[currentSlide];
        });
    });
</script>

</body>
</html>
