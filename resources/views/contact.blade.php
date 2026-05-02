<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - LUMIERE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,300&family=Jost:wght@300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: Jost, sans-serif; }
        .font-playfair { font-family: "Playfair Display", serif; }
        .font-cormorant { font-family: "Cormorant Garamond", serif; }
    </style>
</head>
<body class="bg-[#F9F6F0] text-[#1C1C1C]">
    <nav class="px-6 md:px-12 py-6 flex items-center justify-between">
        <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-[0.25em]">LUMIERE</a>
        <div class="hidden md:flex gap-8 text-[11px] tracking-[0.22em]">
            <a href="{{ route('collections') }}" class="text-black/60 hover:text-[#C9A84C]">COLLECTIONS</a>
            <a href="{{ route('shop') }}" class="text-black/60 hover:text-[#C9A84C]">SHOP</a>
            <a href="{{ route('atelier') }}" class="text-black/60 hover:text-[#C9A84C]">ATELIER</a>
        </div>
    </nav>

    <main class="px-6 md:px-12 py-16">
        <section class="max-w-3xl mx-auto bg-white/60 border border-black/5 p-8 md:p-12">
            <p class="text-[#C9A84C] text-[10px] tracking-[0.35em] mb-5">CONCIERGE</p>
            <h1 class="font-playfair text-4xl md:text-6xl font-light mb-4">Contact Us</h1>
            <p class="text-black/55 text-sm leading-7 font-light mb-10">Send a note to our atelier team. A real person will reply within 24 hours.</p>

            @if (session('status'))
                <div class="bg-[#F2EDE4] border border-[#C9A84C]/20 px-5 py-4 text-sm text-black/65 mb-8">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('concierge-requests.store') }}" method="POST" class="space-y-7">
                @csrf
                <input type="hidden" name="source" value="contact_page">

                <div class="grid md:grid-cols-2 gap-7">
                    <label class="block">
                        <span class="block text-[10px] tracking-[0.22em] text-black/45 mb-2">NAME</span>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-transparent border-0 border-b border-black/15 px-0 py-3 text-sm focus:ring-0 focus:border-[#C9A84C]">
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </label>
                    <label class="block">
                        <span class="block text-[10px] tracking-[0.22em] text-black/45 mb-2">EMAIL</span>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-transparent border-0 border-b border-black/15 px-0 py-3 text-sm focus:ring-0 focus:border-[#C9A84C]">
                        @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </label>
                </div>

                <label class="block">
                    <span class="block text-[10px] tracking-[0.22em] text-black/45 mb-2">SUBJECT</span>
                    <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full bg-transparent border-0 border-b border-black/15 px-0 py-3 text-sm focus:ring-0 focus:border-[#C9A84C]">
                    @error('subject') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="block text-[10px] tracking-[0.22em] text-black/45 mb-2">MESSAGE</span>
                    <textarea name="message" rows="6" required class="w-full bg-transparent border-0 border-b border-black/15 px-0 py-3 text-sm focus:ring-0 focus:border-[#C9A84C] resize-none">{{ old('message') }}</textarea>
                    @error('message') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </label>

                <button type="submit" class="w-full bg-[#1C1C1C] text-white py-4 text-[10px] tracking-[0.25em] hover:bg-[#C9A84C] transition-colors">SEND MESSAGE</button>
            </form>
        </section>
    </main>
</body>
</html>
