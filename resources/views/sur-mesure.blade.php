<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bespoke | LUMIÈRE Fine Jewelry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { cream: '#F9F6F0', 'soft-gold': '#C9A84C', charcoal: '#1C1C1C', 'warm-gray': '#8A8580', 'deep-ivory': '#F2EDE4' },
                    fontFamily: { 'playfair': ['"Playfair Display"', 'serif'], 'cormorant': ['"Cormorant Garamond"', 'serif'], 'jost': ['Jost', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,300&family=Jost:wght@200;300;400&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --gold: #C9A84C; --charcoal: #1C1C1C; --cream: #F9F6F0; }

        .reveal { opacity: 0; transform: translateY(20px); transition: all 0.7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        input:not([type="checkbox"]):not([type="file"]), textarea, select {
            background: transparent !important;
            border-bottom: 1px solid rgba(28,28,28,0.12) !important;
            outline: none !important;
            transition: border-color 0.2s;
        }
        input:not([type="checkbox"]):not([type="file"]):focus,
        textarea:focus, select:focus { border-bottom-color: #C9A84C !important; }

        input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: #C9A84C;
            flex-shrink: 0;
            cursor: pointer;
        }

        .gold-circle-badge {
            background: rgba(201,168,76,0.08);
            border-left: 2px solid #C9A84C;
            padding: 0.75rem 1rem;
        }

        .timeline-step { position: relative; padding-left: 2rem; }
        .timeline-step::before {
            content: '';
            position: absolute; left: 0; top: 0.25rem;
            width: 8px; height: 8px;
            border-radius: 50%; background: #C9A84C;
        }
        .timeline-step:not(:last-child)::after {
            content: '';
            position: absolute; left: 3px; top: 1rem;
            width: 1px; height: calc(100% - 0.5rem);
            background: linear-gradient(to bottom, #C9A84C, transparent);
        }

        /* Gold Circle Modal */
        #gc-modal {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        #gc-modal.open { opacity: 1; pointer-events: all; }
        #gc-modal .modal-panel {
            transform: translateY(16px);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        #gc-modal.open .modal-panel { transform: translateY(0); }

        .gc-learn-link {
            color: var(--gold);
            border-bottom: 1px solid rgba(201,168,76,0.35);
            font-size: 0.6875rem;
            letter-spacing: 0.12em;
            cursor: pointer;
            transition: border-color 0.2s ease;
            background: none;
            padding: 0;
            font-family: 'Jost', sans-serif;
            font-weight: 300;
        }
        .gc-learn-link:hover { border-bottom-color: var(--gold); }

        .tier-card {
            border: 1px solid rgba(28,28,28,0.07);
            padding: 1.25rem 1.5rem;
            position: relative;
            transition: border-color 0.25s;
        }
        .tier-card.highlighted {
            border-color: var(--gold);
            background: rgba(201,168,76,0.04);
        }
        .tier-badge {
            position: absolute;
            top: -0.6rem; left: 1.25rem;
            background: var(--gold);
            color: #fff;
            font-size: 0.55rem;
            letter-spacing: 0.2em;
            padding: 0.2rem 0.6rem;
            font-family: 'Jost', sans-serif;
        }

        .upload-zone {
            border: 1px dashed rgba(28,28,28,0.15);
            transition: border-color 0.25s, background 0.25s;
            cursor: pointer;
        }
        .upload-zone:hover { border-color: var(--gold); background: rgba(201,168,76,0.03); }

        .btn-submit {
            position: relative;
            overflow: hidden;
            background: var(--charcoal);
            color: #fff;
            transition: color 0.35s ease;
        }
        .btn-submit::before {
            content: '';
            position: absolute; inset: 0;
            background: var(--gold);
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-submit:hover::before { transform: translateY(0); }
        .btn-submit span { position: relative; z-index: 1; }
    </style>
</head>
<body class="bg-cream font-jost text-charcoal">

    <!-- GOLD CIRCLE MODAL -->
    <div id="gc-modal" class="fixed inset-0 z-[100] flex items-center justify-center px-4" style="background: rgba(28,28,28,0.6);">
        <div class="modal-panel bg-cream w-full max-w-xl overflow-y-auto" style="max-height: 90vh;">

            <div class="bg-charcoal px-8 py-6 flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-crown text-soft-gold text-sm"></i>
                        <span class="text-[9px] tracking-[0.3em] font-jost text-soft-gold">LUMIÈRE LOYALTY</span>
                    </div>
                    <h2 class="font-playfair text-2xl text-white font-light">Gold Circle</h2>
                </div>
                <button id="gc-modal-close" class="text-white/30 hover:text-white transition-colors mt-1 text-xl leading-none">&times;</button>
            </div>

            <div class="px-8 py-8">
                <p class="text-warm-gray text-xs font-light leading-relaxed mb-8">
                    The Gold Circle is Lumière's private loyalty programme — reserved for our most dedicated clients. Membership unlocks a tier of service unavailable anywhere else: a dedicated Paris-based consultant, priority access to new releases, and complimentary engraving on every piece.
                </p>

                <p class="text-[9px] tracking-[0.25em] font-jost text-soft-gold mb-5">HOW TO QUALIFY</p>

                <div class="space-y-4 mb-8">
                    <div class="tier-card">
                        <p class="text-[10px] tracking-[0.15em] font-jost font-medium mb-1 text-warm-gray">SILVER TIER</p>
                        <p class="text-xs font-light text-charcoal">Spend $5,000+ lifetime or purchase any 3 pieces. Complimentary gift wrapping, early sale access, and a welcome gift.</p>
                    </div>
                    <div class="tier-card highlighted">
                        <span class="tier-badge">GOLD CIRCLE</span>
                        <p class="text-[10px] tracking-[0.15em] font-jost font-medium mb-1 text-soft-gold">GOLD CIRCLE</p>
                        <p class="text-xs font-light text-charcoal mb-3">Spend $15,000+ lifetime or purchase any bespoke commission. Everything in Silver, plus:</p>
                        <ul class="space-y-1.5">
                            <li class="flex items-start gap-2 text-xs text-charcoal/70 font-light"><i class="fa-solid fa-check text-soft-gold text-[9px] mt-0.5"></i>Dedicated personal consultant (Paris-based)</li>
                            <li class="flex items-start gap-2 text-xs text-charcoal/70 font-light"><i class="fa-solid fa-check text-soft-gold text-[9px] mt-0.5"></i>Priority bespoke consultations &amp; 3D render included</li>
                            <li class="flex items-start gap-2 text-xs text-charcoal/70 font-light"><i class="fa-solid fa-check text-soft-gold text-[9px] mt-0.5"></i>4-hour response guarantee during Paris hours</li>
                            <li class="flex items-start gap-2 text-xs text-charcoal/70 font-light"><i class="fa-solid fa-check text-soft-gold text-[9px] mt-0.5"></i>Complimentary engraving on every piece</li>
                            <li class="flex items-start gap-2 text-xs text-charcoal/70 font-light"><i class="fa-solid fa-check text-soft-gold text-[9px] mt-0.5"></i>First access to limited &amp; archive collections</li>
                            <li class="flex items-start gap-2 text-xs text-charcoal/70 font-light"><i class="fa-solid fa-check text-soft-gold text-[9px] mt-0.5"></i>Annual private atelier preview (Paris or virtual)</li>
                        </ul>
                    </div>
                    <div class="tier-card">
                        <p class="text-[10px] tracking-[0.15em] font-jost font-medium mb-1 text-charcoal/40">MAISON (INVITE ONLY)</p>
                        <p class="text-xs font-light text-charcoal/40">For our most enduring relationships. Extended to select clients by personal invitation from our founding atelier director.</p>
                    </div>
                </div>

                <div class="bg-deep-ivory px-5 py-4 mb-6">
                    <p class="text-[10px] font-jost text-charcoal/60 leading-relaxed">
                        Membership is automatic — no application needed. Once your account reaches the qualifying threshold, your status upgrades within 24 hours and your consultant is assigned.
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <a href="lespace.html" class="btn-submit inline-block px-7 py-3 text-[10px] tracking-[0.25em] font-jost">
                        <span>VIEW MY STATUS</span>
                    </a>
                    <button id="gc-modal-close-2" class="text-[10px] tracking-[0.2em] font-jost text-charcoal/40 hover:text-charcoal transition-colors border-b border-charcoal/10 pb-0.5">
                        CLOSE
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- NAV -->
    <nav class="fixed top-0 left-0 w-full z-50 py-5 px-6 md:px-12 bg-cream/90 backdrop-blur-sm border-b border-charcoal/5">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">
            <a href="{{ route('home') }}" class="font-playfair text-2xl tracking-widest text-charcoal">LUMIÈRE</a>
            <div class="hidden md:flex items-center gap-10 text-[10px] tracking-[0.2em] uppercase">
                <a href="{{ route('collections') }}" class="text-charcoal/60 hover:text-charcoal transition-colors">Collections</a>
                <a href="{{ route('shop') }}" class="text-charcoal/60 hover:text-charcoal transition-colors">Shop</a>
                <a href="{{ route('atelier') }}" class="text-charcoal/60 hover:text-charcoal transition-colors">Atelier</a>
                <a href="{{ route('bespoke') }}" class="text-charcoal border-b border-soft-gold pb-0.5">Bespoke</a>
            </div>
            <a href="{{ route('shop') }}" class="md:hidden text-[9px] tracking-[0.2em] text-charcoal/40 hover:text-soft-gold transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[9px]"></i> SHOP
            </a>
        </div>
    </nav>


    <!-- MAIN -->
    <section class="pt-40 pb-20 px-6 max-w-screen-xl mx-auto grid lg:grid-cols-2 gap-16 xl:gap-24">

        <!-- LEFT -->
        <div class="reveal">
            <a href="{{ route('shop') }}" class="hidden md:inline-flex items-center gap-2 text-[9px] tracking-[0.25em] text-charcoal/35 hover:text-soft-gold transition-colors duration-200 font-jost mb-8">
                <i class="fa-solid fa-arrow-left text-[8px]"></i> BACK TO SHOP
            </a>
            <p class="text-soft-gold text-[10px] tracking-[0.4em] uppercase mb-6">Sur Mesure</p>
            <h1 class="font-playfair text-5xl md:text-6xl font-light mb-6">
                Bespoke <span style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">Commission</span>
            </h1>
            <p class="text-sm text-warm-gray leading-relaxed mb-10 font-light">
                For those seeking a piece that exists nowhere else. Work directly with our lead designer in Paris to select a unique stone and create a custom setting that tells your specific story.
            </p>

            <!-- Gold Circle badge -->
            <div class="gold-circle-badge mb-3 flex items-start gap-3">
                <i class="fa-solid fa-crown text-soft-gold text-lg mt-0.5 flex-shrink-0"></i>
                <div>
                    <p class="text-[11px] font-jost font-medium text-charcoal mb-1">Gold Circle members receive priority consultation</p>
                    <p class="text-[10px] font-jost text-warm-gray leading-relaxed">
                        Dedicated designer, expedited timeline, and complimentary 3D render included at no charge.
                    </p>
                </div>
            </div>
            <div class="mb-10">
                <button id="gc-open-btn" class="gc-learn-link">
                    <i class="fa-solid fa-circle-info text-[10px] mr-1"></i>LEARN HOW TO ACHIEVE GOLD CIRCLE STATUS
                </button>
            </div>

            <!-- Timeline -->
            <div class="mb-12">
                <p class="text-[10px] tracking-[0.2em] font-jost text-soft-gold mb-6">THE BESPOKE JOURNEY</p>
                <div class="space-y-6">
                    <div class="timeline-step">
                        <h3 class="text-xs tracking-[0.15em] font-jost font-medium mb-1">Initial Consultation</h3>
                        <p class="text-[11px] text-warm-gray font-light">Private discussion of inspiration, stone preferences, and timeline. (1–2 weeks)</p>
                    </div>
                    <div class="timeline-step">
                        <h3 class="text-xs tracking-[0.15em] font-jost font-medium mb-1">Design & Approval</h3>
                        <p class="text-[11px] text-warm-gray font-light">Hand-drawn concepts followed by 3D render. Revisions included. (2–3 weeks)</p>
                    </div>
                    <div class="timeline-step">
                        <h3 class="text-xs tracking-[0.15em] font-jost font-medium mb-1">Crafting & Setting</h3>
                        <p class="text-[11px] text-warm-gray font-light">Hand-forged in our Paris atelier. Progress updates provided. (4–6 weeks)</p>
                    </div>
                    <div class="timeline-step">
                        <h3 class="text-xs tracking-[0.15em] font-jost font-medium mb-1">Final Delivery</h3>
                        <p class="text-[11px] text-warm-gray font-light">Certificate of authenticity, presentation box, and lifetime care instructions.</p>
                    </div>
                </div>
                <div class="mt-6 p-4 bg-deep-ivory text-center">
                    <p class="text-[10px] font-jost text-charcoal/60">Typical commission timeline: <span class="text-charcoal font-medium">6–8 weeks</span> from deposit to delivery</p>
                </div>
            </div>

            <div class="border-t border-charcoal/8 pt-8">
                <p class="text-xs font-jost text-charcoal/60 italic leading-relaxed">"The ring they created for our 25th anniversary is more beautiful than anything we imagined. The process was collaborative, transparent, and deeply personal."</p>
                <p class="text-[10px] font-jost text-soft-gold mt-3">— Helen & David, Gold Circle Members</p>
            </div>
        </div>


        <!-- RIGHT: Form -->
        <div class="bg-white p-8 md:p-12 shadow-sm reveal" style="transition-delay: 0.2s;">
            <h2 class="font-playfair text-2xl mb-2">Start your journey</h2>
            <p class="text-warm-gray text-xs font-jost font-light mb-8">Submit this form and a personal consultant will respond within 24 hours.</p>

            <div class="space-y-8" id="bespoke-form">
                <div class="grid md:grid-cols-2 gap-8">
                    <input type="text" name="full_name" placeholder="FULL NAME" class="w-full py-3 text-[10px] tracking-widest">
                    <input type="email" name="email" placeholder="EMAIL ADDRESS" class="w-full py-3 text-[10px] tracking-widest">
                </div>
                <div class="grid md:grid-cols-2 gap-8">
                    <input type="text" name="phone" placeholder="PHONE (OPTIONAL)" class="w-full py-3 text-[10px] tracking-widest">
                    <select name="occasion" class="w-full py-3 text-[10px] tracking-widest text-warm-gray">
                        <option value="">SELECT OCCASION</option>
                        <option>ENGAGEMENT</option>
                        <option>ANNIVERSARY</option>
                        <option>HEIRLOOM RESTORATION</option>
                        <option>PRIVATE COMMISSION</option>
                        <option>GIFT</option>
                    </select>
                </div>
                <select name="budget" class="w-full py-3 text-[10px] tracking-widest text-warm-gray">
                    <option value="">BUDGET RANGE</option>
                    <option>$5,000 – $10,000</option>
                    <option>$10,000 – $25,000</option>
                    <option>$25,000 – $50,000</option>
                    <option>$50,000+</option>
                    <option>PREFER NOT TO SAY</option>
                </select>

                <div>
                    <p class="text-[9px] tracking-[0.2em] font-jost text-charcoal/50 mb-4">STYLE PREFERENCES</p>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach (['Classic', 'Minimalist', 'Art Deco', 'Romantic', 'Bold & Sculptural', 'Vintage', 'Nature-inspired'] as $style)
                            <label class="flex items-center gap-3 border border-charcoal/10 px-4 py-3 text-[10px] tracking-[0.14em] font-jost text-charcoal/65 hover:border-soft-gold hover:text-soft-gold transition-colors cursor-pointer">
                                <input type="checkbox" name="style_preferences[]" value="{{ $style }}" class="text-soft-gold focus:ring-soft-gold">
                                {{ strtoupper($style) }}
                            </label>
                        @endforeach
                    </div>
                    <p class="text-[8px] font-jost text-charcoal/30 mt-2">Select all that apply.</p>
                </div>

                <!-- File upload -->
                <div>
                    <p class="text-[9px] tracking-[0.2em] font-jost text-charcoal/50 mb-3">REFERENCE IMAGES (OPTIONAL)</p>
                    <label class="upload-zone flex flex-col items-center justify-center gap-2 py-6 px-4 rounded-sm">
                        <i class="fa-solid fa-image text-charcoal/20 text-2xl"></i>
                        <span id="upload-label" class="text-[9px] tracking-[0.15em] font-jost text-charcoal/40 text-center">CLICK TO UPLOAD &nbsp;·&nbsp; JPG, PNG, WEBP &nbsp;·&nbsp; MAX 4MB EACH</span>
                        <input type="file" id="file-input" name="reference_images[]" accept="image/jpeg,image/png,image/webp" multiple class="hidden">
                    </label>
                    <p class="text-[8px] font-jost text-charcoal/30 mt-2">For reference purposes only. All files are validated server-side.</p>
                </div>

                <textarea name="vision" placeholder="TELL US ABOUT YOUR VISION — stone preferences, design inspirations, any reference pieces…" rows="4" class="w-full py-3 text-[10px] tracking-widest"></textarea>

                <!-- Gold Circle checkbox -->
                <div class="flex items-start gap-3">
                    <input type="checkbox" id="gc-checkbox" name="gold_circle_interest" value="1" class="mt-0.5">
                    <label for="gc-checkbox" class="text-[9px] tracking-[0.15em] font-jost text-warm-gray leading-relaxed cursor-pointer">
                        I am a Gold Circle member, or I'd like to
                        <button type="button" id="gc-open-btn-2" class="gc-learn-link">learn how to achieve Gold Circle status</button>
                        and receive priority handling for this request.
                    </label>
                </div>

                <button type="button" class="btn-submit w-full py-5 text-[10px] tracking-[0.3em] uppercase font-jost">
                    <span>REQUEST PRIVATE CONSULTATION</span>
                </button>
                <p class="text-[8px] text-warm-gray/50 text-center font-jost">Your information is confidential. A consultant will respond within 24 hours.</p>
            </div>
        </div>
    </section>


    <script>
        // Scroll reveals
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Gold Circle modal
        const modal = document.getElementById('gc-modal');
        const openModal = () => { modal.classList.add('open'); document.body.style.overflow = 'hidden'; };
        const closeModal = () => { modal.classList.remove('open'); document.body.style.overflow = ''; };

        document.getElementById('gc-open-btn').addEventListener('click', openModal);
        document.getElementById('gc-open-btn-2').addEventListener('click', openModal);
        document.getElementById('gc-modal-close').addEventListener('click', closeModal);
        document.getElementById('gc-modal-close-2').addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

        // File upload feedback
        document.getElementById('file-input').addEventListener('change', function () {
            const label = document.getElementById('upload-label');
            const count = this.files.length;
            if (count > 0) {
                label.textContent = `${count} FILE${count > 1 ? 'S' : ''} SELECTED`;
                label.classList.replace('text-charcoal/40', 'text-soft-gold');
            }
        });
    </script>
</body>
</html>
