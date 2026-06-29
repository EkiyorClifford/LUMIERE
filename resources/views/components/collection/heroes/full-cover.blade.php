@props(['config', 'collection', 'products'])

@php
    // Attempt to extract a Spatie Media asset if an asset ID is specified, otherwise use fallback
    $mediaId = $config['media_id'] ?? null;
    $mediaAsset = $mediaId ? $collection->media->firstWhere('id', $mediaId) : null;
    $imageSrc = $mediaAsset ? $mediaAsset->getUrl() : asset($config['legacy_image'] ?? 'images/diamond_bracelet_paris_night.png');
@endphp

<section class="relative w-full min-h-screen flex items-center justify-center overflow-hidden bg-neutral-950">
    <div class="absolute inset-0 w-full h-full">
        <img 
            src="{{ $imageSrc }}" 
            alt="{{ $config['title'] ?? $collection->name }}" 
            class="w-full h-full object-cover object-center transform scale-100 transition-transform duration-1000 ease-out hover:scale-105"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/40 to-neutral-950/30"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-6 text-center text-white space-y-4">
        @if(!empty($config['subtitle']))
            <span class="block text-xs uppercase tracking-[0.4em] text-neutral-400 font-light">
                {{ $config['subtitle'] }}
            </span>
        @endif
        
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-light tracking-wide uppercase leading-tight">
            {{ $config['title'] ?? $collection->name }}
        </h1>
        
        <div class="w-12 h-[1px] bg-[var(--accent-color,#D4AF37)] mx-auto my-6"></div>
        
        @if(!empty($collection->description))
            <p class="max-w-xl mx-auto text-sm md:text-base text-neutral-300 font-light leading-relaxed tracking-wide">
                {{ $collection->description }}
            </p>
        @endif
    </div>

    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 flex flex-col items-center space-y-2 opacity-70">
        <span class="text-[9px] uppercase tracking-[0.3em] text-neutral-400">Discover</span>
        <div class="w-[1px] h-8 bg-neutral-600 animate-pulse"></div>
    </div>
</section>