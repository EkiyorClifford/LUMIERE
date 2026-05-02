<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'Espace | LUMIÈRE Private Suite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { cream: '#F9F6F0', 'soft-gold': '#C9A84C', charcoal: '#1C1C1C', 'warm-gray': '#8A8580', 'deep-ivory': '#F2EDE4' },
                    fontFamily: { 'playfair': ['"Playfair Display"', 'serif'], 'jost': ['Jost', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Jost:wght@200;300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --gold: #C9A84C; --charcoal: #1C1C1C; --cream: #F9F6F0; }

        .vault-card:hover .vault-img { transform: scale(1.05); }
        .vault-img { transition: transform 0.5s cubic-bezier(0.25,0.46,0.45,0.94); }

        .status-badge { padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.7rem; letter-spacing: 0.05em; }
        .status-shipped { background: rgba(201,168,76,0.12); color: #C9A84C; }
        .status-processing { background: rgba(28,28,28,0.08); color: #8A8580; }

        .gold-circle-border { border-left: 3px solid var(--gold); }

        /* Sidebar nav active + hover */
        .side-nav a {
            position: relative;
            transition: color 0.2s;
        }
        .side-nav a.active { color: var(--gold); }
        .side-nav a:not(.active):hover { color: var(--charcoal); }

        /* Back to shop link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: rgba(28,28,28,0.35);
            font-size: 0.6rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            transition: color 0.2s;
            font-family: 'Jost', sans-serif;
        }
        .back-link:hover { color: var(--gold); }

        /* Consultant card */
        .consultant-avatar {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: rgba(201,168,76,0.12);
            border: 1px solid rgba(201,168,76,0.25);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* Recommendation hover */
        .rec-card .rec-img { transition: transform 0.5s cubic-bezier(0.25,0.46,0.45,0.94); }
        .rec-card:hover .rec-img { transform: scale(1.05); }

        /* Standard member consultant fallback */
        .support-card {
            border: 1px solid rgba(28,28,28,0.07);
            padding: 1.25rem 1.5rem;
        }
    </style>
</head>
<body class="bg-cream font-jost text-charcoal">

    <!-- NAV -->
    <nav class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12 bg-cream/90 backdrop-blur-sm border-b border-charcoal/5">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">
            <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal">LUMIÈRE</a>
            <div class="hidden md:flex items-center gap-10 text-[10px] tracking-[0.2em] uppercase">
                <a href="{{ route('collections') }}" class="text-charcoal/60 hover:text-charcoal transition-colors">Collections</a>
                <a href="{{ route('shop') }}" class="text-charcoal/60 hover:text-charcoal transition-colors">Shop</a>
                <a href="{{ route('atelier') }}" class="text-charcoal/60 hover:text-charcoal transition-colors">Atelier</a>
                <a href="#" class="text-charcoal border-b border-soft-gold pb-0.5">L'Espace</a>
            </div>
            <!-- Mobile: back to shop -->
            <a href="{{ route('shop') }}" class="md:hidden back-link">
                <i class="fa-solid fa-arrow-left text-[9px]"></i> SHOP
            </a>
        </div>
    </nav>


    <div class="pt-32 pb-20 px-6 max-w-screen-xl mx-auto flex flex-col lg:flex-row gap-12 xl:gap-20">

        <!-- SIDEBAR -->
        <aside class="w-full lg:w-64 space-y-8 flex-shrink-0">

            <!-- Back to shop — desktop only, subtle -->
            <a href="{{ route('shop') }}" class="back-link hidden md:inline-flex">
                <i class="fa-solid fa-arrow-left text-[9px]"></i> BACK TO SHOP
            </a>

            <div class="border-b border-charcoal/10 pb-6">
                <p class="text-warm-gray text-[9px] tracking-[0.2em] uppercase mb-2">Bienvenue,</p>
                <h1 class="font-playfair text-3xl">Julianne</h1>
                <div class="mt-3 inline-flex items-center gap-2 bg-soft-gold/10 px-3 py-1.5 rounded-full">
                    <i class="fa-solid fa-crown text-soft-gold text-[10px]"></i>
                    <span class="text-[9px] tracking-[0.15em] font-jost text-charcoal/70">GOLD CIRCLE MEMBER</span>
                </div>
            </div>

            <nav class="side-nav flex flex-col gap-5 text-[10px] tracking-[0.3em] uppercase">
                <a href="#dashboard" class="active">Dashboard</a>
                <a href="#vault" class="text-charcoal/40">The Vault</a>
                <a href="#orders" class="text-charcoal/40">Orders & Shipments</a>
                <a href="#commissions" class="text-charcoal/40">Bespoke Commissions</a>
                <a href="#wishlist" class="text-charcoal/40">Wishlist</a>
                <a href="#profile" class="text-charcoal/40">Profile</a>
                <a href="#" class="text-charcoal/40 mt-6">Logout</a>
            </nav>
        </aside>


        <!-- MAIN -->
        <main class="flex-1 space-y-16" id="dashboard">

            <!-- ─── CONSULTANT CARD ─── -->
            <section class="flex flex-col md:flex-row gap-8 p-6 bg-deep-ivory">
                <div class="flex-1">
                    <p class="text-soft-gold text-[9px] tracking-[0.2em] uppercase mb-2">Your Personal Consultant</p>
                    <h2 class="font-playfair text-xl mb-3">Isabelle Fournier</h2>
                    <p class="text-warm-gray text-xs font-light leading-relaxed mb-4">
                        Available to assist with any question — from sizing to bespoke commissions. Gold Circle members receive priority response within 4 hours during Paris business hours.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="mailto:isabelle.fournier@lumiere.com" class="text-[10px] tracking-[0.15em] text-soft-gold border-b border-soft-gold/30 pb-0.5 hover:border-soft-gold transition-all">EMAIL ISABELLE</a>
                        <a href="tel:+33140000000" class="text-[10px] tracking-[0.15em] text-soft-gold border-b border-soft-gold/30 pb-0.5 hover:border-soft-gold transition-all">CALL +33 1 40 00 00 00</a>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <div class="consultant-avatar">
                        <i class="fa-solid fa-user text-2xl text-charcoal/20"></i>
                    </div>
                    <p class="text-[8px] text-warm-gray/50 font-jost mt-2 text-center">Paris · GMT+2</p>
                </div>
            </section>


            <!-- ─── THE VAULT ─── -->
            <section id="vault">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-playfair text-xl">The Vault</h2>
                    <a href="#" class="text-[9px] tracking-[0.15em] text-soft-gold hover:underline">VIEW ALL</a>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white p-5 flex gap-5 group vault-card">
                        <div class="w-24 h-24 bg-deep-ivory overflow-hidden flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=400&auto=format&fit=crop" class="vault-img w-full h-full object-cover" alt="Celestial Ring">
                        </div>
                        <div class="flex-1">
                            <h3 class="font-playfair text-base mb-0.5">Celestial Ring</h3>
                            <p class="text-[9px] text-warm-gray font-jost mb-2">Sapphire & Diamond · 18k White Gold</p>
                            <p class="text-[8px] font-mono text-charcoal/40 mb-3">SN: LM-CR-8842-01</p>
                            <div class="flex gap-4">
                                <a href="#" class="text-[9px] tracking-[0.1em] text-soft-gold hover:underline">VIEW CERTIFICATE →</a>
                                <a href="#" class="text-[9px] tracking-[0.1em] text-charcoal/40 hover:text-charcoal transition-colors">CARE GUIDE</a>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-5 flex gap-5 group vault-card">
                        <div class="w-24 h-24 bg-deep-ivory overflow-hidden flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=400&auto=format&fit=crop" class="vault-img w-full h-full object-cover" alt="Solitaire Pendant">
                        </div>
                        <div class="flex-1">
                            <h3 class="font-playfair text-base mb-0.5">Solitaire Pendant</h3>
                            <p class="text-[9px] text-warm-gray font-jost mb-2">Diamond · 18k Yellow Gold</p>
                            <p class="text-[8px] font-mono text-charcoal/40 mb-3">SN: LM-SP-7123-02</p>
                            <div class="flex gap-4">
                                <a href="#" class="text-[9px] tracking-[0.1em] text-soft-gold hover:underline">VIEW CERTIFICATE →</a>
                                <a href="#" class="text-[9px] tracking-[0.1em] text-charcoal/40 hover:text-charcoal transition-colors">CARE GUIDE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ─── ACTIVE ORDERS ─── -->
            <section id="orders">
                <h2 class="font-playfair text-xl mb-6">Active Orders</h2>
                <div class="bg-white border border-charcoal/5 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="border-b border-charcoal/5 text-[9px] tracking-widest uppercase text-warm-gray">
                            <tr>
                                <th class="p-5">Order ID</th>
                                <th class="p-5">Date</th>
                                <th class="p-5">Status</th>
                                <th class="p-5">Total</th>
                                <th class="p-5">Tracking</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs font-light">
                            <tr class="border-b border-charcoal/5">
                                <td class="p-5 font-mono text-[10px]">#LM-88902</td>
                                <td class="p-5">April 12, 2026</td>
                                <td class="p-5"><span class="status-badge status-shipped">SHIPPED</span></td>
                                <td class="p-5">$4,500.00</td>
                                <td class="p-5"><a href="#" class="text-[9px] text-soft-gold hover:underline">TRACK →</a></td>
                            </tr>
                            <tr>
                                <td class="p-5 font-mono text-[10px]">#LM-89123</td>
                                <td class="p-5">April 5, 2026</td>
                                <td class="p-5"><span class="status-badge status-processing">IN PRODUCTION</span></td>
                                <td class="p-5">$2,100.00</td>
                                <td class="p-5"><span class="text-[9px] text-warm-gray">Est. May 15</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>


            <!-- ─── BESPOKE COMMISSION TRACKER ─── -->
            <section id="commissions">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-playfair text-xl">Bespoke Commission</h2>
                    <a href="{{ route('bespoke') }}" class="text-[9px] tracking-[0.15em] text-soft-gold hover:underline">NEW COMMISSION</a>
                </div>
                <div class="bg-white p-6 gold-circle-border">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">
                        <div>
                            <p class="text-[9px] tracking-[0.2em] text-soft-gold uppercase mb-1">ACTIVE COMMISSION</p>
                            <h3 class="font-playfair text-lg">Custom Engagement Ring</h3>
                            <p class="text-warm-gray text-xs font-light mt-1">3.2ct Sapphire · 18k Rose Gold · Pavé Diamonds</p>
                        </div>
                        <div class="md:text-right flex-shrink-0">
                            <p class="text-[10px] font-jost text-charcoal">Expected: <span class="font-medium">June 12, 2026</span></p>
                            <p class="text-[9px] text-soft-gold mt-1">Stage 2 of 6: Wax Model Approved</p>
                        </div>
                    </div>
                    <!-- Progress bar -->
                    <div class="h-1 bg-charcoal/5 rounded-full overflow-hidden mb-3">
                        <div class="h-full bg-soft-gold rounded-full transition-all duration-700" style="width: 33%;"></div>
                    </div>
                    <div class="flex justify-between text-[8px] tracking-[0.08em] text-warm-gray">
                        <span>Consult</span>
                        <span class="text-soft-gold font-medium">Design <i class="fa-solid fa-check text-[8px]"></i></span>
                        <span>Casting</span>
                        <span>Setting</span>
                        <span>QC</span>
                        <span>Delivery</span>
                    </div>
                </div>
            </section>


            <!-- ─── RECOMMENDATIONS ─── -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-playfair text-xl">Recommended for You</h2>
                    <span class="text-[8px] tracking-[0.15em] font-jost text-warm-gray/60">BASED ON YOUR COLLECTION</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="rec-card group cursor-pointer">
                        <div class="bg-deep-ivory aspect-square mb-2 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=400&auto=format&fit=crop" class="rec-img w-full h-full object-cover" alt="Signature Diamond Band">
                        </div>
                        <p class="text-[10px] font-playfair mb-0.5">Signature Diamond Band</p>
                        <p class="text-[9px] text-soft-gold">$4,500</p>
                    </div>
                    <div class="rec-card group cursor-pointer">
                        <div class="bg-deep-ivory aspect-square mb-2 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=400&auto=format&fit=crop" class="rec-img w-full h-full object-cover" alt="Knot Signet Ring">
                        </div>
                        <p class="text-[10px] font-playfair mb-0.5">Knot Signet Ring</p>
                        <p class="text-[9px] text-soft-gold">$1,850</p>
                    </div>
                    <div class="rec-card group cursor-pointer">
                        <div class="bg-deep-ivory aspect-square mb-2 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1602173574767-37ac01994b2a?q=80&w=400&auto=format&fit=crop" class="rec-img w-full h-full object-cover" alt="Diamond Halo Studs">
                        </div>
                        <p class="text-[10px] font-playfair mb-0.5">Diamond Halo Studs</p>
                        <p class="text-[9px] text-soft-gold">$1,680</p>
                    </div>
                    <div class="rec-card group cursor-pointer">
                        <div class="bg-deep-ivory aspect-square mb-2 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1619856699906-09e1f58c98a1?q=80&w=400&auto=format&fit=crop" class="rec-img w-full h-full object-cover" alt="Akoya Pearl Strand">
                        </div>
                        <p class="text-[10px] font-playfair mb-0.5">Akoya Pearl Strand</p>
                        <p class="text-[9px] text-soft-gold">$920</p>
                    </div>
                </div>
            </section>

        </main>
    </div>


    <footer class="bg-[#161616] pt-16 pb-8 px-6 mt-12">
        <div class="max-w-screen-xl mx-auto text-center text-white/20 text-[9px] tracking-[0.2em]">
            © 2026 LUMIÈRE &nbsp;·&nbsp; GOLD CIRCLE PRIVATE SUITE
        </div>
    </footer>


    <script>
        // Sidebar nav: highlight active section on scroll
        const sections = ['dashboard', 'vault', 'orders', 'commissions'];
        const navLinks = document.querySelectorAll('.side-nav a');

        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;
                    navLinks.forEach(link => {
                        const href = link.getAttribute('href').replace('#', '');
                        link.classList.toggle('active', href === id);
                        link.classList.toggle('text-charcoal/40', href !== id);
                    });
                }
            });
        }, { threshold: 0.4 });

        sections.forEach(id => {
            const el = document.getElementById(id);
            if (el) sectionObserver.observe(el);
        });
    </script>
</body>
</html>
