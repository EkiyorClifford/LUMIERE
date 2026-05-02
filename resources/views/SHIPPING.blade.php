<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping | LUMIÈRE Fine Jewelry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F9F6F0',
                        'soft-gold': '#C9A84C',
                        charcoal: '#1C1C1C',
                        'warm-gray': '#8A8580',
                        'deep-ivory': '#F2EDE4',
                    },
                    fontFamily: {
                        'playfair': ['"Playfair Display"', 'serif'],
                        'jost': ['Jost', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@200;300;400;500&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-cream font-jost text-charcoal">

    <!-- Simple Nav -->
    <nav class="py-5 px-6 md:px-12 bg-cream/90 border-b border-charcoal/5">
        <div class="max-w-screen-xl mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal hover:text-soft-gold transition">LUMIÈRE</a>
            <div class="hidden md:flex items-center gap-10 text-[10px] tracking-[0.2em] uppercase">
                <a href="{{ route('collections') }}" class="text-charcoal/60 hover:text-charcoal transition-colors">Collections</a>
                <a href="{{ route('shop') }}" class="text-charcoal/60 hover:text-charcoal transition-colors">Shop</a>
                <a href="{{ route('atelier') }}" class="text-charcoal/60 hover:text-charcoal transition-colors">Atelier</a>
            </div>
        </div>
    </nav>

    <!-- Main -->
    <main class="max-w-4xl mx-auto px-6 py-16 md:py-24">
        <!-- Header -->
        <div class="text-center mb-16">
            <p class="text-soft-gold text-[10px] tracking-[0.4em] mb-4">DELIVERY</p>
            <h1 class="font-playfair text-4xl md:text-5xl font-light text-charcoal mb-4">Shipping Information</h1>
            <div class="w-12 h-px bg-soft-gold mx-auto"></div>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
            <!-- Left Column -->
            <div>
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-clock text-soft-gold text-xl"></i>
                        <h2 class="font-playfair text-xl font-light">Processing Time</h2>
                    </div>
                    <p class="text-warm-gray text-sm leading-relaxed mb-3">Standard pieces ship within <span class="text-charcoal font-medium">3-5 business days</span> of order confirmation.</p>
                    <p class="text-warm-gray text-sm leading-relaxed">Bespoke commissions require <span class="text-charcoal font-medium">6-8 weeks</span> from deposit to delivery. You will receive progress updates throughout the process.</p>
                </div>

                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-truck-fast text-soft-gold text-xl"></i>
                        <h2 class="font-playfair text-xl font-light">Shipping Methods</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-charcoal/5">
                            <div>
                                <p class="text-sm font-medium">DHL Express</p>
                                <p class="text-[11px] text-warm-gray">Tracked & Insured</p>
                            </div>
                            <p class="text-sm">3-5 business days</p>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-charcoal/5">
                            <div>
                                <p class="text-sm font-medium">FedEx Priority</p>
                                <p class="text-[11px] text-warm-gray">Tracked & Insured</p>
                            </div>
                            <p class="text-sm">2-3 business days</p>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-charcoal/5">
                            <div>
                                <p class="text-sm font-medium">White Glove Service</p>
                                <p class="text-[11px] text-warm-gray">For purchases over $25,000</p>
                            </div>
                            <p class="text-sm">In-person delivery</p>
                        </div>
                    </div>
                </div>

                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-hand-holding-heart text-soft-gold text-xl"></i>
                        <h2 class="font-playfair text-xl font-light">Complimentary Services</h2>
                    </div>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 text-sm text-warm-gray"><i class="fa-solid fa-check text-soft-gold text-[10px]"></i> Insurance included on all shipments</li>
                        <li class="flex items-center gap-2 text-sm text-warm-gray"><i class="fa-solid fa-check text-soft-gold text-[10px]"></i> Signature required upon delivery</li>
                        <li class="flex items-center gap-2 text-sm text-warm-gray"><i class="fa-solid fa-check text-soft-gold text-[10px]"></i> Gift wrapping and presentation box included</li>
                        <li class="flex items-center gap-2 text-sm text-warm-gray"><i class="fa-solid fa-check text-soft-gold text-[10px]"></i> Real-time tracking via email and SMS</li>
                    </ul>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-globe text-soft-gold text-xl"></i>
                        <h2 class="font-playfair text-xl font-light">International Shipping</h2>
                    </div>
                    <p class="text-warm-gray text-sm leading-relaxed mb-4">We ship worldwide from our Paris atelier. All duties, taxes, and customs fees are the responsibility of the customer.</p>
                    <div class="bg-deep-ivory p-4">
                        <p class="text-[10px] font-jost text-charcoal/60 leading-relaxed">
                            <i class="fa-solid fa-circle-info text-soft-gold mr-1"></i>
                            Estimated delivery times do not include customs clearance. Some countries may require additional documentation for high-value shipments.
                        </p>
                    </div>
                </div>

                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-shield-halved text-soft-gold text-xl"></i>
                        <h2 class="font-playfair text-xl font-light">Insurance & Security</h2>
                    </div>
                    <p class="text-warm-gray text-sm leading-relaxed mb-3">Every shipment is fully insured for the full value of the piece. In the unlikely event of loss or damage, we will replace or repair the item at no cost.</p>
                    <p class="text-warm-gray text-sm leading-relaxed">All packages require a signature upon delivery. For your security, we cannot deliver to P.O. boxes or unverified addresses.</p>
                </div>

                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-rotate-right text-soft-gold text-xl"></i>
                        <h2 class="font-playfair text-xl font-light">Tracking Your Order</h2>
                    </div>
                    <p class="text-warm-gray text-sm leading-relaxed mb-3">Once your order ships, you will receive a confirmation email with:</p>
                    <ul class="space-y-2 list-disc pl-5 text-warm-gray text-sm">
                        <li>Tracking number and carrier link</li>
                        <li>Estimated delivery window</li>
                        <li>SMS updates (if phone number provided)</li>
                    </ul>
                </div>

                <div class="p-5 border border-soft-gold/20 bg-soft-gold/5">
                    <div class="flex gap-3">
                        <i class="fa-solid fa-crown text-soft-gold text-xl"></i>
                        <div>
                            <p class="font-playfair text-sm font-light mb-1">Gold Circle Members</p>
                            <p class="text-[11px] text-warm-gray leading-relaxed">Enjoy complimentary express shipping on all orders. Bespoke commissions receive white glove delivery coordination.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="mt-16 text-center">
            <p class="text-warm-gray text-sm mb-5">Questions about your shipment?</p>
            <a href="/contact" class="inline-block border border-charcoal/30 px-8 py-3 text-[11px] tracking-[0.2em] hover:bg-charcoal hover:text-white transition-all duration-300">
                CONTACT OUR CONCIERGE
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-charcoal/5 py-8 px-6 text-center mt-12">
        <p class="text-warm-gray/40 text-[9px] tracking-[0.2em]">© 2026 LUMIÈRE JEWELRY · PARIS</p>
    </footer>
</body>
</html>