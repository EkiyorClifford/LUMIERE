@props(['config', 'collection', 'products'])

@php
    $alignment = $config['alignment'] ?? 'left';
    $mediaId = $config['media_id'] ?? null;
    $mediaAsset = $mediaId ? $collection->media->firstWhere('id', $mediaId) : null;
    $imageSrc = $mediaAsset ? $mediaAsset->getUrl() : asset('images/story_fallback_gold.png');
@endphp

<section class="py-24 bg-neutral-900 border-y border-neutral-800">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-center">
            
            <div class="space-y-6 lg:col-span-5 {{ $alignment === 'right' ? 'lg:order-2' : '' }}">
                <span class="text-xs uppercase tracking-[0.3em] text-[var(--accent-color,#D4AF37)] block font-medium">
                    The Heritage
                </span>
                
                <h2 class="text-3xl md:text-4xl font-light tracking-wide text-white uppercase">
                    {{ $config['heading'] ?? 'Crafted by Hand' }}
                </h2>
                
                <p class="text-neutral-400 text-sm md:text-base leading-relaxed tracking-wide font-light whitespace-pre-line">
                    {{ $config['text'] ?? 'Every curves tells a singular story of dedication, precision, and timeless elegance.' }}
                </p>
            </div>

            <div class="lg:col-span-7 {{ $alignment === 'right' ? 'lg:order-1' : '' }}">
                <div class="relative aspect-[4/5] md:aspect-[16/10] lg:aspect-[4/5] bg-neutral-950 overflow-hidden shadow-2xl">
                    <img 
                        src="{{ $imageSrc }}" 
                        alt="Editorial Detail Close up" 
                        class="w-full h-full object-cover object-center grayscale hover:grayscale-0 transition-all duration-700 ease-in-out"
                    >
                    <div class="absolute inset-0 ring-1 ring-inset ring-white/10 pointer-events-none"></div>
                </div>
            </div>

        </div>
    </div>
</section>