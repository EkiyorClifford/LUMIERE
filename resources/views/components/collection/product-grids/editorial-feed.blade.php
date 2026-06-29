@props(['config', 'collection', 'products'])

{{-- Main section container: py-24 provides generous white space typical of luxury branding --}}
<section class="py-24 bg-neutral-950 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-16">
        
        {{-- Header: Centered layout to focus attention on the collection title --}}
        <div class="text-center space-y-3">
            <h2 class="text-2xl md:text-3xl font-light uppercase tracking-widest text-white">The Pieces</h2>
            <p class="text-xs uppercase tracking-[0.2em] text-neutral-500">Explore the {{ $collection->name }} vault</p>
        </div>

        {{-- Swiper Container: The engine for our premium carousel interaction --}}
        <div class="swiper editorialSwiper">
            <div class="swiper-wrapper">
                @forelse($products as $product)
                    {{-- Article: Represents an individual product card --}}
                    <article class="swiper-slide group relative flex flex-col space-y-4 !h-auto">
                        
                        {{-- Image Container: Fixed aspect ratio for consistent grid alignment --}}
                        <div class="relative aspect-[3/4] bg-neutral-900 overflow-hidden border border-neutral-900 group-hover:border-neutral-800 transition-colors duration-500">
                            
                            @php
                                // Use the Product model method to fetch optimized Spatie media or legacy URL
                                $imageUrl = $product->productImageUrl('card') ?? asset('images/product_placeholder.png');
                            @endphp
                            
                            {{-- Image: Zoom effect is slowed (1200ms) for a premium, heavy-weight feel --}}
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-[1200ms] ease-out group-hover:scale-105" loading="lazy" />

                            {{-- Hover Overlay: Hidden until hover, then fades in to highlight the Call-to-Action --}}
                            <div class="absolute inset-0 bg-neutral-950/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center p-6">
                                <a href="{{ route('product.show', $product->slug) }}" 
                                   class="w-full bg-white text-neutral-950 text-center py-3 text-xs uppercase tracking-widest font-medium transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    View Artisan Piece
                                </a>
                            </div>
                        </div>

                        {{-- Product Meta: Text hierarchy for name and price --}}
                        <div class="flex justify-between items-baseline pt-2">
                            <h3 class="text-sm font-light uppercase tracking-wider text-white">
                                {{-- Link triggers product detail page via route model binding --}}
                                <a href="{{ route('product.show', $product->slug) }}" class="relative inline-block hover:text-amber-500 transition-colors duration-500">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            {{-- Price display: number_format ensures consistent financial formatting --}}
                            <span class="text-xs text-neutral-400 font-light tracking-wide">€{{ number_format($product->price, 2) }}</span>
                        </div>
                    </article>
                @empty
                    {{-- Empty State: Shown if the vault section contains no active items --}}
                    <div class="text-neutral-500 italic">No pieces currently in this vault.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Swiper Initialization: Configures mobile-first responsive breakpoints --}}
    <script>
        new Swiper('.editorialSwiper', {
            slidesPerView: 1.2, // Shows 1.2 slides on mobile to imply off-screen content
            spaceBetween: 20,
            grabCursor: true,   // Changes mouse to 'hand' icon for better UX
            breakpoints: {
                768: { slidesPerView: 3, spaceBetween: 40 }, // Tablet: 3 columns
                1024: { slidesPerView: 3.5, spaceBetween: 40 } // Desktop: 3.5 creates the 'peeking' effect
            }
        });
    </script>
</section>