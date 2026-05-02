<form action="{{ route('newsletter') }}" method="POST" class="{{ $class ?? '' }}">
    @csrf
    <input type="hidden" name="source" value="{{ $source ?? 'newsletter_footer' }}">

    @if (session('newsletter_status'))
        <p class="text-soft-gold text-[10px] tracking-[0.2em] font-jost mb-3">{{ session('newsletter_status') }}</p>
    @endif

    <div class="flex gap-0 max-w-sm mx-auto border-b border-white/20 pb-0">
        <input type="email"
               name="email"
               required
               placeholder="Your email address"
               class="newsletter-input flex-1 py-3 px-1 text-sm font-jost font-light bg-transparent text-white outline-none">
        <button type="submit" class="text-soft-gold text-[10px] tracking-[0.25em] font-jost font-light hover:text-gold-light transition-colors duration-300 pb-3 pl-4 whitespace-nowrap">
            SUBSCRIBE →
        </button>
    </div>
</form>
