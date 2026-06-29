<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $collection->name }} | Lumière Haute Joaillerie</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300&family=Montserrat:wght@200;300;400&display=swap');
        body { font-family: 'Montserrat', sans-serif; }
        h1, h2, h3, h4, .font-editorial { font-family: 'Cormorant Garamond', serif; }
    </style>
</head>
<body class="bg-neutral-950 text-neutral-100 min-h-screen antialiased selection:bg-neutral-800 selection:text-white">

    <header class="absolute top-0 left-0 w-full z-50 bg-gradient-to-b from-neutral-950/70 to-transparent py-6 px-8 flex justify-between items-center border-b border-white/5">
        <a href="#" class="text-xl font-light uppercase tracking-[0.3em] text-white">Lumière</a>
        <nav class="hidden md:flex space-x-8 text-xs uppercase tracking-widest text-neutral-300 font-light">
            <a href="#" class="hover:text-white transition-colors">La Maison</a>
            <a href="#" class="hover:text-white transition-colors text-white border-b border-white/30 pb-1">Collections</a>
            <a href="#" class="hover:text-white transition-colors">Haute Joaillerie</a>
        </nav>
    </header>

    @php
        // Fallback default lookbook arrangement if the column ever returns empty
        $sections = $collection->section_order ?? [
            ['type' => 'hero', 'layout' => 'full-cover', 'config' => []],
            ['type' => 'story-block', 'layout' => 'split-narrative', 'config' => ['alignment' => 'left']],
            ['type' => 'product-grid', 'layout' => 'editorial-feed', 'config' => []]
        ];
    @endphp

    @foreach($sections as $section)
        @php
            $folder = Str::plural($section['type']); // e.g. 'hero' becomes 'heroes'
            $layout = $section['layout'];           // e.g. 'full-cover'
            $config = $section['config'] ?? [];
        @endphp

        {{-- Dynamically resolve and inject the correct presentation layer blade component --}}
        <x-dynamic-component 
            :component="'collection.' . $folder . '.' . $layout"
            :config="$config"
            :collection="$collection"
            :products="$collection->products"
        />
    @endforeach

    <footer class="bg-neutral-950 py-12 border-t border-neutral-900 text-center space-y-4">
        <p class="text-xs uppercase tracking-[0.4em] text-neutral-500">Lumière Paris — Atelier d'Art</p>
    </footer>

</body>
</html>