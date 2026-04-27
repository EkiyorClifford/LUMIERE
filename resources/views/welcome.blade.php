<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUMIÈRE | Fine Jewelry</title>
    <meta name="description" content="Timeless elegance. Handcrafted jewelry for the discerning soul.">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F9F6F0',
                        'soft-gold': '#D4AF37',
                        'warm-silver': '#C0C0C0',
                        'deep-ivory': '#F5F0E8',
                        'charcoal-light': '#2C2C2C',
                    },
                    fontFamily: {
                        'playfair': ['Playfair Display', 'serif'],
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'light': ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slow-zoom': 'slowZoom 20s ease-in-out infinite',
                        'gentle-float': 'gentleFloat 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slowZoom: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.05)' },
                        },
                        gentleFloat: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                    },
                }
            }
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom scrollbar for elegance */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #F5F0E8;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #D4AF37;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #B8962E;
        }
        
        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }
        
        /* Selection color */
        ::selection {
            background: #D4AF37;
            color: #1A1A1A;
        }
    </style>
</head>
<body class="bg-cream font-montserrat text-charcoal-light">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-200/50 transition-all duration-300">
        <div class="container mx-auto px-6 py-5">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="#" class="text-2xl font-playfair font-semibold tracking-wide text-gray-900 hover:text-soft-gold transition-colors duration-300">
                    LUMIÈRE
                </a>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-12">
                    <a href="#collections" class="text-sm font-light tracking-wide text-gray-700 hover:text-soft-gold transition-colors duration-300">Collections</a>
                    <a href="#shop" class="text-sm font-light tracking-wide text-gray-700 hover:text-soft-gold transition-colors duration-300">Shop</a>
                    <a href="#about" class="text-sm font-light tracking-wide text-gray-700 hover:text-soft-gold transition-colors duration-300">About</a>
                    <a href="#journal" class="text-sm font-light tracking-wide text-gray-700 hover:text-soft-gold transition-colors duration-300">Journal</a>
                </div>
                
                <!-- Icons -->
                <div class="flex space-x-5">
                    <button class="text-gray-700 hover:text-soft-gold transition-colors duration-300">
                        <i class="fa-regular fa-heart text-lg"></i>
                    </button>
                    <button class="text-gray-700 hover:text-soft-gold transition-colors duration-300">
                        <i class="fa-regular fa-user text-lg"></i>
                    </button>
                    <button class="text-gray-700 hover:text-soft-gold transition-colors duration-300">
                        <i class="fa-regular fa-bag-shopping text-lg"></i>
                    </button>
                    
                    <!-- Mobile menu button -->
                    <button class="md:hidden text-gray-700">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
        <!-- Background Image with subtle zoom -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1615634260167-c8cdede054de?q=80&w=2070&auto=format&fit=crop" 
                 alt="Elegant jewelry display" 
                 class="w-full h-full object-cover animate-slow-zoom">
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/40"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto animate-fade-in">
            <p class="text-white/80 tracking-[0.3em] text-xs mb-6 font-light">EST. 2024</p>
            <h1 class="font-playfair text-5xl md:text-7xl lg:text-8xl font-light text-white mb-6 tracking-wide">
                Timeless <span class="font-semibold">Elegance</span>
            </h1>
            <div class="w-20 h-px bg-soft-gold mx-auto my-8"></div>
            <p class="text-white/80 text-lg md:text-xl font-light max-w-2xl mx-auto leading-relaxed">
                Handcrafted jewelry that tells your story. Each piece, a celebration of life's most precious moments.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-5 justify-center">
                <a href="#collections" class="inline-block px-8 py-3 bg-transparent border border-white text-white hover:bg-white hover:text-gray-900 transition-all duration-300 tracking-wide text-sm font-light">
                    DISCOVER COLLECTION
                </a>
                <a href="#shop" class="inline-block px-8 py-3 bg-soft-gold text-white hover:bg-amber-600 transition-all duration-300 tracking-wide text-sm font-light">
                    SHOP NOW
                </a>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fa-regular fa-chevron-down text-white/60 text-xl"></i>
        </div>
    </section>

    <!-- Collections Section -->
    <section id="collections" class="py-24 px-6 bg-cream">
        <div class="container mx-auto">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <p class="text-soft-gold text-sm tracking-[0.2em] mb-3 font-light">OUR CURATIONS</p>
                <h2 class="font-playfair text-3xl md:text-4xl font-light text-gray-900 mb-4">Signature Collections</h2>
                <div class="w-16 h-px bg-soft-gold mx-auto mt-6 mb-6"></div>
                <p class="text-gray-600 font-light leading-relaxed">
                    Each collection tells a unique story of craftsmanship, love, and timeless beauty.
                </p>
            </div>
            
            <!-- Collection Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Collection 1 -->
                <div class="group cursor-pointer">
                    <div class="overflow-hidden bg-gray-100 rounded-lg">
                        <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=2187&auto=format&fit=crop" 
                             alt="Diamond Collection" 
                             class="w-full h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                    <div class="mt-6 text-center">
                        <h3 class="font-playfair text-xl font-light text-gray-900 mb-2">L'ÉCLAT</h3>
                        <p class="text-gray-500 text-sm font-light mb-3">Diamond Collection</p>
                        <p class="text-soft-gold text-xs tracking-wide">FROM $2,800</p>
                    </div>
                </div>
                
                <!-- Collection 2 -->
                <div class="group cursor-pointer">
                    <div class="overflow-hidden bg-gray-100 rounded-lg">
                        <img src="https://images.unsplash.com/photo-1602751584552-8ba73aad9250?q=80&w=2187&auto=format&fit=crop" 
                             alt="Gold Collection" 
                             class="w-full h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                    <div class="mt-6 text-center">
                        <h3 class="font-playfair text-xl font-light text-gray-900 mb-2">L'OR</h3>
                        <p class="text-gray-500 text-sm font-light mb-3">Gold Collection</p>
                        <p class="text-soft-gold text-xs tracking-wide">FROM $1,200</p>
                    </div>
                </div>
                
                <!-- Collection 3 -->
                <div class="group cursor-pointer">
                    <div class="overflow-hidden bg-gray-100 rounded-lg">
                        <img src="https://images.unsplash.com/photo-1619856699906-09e1f58c98a1?q=80&w=2070&auto=format&fit=crop" 
                             alt="Pearl Collection" 
                             class="w-full h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                    <div class="mt-6 text-center">
                        <h3 class="font-playfair text-xl font-light text-gray-900 mb-2">LA PERLE</h3>
                        <p class="text-gray-500 text-sm font-light mb-3">Pearl Collection</p>
                        <p class="text-soft-gold text-xs tracking-wide">FROM $900</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Piece - Hero Section Alternative -->
    <section class="py-24 px-6 bg-white">
        <div class="container mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="order-2 md:order-1">
                    <p class="text-soft-gold text-sm tracking-[0.2em] mb-4 font-light">LIMITED EDITION</p>
                    <h2 class="font-playfair text-3xl md:text-4xl font-light text-gray-900 mb-6">
                        The Lumière Signature Ring
                    </h2>
                    <div class="w-12 h-px bg-soft-gold mb-6"></div>
                    <p class="text-gray-600 leading-relaxed mb-6 font-light">
                        A masterpiece of Italian craftsmanship. Featuring a flawless 2-carat diamond set in ethically sourced 18k gold. Each ring is hand-engraved and takes over 40 hours to complete.
                    </p>
                    <div class="flex items-center gap-4 mb-8">
                        <span class="text-2xl font-light text-gray-900">$4,500</span>
                        <span class="text-sm text-gray-400 line-through">$5,800</span>
                    </div>
                    <a href="#" class="inline-block px-8 py-3 bg-gray-900 text-white hover:bg-soft-gold transition-all duration-300 tracking-wide text-sm font-light">
                        INQUIRE NOW
                    </a>
                </div>
                <div class="order-1 md:order-2 group">
                    <div class="overflow-hidden rounded-lg shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=2070&auto=format&fit=crop" 
                             alt="Signature Ring" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop Section -->
    <section id="shop" class="py-24 px-6 bg-cream">
        <div class="container mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <p class="text-soft-gold text-sm tracking-[0.2em] mb-3 font-light">BESTSELLERS</p>
                <h2 class="font-playfair text-3xl md:text-4xl font-light text-gray-900 mb-4">Treasures You'll Adore</h2>
                <div class="w-16 h-px bg-soft-gold mx-auto mt-6"></div>
            </div>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Product 1 -->
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden bg-gray-100 rounded-lg mb-4">
                        <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=1931&auto=format&fit=crop" 
                             alt="Diamond Necklace" 
                             class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300"></div>
                    </div>
                    <h3 class="font-playfair text-lg font-light text-gray-900 mb-1">Solitaire Pendant</h3>
                    <p class="text-gray-500 text-sm font-light mb-2">Diamond Necklace</p>
                    <p class="text-soft-gold text-sm">$1,250</p>
                </div>
                
                <!-- Product 2 -->
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden bg-gray-100 rounded-lg mb-4">
                        <img src="https://images.unsplash.com/photo-1603561591411-07134e719f5d?q=80&w=2070&auto=format&fit=crop" 
                             alt="Gold Earrings" 
                             class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <h3 class="font-playfair text-lg font-light text-gray-900 mb-1">Lotus Drop Earrings</h3>
                    <p class="text-gray-500 text-sm font-light mb-2">Gold with Pearl</p>
                    <p class="text-soft-gold text-sm">$890</p>
                </div>
                
                <!-- Product 3 -->
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden bg-gray-100 rounded-lg mb-4">
                        <img src="https://images.unsplash.com/photo-1589128777073-263566ae5e4d?q=80&w=2070&auto=format&fit=crop" 
                             alt="Bracelet" 
                             class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <h3 class="font-playfair text-lg font-light text-gray-900 mb-1">Infinity Bangle</h3>
                    <p class="text-gray-500 text-sm font-light mb-2">18k Gold</p>
                    <p class="text-soft-gold text-sm">$2,100</p>
                </div>
                
                <!-- Product 4 -->
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden bg-gray-100 rounded-lg mb-4">
                        <img src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=2188&auto=format&fit=crop" 
                             alt="Ring" 
                             class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <h3 class="font-playfair text-lg font-light text-gray-900 mb-1">Celestial Ring</h3>
                    <p class="text-gray-500 text-sm font-light mb-2">Sapphire & Diamond</p>
                    <p class="text-soft-gold text-sm">$3,450</p>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="#" class="inline-block px-8 py-3 border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white transition-all duration-300 tracking-wide text-sm font-light">
                    VIEW ALL COLLECTION
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 px-6 bg-gray-50">
        <div class="container mx-auto">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-soft-gold text-sm tracking-[0.2em] mb-4 font-light">OUR STORY</p>
                <h2 class="font-playfair text-3xl md:text-4xl font-light text-gray-900 mb-6">
                    Craftsmanship Passed Through Generations
                </h2>
                <div class="w-16 h-px bg-soft-gold mx-auto mb-8"></div>
                <p class="text-gray-600 leading-relaxed mb-6 font-light">
                    Founded in Paris, Lumière has been creating heirloom-quality jewelry since 2024. We believe that true luxury lies in the details — the cut of a diamond, the curve of a setting, the sparkle in a loved one's eye.
                </p>
                <p class="text-gray-600 leading-relaxed mb-8 font-light">
                    Every piece is ethically sourced and handcrafted by master artisans who share our passion for timeless elegance.
                </p>
                <a href="#" class="inline-block px-8 py-3 bg-soft-gold text-white hover:bg-amber-600 transition-all duration-300 tracking-wide text-sm font-light">
                    LEARN MORE ABOUT US
                </a>
            </div>
        </div>
    </section>

    <!-- Journal Section -->
    <section id="journal" class="py-24 px-6 bg-white">
        <div class="container mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <p class="text-soft-gold text-sm tracking-[0.2em] mb-3 font-light">FROM OUR JOURNAL</p>
                <h2 class="font-playfair text-3xl md:text-4xl font-light text-gray-900 mb-4">Stories & Inspiration</h2>
                <div class="w-16 h-px bg-soft-gold mx-auto mt-6"></div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Article 1 -->
                <div class="group cursor-pointer">
                    <div class="overflow-hidden bg-gray-100 rounded-lg mb-5">
                        <img src="https://images.unsplash.com/photo-1530968033775-2c92736b131e?q=80&w=2071&auto=format&fit=crop" 
                             alt="Diamond Guide" 
                             class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <p class="text-soft-gold text-xs tracking-wide mb-2">APRIL 25, 2026</p>
                    <h3 class="font-playfair text-xl font-light text-gray-900 mb-2">The Ultimate Diamond Buying Guide</h3>
                    <p class="text-gray-500 text-sm font-light leading-relaxed">
                        Everything you need to know before investing in your perfect diamond.
                    </p>
                </div>
                
                <!-- Article 2 -->
                <div class="group cursor-pointer">
                    <div class="overflow-hidden bg-gray-100 rounded-lg mb-5">
                        <img src="https://images.unsplash.com/photo-1582657050916-f91e9bd60ca1?q=80&w=1974&auto=format&fit=crop" 
                             alt="Sustainable Jewelry" 
                             class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <p class="text-soft-gold text-xs tracking-wide mb-2">APRIL 18, 2026</p>
                    <h3 class="font-playfair text-xl font-light text-gray-900 mb-2">Our Commitment to Sustainability</h3>
                    <p class="text-gray-500 text-sm font-light leading-relaxed">
                        How we're creating beautiful jewelry while protecting our planet.
                    </p>
                </div>
                
                <!-- Article 3 -->
                <div class="group cursor-pointer">
                    <div class="overflow-hidden bg-gray-100 rounded-lg mb-5">
                        <img src="https://images.unsplash.com/photo-1599643477877-530eb83abc8e?q=80&w=2070&auto=format&fit=crop" 
                             alt="Care Guide" 
                             class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <p class="text-soft-gold text-xs tracking-wide mb-2">APRIL 12, 2026</p>
                    <h3 class="font-playfair text-xl font-light text-gray-900 mb-2">Jewelry Care 101</h3>
                    <p class="text-gray-500 text-sm font-light leading-relaxed">
                        Tips to keep your precious pieces shining for generations.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-20 px-6 bg-gray-900">
        <div class="container mx-auto text-center max-w-2xl">
            <p class="text-soft-gold text-sm tracking-[0.2em] mb-4 font-light">NEWSLETTER</p>
            <h2 class="font-playfair text-3xl md:text-4xl font-light text-white mb-4">
                Join Our Inner Circle
            </h2>
            <div class="w-16 h-px bg-soft-gold mx-auto mb-6"></div>
            <p class="text-gray-300 font-light mb-8 leading-relaxed">
                Be the first to discover new collections, exclusive offers, and jewelry insights.
            </p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" 
                       placeholder="Your email address" 
                       class="flex-1 px-6 py-3 bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-soft-gold transition-colors duration-300 font-light">
                <button type="submit" class="px-8 py-3 bg-soft-gold text-white hover:bg-amber-600 transition-all duration-300 tracking-wide text-sm font-light">
                    SUBSCRIBE
                </button>
            </form>
            <p class="text-gray-500 text-xs mt-6 font-light">By subscribing, you agree to our Privacy Policy.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 pt-16 pb-8 px-6 border-t border-white/10">
        <div class="container mx-auto">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <h3 class="font-playfair text-2xl font-light text-white mb-4">LUMIÈRE</h3>
                    <p class="text-gray-400 text-sm font-light leading-relaxed">
                        Timeless elegance crafted for the discerning soul.
                    </p>
                </div>
                
                <div>
                    <h4 class="text-white text-sm font-semibold mb-4 tracking-wide">SHOP</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-soft-gold text-sm font-light transition-colors duration-300">Necklaces</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-soft-gold text-sm font-light transition-colors duration-300">Rings</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-soft-gold text-sm font-light transition-colors duration-300">Earrings</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-soft-gold text-sm font-light transition-colors duration-300">Bracelets</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white text-sm font-semibold mb-4 tracking-wide">SUPPORT</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-soft-gold text-sm font-light transition-colors duration-300">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-soft-gold text-sm font-light transition-colors duration-300">FAQs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-soft-gold text-sm font-light transition-colors duration-300">Shipping & Returns</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-soft-gold text-sm font-light transition-colors duration-300">Size Guide</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white text-sm font-semibold mb-4 tracking-wide">FOLLOW</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-soft-gold transition-colors duration-300 text-xl">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-soft-gold transition-colors duration-300 text-xl">
                            <i class="fa-brands fa-pinterest"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-soft-gold transition-colors duration-300 text-xl">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-soft-gold transition-colors duration-300 text-xl">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-white/10 pt-8 text-center">
                <p class="text-gray-500 text-xs font-light">&copy; 2025 Lumière Jewelry. All rights reserved. Crafted with elegance.</p>
            </div>
        </div>
    </footer>
</body>
</html>