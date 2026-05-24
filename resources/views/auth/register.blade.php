@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-heading">
            <span class="form-eyebrow">JOIN THE INNER CIRCLE</span>
            <h1 class="form-title">Create your<br>account</h1>
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

        <!-- Name grid -->
        <div class="field-row name-grid">
            <div>
                <label class="field-label" for="name">FIRST NAME</label>
                <div class="field-wrap">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" id="name" name="name" class="lux-input" placeholder="Isabelle" 
                           value="{{ old('name') }}" required autofocus autocomplete="name">
                </div>
                @error('name')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="field-label" for="last_name">LAST NAME</label>
                <div class="field-wrap">
                    <input type="text" id="last_name" name="last_name" class="lux-input" placeholder="Moreau" 
                           value="{{ old('last_name') }}" autocomplete="family-name">
                </div>
                @error('last_name')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Email -->
        <div class="field-row">
            <label class="field-label" for="email">EMAIL ADDRESS</label>
            <div class="field-wrap">
                <i class="fa-regular fa-envelope"></i>
                <input type="email" id="email" name="email" class="lux-input" placeholder="you@example.com" 
                       value="{{ old('email') }}" required autocomplete="email">
            </div>
            @error('email')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div class="field-row">
            <label class="field-label" for="phone">PHONE NUMBER</label>
            <div class="field-wrap">
                <i class="fa-regular fa-phone"></i>
                <input type="tel" id="phone" name="phone" class="lux-input" placeholder="+1 (555) 123-4567" 
                       value="{{ old('phone') }}" autocomplete="tel">
            </div>
            @error('phone')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="field-row">
            <label class="field-label" for="password">PASSWORD</label>
            <div class="field-wrap">
                <i class="fa-regular fa-lock"></i>
                <input type="password" id="password" name="password" class="lux-input" placeholder="Minimum 8 characters"
                       required autocomplete="new-password" oninput="checkStrength(this.value)">
                <button type="button" class="pw-toggle" onclick="togglePw('password', this)" tabindex="-1">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
            <!-- Strength meter -->
            <div class="pw-strength" id="pw-strength">
                <div class="pw-bar" id="bar-1"></div>
                <div class="pw-bar" id="bar-2"></div>
                <div class="pw-bar" id="bar-3"></div>
                <div class="pw-bar" id="bar-4"></div>
            </div>
            <p class="pw-label" id="pw-label">&nbsp;</p>
            @error('password')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm password -->
        <div class="field-row">
            <label class="field-label" for="password_confirmation">CONFIRM PASSWORD</label>
            <div class="field-wrap">
                <i class="fa-regular fa-lock-keyhole"></i>
                <input type="password" id="password_confirmation" name="password_confirmation" class="lux-input" placeholder="Repeat password" 
                       required autocomplete="new-password">
                <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)" tabindex="-1">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Terms -->
        <div class="check-row field-row">
            <div class="custom-check" id="terms-check" onclick="toggleCheck(this)">
                <input type="checkbox" id="terms">
            </div>
            <label for="terms" class="check-label">I agree to LUMIÈRE's <a href="javascript:void(0)" aria-disabled="true">Terms of Service</a> and <a href="javascript:void(0)" aria-disabled="true">Privacy Policy</a></label>
        </div>
        @error('terms')
            <p class="field-error" style="margin-top:-20px; margin-bottom:16px;">{{ $message }}</p>
        @enderror

        <!-- Newsletter opt-in -->
        <div class="check-row field-row" style="margin-bottom:32px;">
            <div class="custom-check checked" id="news-check" onclick="toggleCheck(this)">
                <input type="checkbox" id="newsletter" checked>
            </div>
            <label for="newsletter" class="check-label">Receive exclusive offers and new collection previews by email</label>
        </div>

        <button type="submit" class="btn-submit">
            <span>CREATE MY ACCOUNT</span>
        </button>

        <div class="form-footer" style="margin-top:24px;">
            <p class="switch-link">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </form>

    <script>
        // Password strength checker
        function checkStrength(password) {
            const strengthBars = document.querySelectorAll('.pw-bar');
            const strengthLabel = document.getElementById('pw-label');
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            // Reset bars
            strengthBars.forEach(bar => bar.className = 'pw-bar');
            
            if (password.length === 0) {
                strengthLabel.textContent = '';
                return;
            }
            
            // Set bars based on strength
            for (let i = 0; i < strength; i++) {
                if (strength === 1) strengthBars[i].classList.add('weak');
                else if (strength === 2) strengthBars[i].classList.add('fair');
                else if (strength >= 3) strengthBars[i].classList.add('strong');
            }
            
            // Set label text
            if (strength === 1) strengthLabel.textContent = 'Weak password';
            else if (strength === 2) strengthLabel.textContent = 'Fair password';
            else if (strength === 3) strengthLabel.textContent = 'Strong password';
            else if (strength === 4) strengthLabel.textContent = 'Very strong password';
        }

        // Tab switching
        function switchTab(tab) {
            if (tab === 'login') {
                window.location.href = '{{ route("login") }}';
            }
        }
    </script>
@endsection
