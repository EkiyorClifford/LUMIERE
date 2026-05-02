<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ | LUMIÈRE Fine Jewelry</title>
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
    <style>
        :root { --gold: #C9A84C; --charcoal: #1C1C1C; }
        .faq-item {
            border-bottom: 1px solid rgba(28,28,28,0.08);
            transition: all 0.3s ease;
        }
        .faq-question {
            cursor: pointer;
            transition: color 0.2s ease;
        }
        .faq-question:hover {
            color: var(--gold);
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .faq-item.open .faq-answer {
            max-height: 300px;
        }
        .faq-item.open .faq-icon {
            transform: rotate(45deg);
        }
        .faq-icon {
            transition: transform 0.3s ease;
        }
    </style>
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
    <main class="max-w-3xl mx-auto px-6 py-16 md:py-24">
        <!-- Header -->
        <div class="text-center mb-16">
            <p class="text-soft-gold text-[10px] tracking-[0.4em] mb-4">GUIDANCE</p>
            <h1 class="font-playfair text-4xl md:text-5xl font-light text-charcoal mb-4">Frequently Asked Questions</h1>
            <div class="w-12 h-px bg-soft-gold mx-auto"></div>
        </div>

        <!-- FAQ List -->
        <div class="space-y-0">
            <!-- Q1 -->
            <div class="faq-item py-6 open">
                <div class="faq-question flex justify-between items-center">
                    <h3 class="font-playfair text-lg font-light">How long does shipping take?</h3>
                    <i class="fa-solid fa-plus faq-icon text-soft-gold text-sm"></i>
                </div>
                <div class="faq-answer pt-3">
                    <p class="text-warm-gray text-sm leading-relaxed">Standard shipping takes 5-7 business days internationally, 2-3 business days within the European Union. Bespoke commissions take 6-8 weeks from deposit to delivery. You'll receive tracking information via email once your order ships.</p>
                </div>
            </div>

            <!-- Q2 -->
            <div class="faq-item py-6">
                <div class="faq-question flex justify-between items-center">
                    <h3 class="font-playfair text-lg font-light">Do you offer gift wrapping?</h3>
                    <i class="fa-solid fa-plus faq-icon text-soft-gold text-sm"></i>
                </div>
                <div class="faq-answer pt-3">
                    <p class="text-warm-gray text-sm leading-relaxed">Yes, complimentary gift wrapping is available for all orders. Each piece arrives in our signature cream presentation box with a soft linen pouch. You may add a personalised handwritten message at checkout.</p>
                </div>
            </div>

            <!-- Q3 -->
            <div class="faq-item py-6">
                <div class="faq-question flex justify-between items-center">
                    <h3 class="font-playfair text-lg font-light">How do I know my ring size?</h3>
                    <i class="fa-solid fa-plus faq-icon text-soft-gold text-sm"></i>
                </div>
                <div class="faq-answer pt-3">
                    <p class="text-warm-gray text-sm leading-relaxed">We offer a complimentary ring sizer sent to your address upon request. Alternatively, you can visit any local jeweller for a professional measurement. Our size guide includes EU, US, and UK conversions.</p>
                </div>
            </div>

            <!-- Q4 -->
            <div class="faq-item py-6">
                <div class="faq-question flex justify-between items-center">
                    <h3 class="font-playfair text-lg font-light">What metals do you use?</h3>
                    <i class="fa-solid fa-plus faq-icon text-soft-gold text-sm"></i>
                </div>
                <div class="faq-answer pt-3">
                    <p class="text-warm-gray text-sm leading-relaxed">We exclusively use 18k yellow gold, 18k rose gold, 18k white gold, and platinum. All metals are ethically sourced and 100% recycled. Every piece is hallmarked at the Paris Assay Office.</p>
                </div>
            </div>

            <!-- Q5 -->
            <div class="faq-item py-6">
                <div class="faq-question flex justify-between items-center">
                    <h3 class="font-playfair text-lg font-light">Can I return or exchange a piece?</h3>
                    <i class="fa-solid fa-plus faq-icon text-soft-gold text-sm"></i>
                </div>
                <div class="faq-answer pt-3">
                    <p class="text-warm-gray text-sm leading-relaxed">Standard pieces may be returned within 14 days of delivery for a full refund or exchange. Bespoke commissions and engraved pieces are final sale. Please contact our concierge team to initiate a return.</p>
                </div>
            </div>

            <!-- Q6 -->
            <div class="faq-item py-6">
                <div class="faq-question flex justify-between items-center">
                    <h3 class="font-playfair text-lg font-light">Do you insure shipments?</h3>
                    <i class="fa-solid fa-plus faq-icon text-soft-gold text-sm"></i>
                </div>
                <div class="faq-answer pt-3">
                    <p class="text-warm-gray text-sm leading-relaxed">Yes, all shipments are fully insured against loss or damage. A signature is required upon delivery. For high-value pieces, we may require delivery to a verified address or DHL service point.</p>
                </div>
            </div>

            <!-- Q7 -->
            <div class="faq-item py-6">
                <div class="faq-question flex justify-between items-center">
                    <h3 class="font-playfair text-lg font-light">How do I care for my jewelry?</h3>
                    <i class="fa-solid fa-plus faq-icon text-soft-gold text-sm"></i>
                </div>
                <div class="faq-answer pt-3">
                    <p class="text-warm-gray text-sm leading-relaxed">We recommend gentle cleaning with lukewarm water, mild soap, and a soft cloth. Avoid exposure to chemicals, perfumes, and chlorine. Store pieces separately in the provided pouch. We offer complimentary professional cleaning annually.</p>
                </div>
            </div>

            <!-- Q8 -->
            <div class="faq-item py-6">
                <div class="faq-question flex justify-between items-center">
                    <h3 class="font-playfair text-lg font-light">Do you offer repairs?</h3>
                    <i class="fa-solid fa-plus faq-icon text-soft-gold text-sm"></i>
                </div>
                <div class="faq-answer pt-3">
                    <p class="text-warm-gray text-sm leading-relaxed">Yes, all Lumière pieces come with a lifetime care guarantee. We offer complimentary cleaning, prong tightening, and clasp repair. For more significant repairs, a modest service fee may apply.</p>
                </div>
            </div>

            <!-- Q9 -->
            <div class="faq-item py-6">
                <div class="faq-question flex justify-between items-center">
                    <h3 class="font-playfair text-lg font-light">What is the Gold Circle?</h3>
                    <i class="fa-solid fa-plus faq-icon text-soft-gold text-sm"></i>
                </div>
                <div class="faq-answer pt-3">
                    <p class="text-warm-gray text-sm leading-relaxed">Gold Circle is our loyalty programme for clients who have spent $15,000+ lifetime or completed a bespoke commission. Benefits include a dedicated Paris-based consultant, priority response within 4 hours, complimentary engraving, and first access to limited collections.</p>
                </div>
            </div>

            <!-- Q10 -->
            <div class="faq-item py-6">
                <div class="faq-question flex justify-between items-center">
                    <h3 class="font-playfair text-lg font-light">Can I visit the atelier in Paris?</h3>
                    <i class="fa-solid fa-plus faq-icon text-soft-gold text-sm"></i>
                </div>
                <div class="faq-answer pt-3">
                    <p class="text-warm-gray text-sm leading-relaxed">Our atelier in the 6th arrondissement is open by appointment only. Gold Circle members may request a private visit to view works-in-progress and meet the artisans. Please use our contact form to schedule a visit.</p>
                </div>
            </div>
        </div>

        <!-- Still have questions? -->
        <div class="mt-16 p-8 bg-deep-ivory text-center">
            <i class="fa-solid fa-envelope text-soft-gold text-2xl mb-3"></i>
            <h3 class="font-playfair text-xl font-light mb-2">Still have questions?</h3>
            <p class="text-warm-gray text-sm mb-5">Our concierge team is here to help.</p>
            <a href="/contact" class="inline-block border border-charcoal/30 px-8 py-2.5 text-[10px] tracking-[0.2em] hover:bg-charcoal hover:text-white transition-all duration-300">
                CONTACT US
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-charcoal/5 py-8 px-6 text-center">
        <p class="text-warm-gray/40 text-[9px] tracking-[0.2em]">© 2026 LUMIÈRE JEWELRY · PARIS</p>
    </footer>

    <script>
        document.querySelectorAll('.faq-item').forEach(item => {
            const question = item.querySelector('.faq-question');
            question.addEventListener('click', () => {
                item.classList.toggle('open');
            });
        });
    </script>
</body>
</html>