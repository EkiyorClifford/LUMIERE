<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-center text-[#C9A84C] text-xs font-jost">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-heading">
            <span class="form-eyebrow">WELCOME BACK</span>
            <h1 class="form-title">Sign in to<br>your account</h1>
        </div>

        <!-- Email Address -->
        <div class="field-row">
            <label class="field-label">EMAIL ADDRESS</label>
            <div class="field-wrap">
                <i class="fa-regular fa-envelope"></i>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                       class="lux-input" placeholder="you@example.com">
            </div>
            @error('email')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="field-row">
            <label class="field-label">PASSWORD</label>
            <div class="field-wrap">
                <i class="fa-regular fa-lock"></i>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="lux-input" placeholder="••••••••">
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

        <!-- Remember Me -->
        <div class="check-row field-row">
            <div class="custom-check">
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
</x-guest-layout>
