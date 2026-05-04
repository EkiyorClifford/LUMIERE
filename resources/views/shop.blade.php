<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shop - LUMIERE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300&family=Jost:wght@300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
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
            <a href="{{ route('shop') }}" class="text-[#C9A84C]">SHOP</a>
            <a href="{{ route('atelier') }}" class="text-black/60 hover:text-[#C9A84C]">ATELIER</a>
        </div>
        <div class="flex items-center gap-5">
            <button class="text-black/60 hover:text-[#C9A84C] transition-colors">
                <i class="fa-regular fa-heart text-base"></i>
            </button>
            @auth
                <div class="relative group">
                    <button class="text-black/60 hover:text-[#C9A84C] transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-user text-base"></i>
                        <span class="text-xs hidden md:block">{{ auth()->user()->name }}</span>
                    </button>
                    @if(auth()->user()->is_gold_circle)
                        <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-[#C9A84C]"></span>
                    @endif
                    <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-sm opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="#" class="block px-4 py-3 text-xs text-black/70 hover:text-[#C9A84C] hover:bg-[#F9F6F0] transition-colors">My Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-xs text-black/70 hover:text-[#C9A84C] hover:bg-[#F9F6F0] transition-colors">Sign Out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-black/60 hover:text-[#C9A84C] transition-colors">
                    <i class="fa-regular fa-user text-base"></i>
                </a>
            @endif
            <button onclick="toggleCart()" class="text-black/60 hover:text-[#C9A84C] transition-colors relative">
                <i class="fa-solid fa-cart-shopping text-base"></i>
                <span id="cart-count" class="absolute -top-1 -right-1.5 w-3.5 h-3.5 rounded-full bg-[#C9A84C] text-white text-[8px] flex items-center justify-center">0</span>
            </button>
        </div>
    </nav>

    <!-- Cart Drawer -->
    <div id="cart-overlay" class="fixed inset-0 bg-black/50 hidden opacity-0 transition-opacity duration-300 z-40" onclick="toggleCart()"></div>
    <div id="cart-drawer" class="fixed top-0 right-0 w-96 h-full bg-white shadow-lg transform translate-x-full transition-transform duration-300 z-50">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-playfair text-xl">Your Cart</h2>
                <button onclick="toggleCart()" class="text-black/60 hover:text-[#C9A84C]">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div id="cart-items" class="space-y-4">
                <!-- Cart items will be loaded here -->
            </div>
            <div class="mt-6 pt-6 border-t border-black/10">
                <a href="{{ route('cart.index') }}" class="w-full bg-[#C9A84C] text-white py-3 text-center block hover:bg-[#B8953A] transition-colors">
                    VIEW CART
                </a>
            </div>
        </div>
    </div>

    <header class="px-6 md:px-12 pt-10 pb-14">
        <div class="max-w-screen-xl mx-auto">
            <p class="text-[#C9A84C] text-[10px] tracking-[0.35em] mb-5">FINE JEWELRY</p>
            <h1 class="font-playfair text-5xl md:text-7xl font-light leading-none">Shop the House</h1>
            <p class="mt-6 max-w-xl text-sm leading-7 text-black/55 font-light">
                Diamonds, gold, pearls, and bespoke-feeling signatures selected from the Lumiere catalog.
            </p>
        </div>
    </header>

    <main class="px-6 md:px-12 pb-24">
        <div class="max-w-screen-xl mx-auto">
            <form action="{{ route('shop') }}" method="GET" class="bg-white/50 border border-black/5 p-5 md:p-6 mb-12">
                <div class="grid md:grid-cols-4 gap-4">
                    <label class="block">
                        <span class="block text-[9px] tracking-[0.22em] text-black/40 mb-2">CATEGORY</span>
                        <select name="category" class="w-full bg-transparent border border-black/10 px-4 py-3 text-[11px] tracking-[0.14em] text-black/65">
                            <option value="">All categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected($activeCategory === $category->slug)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="block text-[9px] tracking-[0.22em] text-black/40 mb-2">COLLECTION</span>
                        <select name="collection" class="w-full bg-transparent border border-black/10 px-4 py-3 text-[11px] tracking-[0.14em] text-black/65">
                            <option value="">All collections</option>
                            @foreach ($collections as $collection)
                                <option value="{{ $collection->slug }}" @selected(($filters['collection'] ?? '') === $collection->slug)>{{ $collection->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="block text-[9px] tracking-[0.22em] text-black/40 mb-2">PRICE RANGE</span>
                        <select name="price_max" class="w-full bg-transparent border border-black/10 px-4 py-3 text-[11px] tracking-[0.14em] text-black/65">
                            <option value="">Any price</option>
                            <option value="1000" @selected(($filters['price_max'] ?? '') === '1000')>Under $1,000</option>
                            <option value="2500" @selected(($filters['price_max'] ?? '') === '2500')>Under $2,500</option>
                            <option value="5000" @selected(($filters['price_max'] ?? '') === '5000')>Under $5,000</option>
                            <option value="10000" @selected(($filters['price_max'] ?? '') === '10000')>Under $10,000</option>
                        </select>
                    </label>

                    <div class="flex items-end gap-3">
                        <button type="submit" class="flex-1 bg-[#1C1C1C] text-white px-5 py-3 text-[10px] tracking-[0.22em] hover:bg-[#C9A84C] transition-colors">FILTER</button>
                        <a href="{{ route('shop') }}" class="px-5 py-3 border border-black/10 text-[10px] tracking-[0.2em] text-black/45 hover:text-[#C9A84C]">RESET</a>
                    </div>
                </div>
            </form>

            @if ($products->isEmpty())
                <div class="bg-white/40 border border-black/5 px-8 py-12 text-center">
                    <p class="font-cormorant italic text-2xl text-black/60">No pieces are available in this category yet.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-7">
                    @foreach ($products as $product)
                        <div class="group">
                            <a href="{{ route('product.show', $product) }}">
                                <div class="aspect-[3/4] bg-[#F2EDE4] overflow-hidden mb-4">
                                    <img src="{{ $product->primaryImage?->image_path ?? 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=1200&auto=format&fit=crop' }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </div>
                                <p class="text-[#C9A84C] text-[10px] tracking-[0.25em] mb-2">{{ strtoupper($product->collection?->name ?? $product->category) }}</p>
                                <h2 class="font-playfair text-xl font-light">{{ $product->name }}</h2>
                                <p class="text-sm text-black/50 mt-1">{{ ucfirst($product->category) }}</p>
                                <p class="font-playfair text-lg mt-3">${{ number_format((float) $product->price) }}</p>
                            </a>
                            <button onclick="addToCart({{ $product->id }}, null, 1)" class="w-full mt-4 bg-[#C9A84C] text-white py-2 text-sm font-light hover:bg-[#B8953A] transition-colors">
                                ADD TO CART
                            </button>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-16">
                    <a href="{{ route('sur-mesure') }}" class="inline-block border border-[#1C1C1C] px-9 py-4 text-[10px] tracking-[0.24em] text-[#1C1C1C] hover:bg-[#1C1C1C] hover:text-white transition-colors">
                        REQUEST A BESPOKE COMMISSION
                    </a>
                </div>
            @endif
        </div>
    </main>

    <section class="bg-[#1C1C1C] px-6 md:px-12 py-16 text-center">
        <p class="text-[#C9A84C] text-[10px] tracking-[0.35em] mb-4">INNER CIRCLE</p>
        <h2 class="font-playfair text-3xl font-light text-white mb-6">Stay Close to the Atelier</h2>
        <form action="{{ route('newsletter') }}" method="POST" class="max-w-sm mx-auto">
            @csrf
            <input type="hidden" name="source" value="newsletter_footer">
            <div class="flex border-b border-white/20">
                <input type="email" name="email" required placeholder="Your email address" class="flex-1 bg-transparent py-3 text-sm text-white placeholder:text-white/35 outline-none">
                <button type="submit" class="text-[#C9A84C] text-[10px] tracking-[0.22em] pl-4">SUBSCRIBE</button>
            </div>
        </form>
    </section>

    @include('partials.cart-drawer')

    <script>
        function toggleCart() {
            const drawer = document.getElementById('cart-drawer');
            const overlay = document.getElementById('cart-overlay');
            drawer.classList.toggle('translate-x-full');
            overlay.classList.toggle('hidden');
            setTimeout(() => overlay.classList.toggle('opacity-100'), 10);
            loadCart();
        }

        function addToCart(productId, variantId, quantity) {
            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId, variant_id: variantId, quantity: quantity })
            }).then(response => response.json()).then(data => {
                alert(data.message);
                updateCartCount();
            }).catch(error => console.error('Error:', error));
        }

        function loadCart() {
            fetch('/api/cart')
            .then(response => response.json())
            .then(data => {
                const cartItems = document.getElementById('cart-items');
                cartItems.innerHTML = '';
                data.items.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'flex items-center justify-between py-4 border-b border-black/10';
                    itemDiv.innerHTML = `
                        <div class="flex items-center">
                            <img src="${item.product.primaryImage?.image_path || 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=1200&auto=format&fit=crop'}" alt="${item.product.name}" class="w-16 h-16 object-cover mr-4">
                            <div>
                                <p class="font-playfair text-sm">${item.product.name}</p>
                                <p class="text-xs text-black/50">Qty: ${item.quantity}</p>
                            </div>
                        </div>
                        <p class="font-playfair text-sm">$${item.product.price * item.quantity}</p>
                    `;
                    cartItems.appendChild(itemDiv);
                });
            });
        }

        function updateCartCount() {
            fetch('/api/cart')
            .then(response => response.json())
            .then(data => {
                const count = data.items.reduce((sum, item) => sum + item.quantity, 0);
                document.getElementById('cart-count').textContent = count;
            });
        }

        window.onload = updateCartCount;
    </script>
</body>
</html>
