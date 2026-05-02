<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-heading">
            <span class="form-eyebrow">JOIN THE INNER CIRCLE</span>
            <h1 class="form-title">Create your<br>account</h1>
        </div>

        <!-- Name -->
        <div class="field-row">
            <label class="field-label">FULL NAME</label>
            <div class="field-wrap">
                <i class="fa-regular fa-user"></i>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                       class="lux-input" placeholder="Your full name">
            </div>
            @error('name')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="field-row">
            <label class="field-label">EMAIL ADDRESS</label>
            <div class="field-wrap">
                <i class="fa-regular fa-envelope"></i>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                       class="lux-input" placeholder="you@example.com">
            </div>
            @error('email')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone (Optional) -->
        <div class="field-row">
            <label class="field-label">PHONE <span style="color: var(--text-muted); font-weight: normal;">(OPTIONAL)</span></label>
            <div class="field-wrap">
                <i class="fa-regular fa-phone"></i>
                <input id="phone" type="tel" name="phone" :value="old('phone')" autocomplete="tel"
                       class="lux-input" placeholder="+33 1 40 00 00 00">
            </div>
            @error('phone')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="field-row">
            <label class="field-label">PASSWORD</label>
            <div class="field-wrap">
                <i class="fa-regular fa-lock"></i>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="lux-input" placeholder="Minimum 8 characters">
                <button type="button" class="pw-toggle" onclick="togglePw('password', this)" tabindex="-1">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
            @error('password')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="field-row">
            <label class="field-label">CONFIRM PASSWORD</label>
            <div class="field-wrap">
                <i class="fa-regular fa-lock-keyhole"></i>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="lux-input" placeholder="Repeat password">
                <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)" tabindex="-1">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-submit">
            <span>CREATE MY ACCOUNT</span>
        </button>

        <div class="form-footer" style="margin-top:24px;">
            <p class="switch-link">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </form>
</x-guest-layout>
