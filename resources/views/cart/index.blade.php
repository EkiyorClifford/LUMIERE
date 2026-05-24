<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cart - LUMIERE</title>
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
                        <a href="{{ route('profile.show') }}" class="block px-4 py-3 text-xs text-black/70 hover:text-[#C9A84C] hover:bg-[#F9F6F0] transition-colors">My Profile</a>
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

    <main class="px-6 md:px-12 py-16">
        <div class="max-w-4xl mx-auto">
            <h1 class="font-playfair text-4xl font-light mb-12">Your Cart</h1>

            @if($items->isEmpty())
                <div class="text-center py-16">
                    <p class="font-cormorant italic text-2xl text-black/60">Your cart is empty.</p>
                    <a href="{{ route('shop') }}" class="inline-block mt-8 bg-[#C9A84C] text-white px-8 py-3 hover:bg-[#B8953A] transition-colors">CONTINUE SHOPPING</a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($items as $item)
                        <div class="flex items-center justify-between bg-white/50 p-6 border border-black/5">
                            <div class="flex items-center">
                                <img src="{{ $item->product->primaryImage?->image_url ?? 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=1200&auto=format&fit=crop' }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover mr-6">
                                <div>
                                    <h2 class="font-playfair text-xl">{{ $item->product->name }}</h2>
                                    <p class="text-sm text-black/50">{{ $item->product->category }}</p>
                                    <p class="font-playfair text-lg mt-2">€{{ number_format((float) $item->product->price) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <form method="POST" action="{{ route('api.cart.quantity', ['item' => $item->id]) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 text-center border border-black/20 px-2 py-1">
                                    <button type="submit" class="text-[#C9A84C] hover:text-[#B8953A]">Update</button>
                                </form>
                                <form method="POST" action="{{ route('api.cart.destroy', ['item' => $item->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-right">
                    <p class="font-playfair text-2xl">Total: €{{ number_format($items->sum(fn($item) => $item->product->price * $item->quantity)) }}</p>
                    <a href="{{ route('checkout.create') }}" class="inline-block mt-6 bg-[#C9A84C] text-white px-8 py-3 hover:bg-[#B8953A] transition-colors">PROCEED TO CHECKOUT</a>
                </div>
            @endif
        </div>
    </main>

    <script>
        function toggleCart() {
            const drawer = document.getElementById('cart-drawer');
            const overlay = document.getElementById('cart-overlay');
            drawer.classList.toggle('translate-x-full');
            overlay.classList.toggle('hidden');
            setTimeout(() => overlay.classList.toggle('opacity-100'), 10);
            loadCart();
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
                            <img src="${item.product.primaryImage?.image_url || 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=1200&auto=format&fit=crop'}" alt="${item.product.name}" class="w-16 h-16 object-cover mr-4">
                            <div>
                                <p class="font-playfair text-sm">${item.product.name}</p>
                                <p class="text-xs text-black/50">Qty: ${item.quantity}</p>
                            </div>
                        </div>
                        <p class="font-playfair text-sm">€${item.product.price * item.quantity}</p>
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