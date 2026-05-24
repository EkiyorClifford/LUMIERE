<!-- CART DRAWER -->
<!-- Slide-out cart from the right side -->
<!-- Using highest z-index to appear above everything -->
<!-- Translate-x-full hides it off-screen, removed to show -->
<div id="cart-drawer" class="fixed inset-y-0 right-0 w-full md:w-96 bg-white z-[100] shadow-2xl translate-x-full transition-transform duration-500 ease-in-out flex flex-col">
    <!-- Header with title and close button -->
    <div class="p-6 border-b border-charcoal/5 flex justify-between items-center">
        <div>
            <h2 class="font-playfair text-xl text-charcoal">Your Shopping Bag</h2>
            <!-- Dynamic item count - updated by JavaScript -->
            <span id="cart-count-header" class="text-xs text-warm-gray font-jost">(0 items)</span>
        </div>
        <button onclick="toggleCart()" class="text-charcoal/40 hover:text-charcoal transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <!-- Scrollable items container -->
    <!-- Flex-1 allows it to grow and fill available space -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">
        <div id="cart-items-container">
            <!-- Empty cart state -->
            <div class="text-center py-12">
                <div class="font-playfair text-2xl tracking-[0.24em] text-charcoal mb-5">LUMIÈRE</div>
                <i class="fa-solid fa-cart-shopping text-4xl text-charcoal/20 mb-4"></i>
                <p class="text-charcoal/50 text-sm font-jost">Your bag is empty</p>
                <a href="{{ route('shop') }}" class="inline-block mt-4 text-soft-gold text-xs tracking-[0.2em] hover:underline font-jost">CONTINUE SHOPPING</a>
            </div>
        </div>
    </div>

    <!-- Footer with subtotal and checkout -->
    <!-- Hidden by default, shown when cart has items -->
    <div id="cart-footer" class="p-6 bg-cream border-t border-charcoal/5 space-y-4 hidden">
        <div class="flex justify-between items-center">
            <p class="text-[10px] tracking-[0.2em] uppercase text-charcoal/60 font-jost">Subtotal</p>
            <!-- Dynamic subtotal calculated by JavaScript -->
            <p id="cart-subtotal" class="font-playfair text-lg text-charcoal">€0.00</p>
        </div>
        <!-- Clear cart button -->
        <button type="button" onclick="clearCart()" class="w-full border border-charcoal/15 text-charcoal py-2.5 text-[10px] tracking-[0.2em] uppercase hover:border-charcoal/40 transition-colors duration-200 font-jost">
            Clear all
        </button>
        <!-- Shipping note -->
        <p class="text-[9px] text-warm-gray leading-relaxed font-jost">Complimentary insured worldwide shipping applied at checkout.</p>
        <!-- Checkout button -->
        <a href="{{ route('checkout.create') }}" class="block w-full bg-charcoal text-white py-4 text-[10px] tracking-[0.3em] uppercase hover:bg-soft-gold transition-colors duration-300 text-center font-jost font-medium">
            PROCEED TO CHECKOUT
        </a>
    </div>
</div>

<!-- Overlay behind cart drawer -->
<!-- Darkens background when cart is open -->
<!-- Clicking overlay closes cart -->
<div id="cart-overlay" class="fixed inset-0 bg-black/30 z-[90] hidden opacity-0 transition-opacity duration-300" onclick="toggleCart()"></div>

<script>
    // Helper function to get CSRF token for AJAX requests
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
    }

    // Update all cart count badges in the navigation
    // Uses multiple selectors to catch all badge variations
    function setCartCount(count) {
        document.querySelectorAll('#cart-count, [data-cart-count], button[onclick*="toggleCart"] span').forEach((badge) => {
            badge.textContent = count;
        });
    }

    // Toggle cart drawer visibility
    // Handles both opening and closing with smooth transitions
    function toggleCart() {
        const drawer = document.getElementById('cart-drawer');
        const overlay = document.getElementById('cart-overlay');
        if (!drawer || !overlay) {
            return;
        }

        // Toggle drawer position
        drawer.classList.toggle('translate-x-full');
        overlay.classList.toggle('hidden');
        
        // If opening, fade in overlay and load cart data
        if (!drawer.classList.contains('translate-x-full')) {
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
            loadCart();
        } else {
            // If closing, fade out overlay
            overlay.classList.remove('opacity-100');
        }
    }

    // Load cart data from API
    // Called when opening cart drawer
    async function loadCart() {
        try {
            const response = await fetch('/api/cart', {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            });
            
            if (!response.ok) throw new Error('Failed to load cart');
            
            const data = await response.json();
            renderCart(data.items || []);
        } catch (error) {
            console.error('Error loading cart:', error);
        }
    }

    // Render cart items in the drawer
    // Handles both empty and populated states
    function renderCart(items) {
        const container = document.getElementById('cart-items-container');
        const footer = document.getElementById('cart-footer');
        const countHeader = document.getElementById('cart-count-header');
        if (!container || !footer || !countHeader) {
            return;
        }
        
        if (items.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <div class="font-playfair text-2xl tracking-[0.24em] text-charcoal mb-5">LUMIÈRE</div>
                    <i class="fa-solid fa-cart-shopping text-4xl text-charcoal/20 mb-4"></i>
                    <p class="text-charcoal/50 text-sm font-jost">Your bag is empty</p>
                    <a href="{{ route('shop') }}" class="inline-block mt-4 text-soft-gold text-xs tracking-[0.2em] hover:underline font-jost">CONTINUE SHOPPING</a>
                </div>
            `;
            footer.classList.add('hidden');
            countHeader.textContent = '(0 items)';
            setCartCount(0);
            return;
        }

        let subtotal = 0;
        container.innerHTML = items.map(item => {
            const quantity = item.quantity || 1;
            const itemTotal = (item.product?.price || 0) * quantity;
            const minusDisabled = quantity <= 1;
            subtotal += itemTotal;
            
            return `
                <div class="flex gap-4 pb-4 border-b border-charcoal/5">
                    <div class="w-20 h-24 bg-deep-ivory overflow-hidden rounded-sm flex-shrink-0">
                        <img src="${item.product?.primary_image?.image_url || item.product?.primaryImage?.image_url || item.product?.images?.[0]?.image_url || 'https://images.unsplash.com/photo-1515562141589-67f0b562b677?q=80&w=400&auto=format&fit=crop'}" 
                             alt="${item.product?.name || 'Product'}" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-playfair text-sm text-charcoal">${item.product?.name || 'Item'}</h3>
                            <p class="text-[9px] tracking-widest text-warm-gray uppercase font-jost">${item.variant?.label || 'Standard'}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center border border-charcoal/15 rounded-sm">
                                <button ${minusDisabled ? 'disabled' : ''} onclick="changeCartQuantity('${item.id}', ${quantity - 1})" class="w-6 h-6 flex items-center justify-center text-xs hover:bg-charcoal/5 disabled:cursor-not-allowed disabled:text-charcoal/20 disabled:hover:bg-transparent" aria-label="Decrease quantity">−</button>
                                <span class="w-6 text-center text-[10px] font-jost">${quantity}</span>
                                <button onclick="changeCartQuantity('${item.id}', ${quantity + 1})" class="w-6 h-6 flex items-center justify-center text-xs hover:bg-charcoal/5" aria-label="Increase quantity">+</button>
                            </div>
                            <div class="flex items-center gap-3">
                                <p class="text-sm font-jost text-charcoal">€${itemTotal.toFixed(2)}</p>
                                <button onclick="removeCartItem('${item.id}')" class="text-charcoal/40 hover:text-charcoal text-xs" aria-label="Remove item">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        const totalQuantity = items.reduce((sum, item) => sum + (item.quantity || 1), 0);
        countHeader.textContent = `(${totalQuantity} item${totalQuantity !== 1 ? 's' : ''})`;
        document.getElementById('cart-subtotal').textContent = `€${subtotal.toFixed(2)}`;
        footer.classList.remove('hidden');
        setCartCount(totalQuantity);
    }

    async function addToCart(productId, variantId, quantity) {
        let resolvedProductId = productId;
        let resolvedVariantId = variantId ?? null;
        let resolvedQuantity = quantity ?? 1;

        if (productId instanceof Event) {
            const trigger = productId.currentTarget ?? productId.target?.closest('[data-product-id]');
            resolvedProductId = trigger?.dataset?.productId;
            resolvedVariantId = trigger?.dataset?.variantId ?? resolvedVariantId;
            resolvedQuantity = trigger?.dataset?.quantity ?? resolvedQuantity;
        }

        if (!resolvedProductId) {
            console.error('Missing product id for addToCart');
            return;
        }

        try {
            const response = await fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({
                    product_id: resolvedProductId,
                    variant_id: resolvedVariantId,
                    quantity: parseInt(resolvedQuantity, 10)
                })
            });

            if (!response.ok) {
                const error = await response.text();
                throw new Error(`HTTP ${response.status}: ${error}`);
            }

            const data = await response.json();
            if (typeof data.cart_count !== 'undefined') {
                setCartCount(data.cart_count || 0);
            }
            await loadCart();
        } catch (error) {
            console.error('Error adding to cart:', error);
        }
    }

    async function removeCartItem(itemId) {
        try {
            const response = await fetch(`/api/cart/${encodeURIComponent(itemId)}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            });

            if (!response.ok) throw new Error('Failed to remove item');

            const data = await response.json();
            if (typeof data.cart_count !== 'undefined') {
                setCartCount(data.cart_count || 0);
            }
            await loadCart();
        } catch (error) {
            console.error('Error removing from cart:', error);
        }
    }

    async function changeCartQuantity(itemId, quantity) {
        try {
            const response = await fetch(`/api/cart/${encodeURIComponent(itemId)}/quantity`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({ quantity })
            });

            if (!response.ok) throw new Error('Failed to update quantity');

            const data = await response.json();
            if (typeof data.cart_count !== 'undefined') {
                setCartCount(data.cart_count || 0);
            }
            await loadCart();
        } catch (error) {
            console.error('Error updating cart quantity:', error);
        }
    }

    async function clearCart() {
        try {
            const response = await fetch('/api/cart', {
                headers: {
                    'Accept': 'application/json',
                }
            });
            if (!response.ok) {
                throw new Error('Failed to load cart for clearing');
            }

            const data = await response.json();
            const items = data.items || [];
            await Promise.all(
                items.map((item) => fetch(`/api/cart/${encodeURIComponent(item.id)}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    }
                }))
            );

            await loadCart();
            updateCartCount();
        } catch (error) {
            console.error('Error clearing cart:', error);
        }
    }

    function updateCartCount() {
        fetch('/api/cart/count')
            .then(r => r.json())
            .then(data => {
                const count = data.count || 0;
                setCartCount(count);
            })
            .catch(e => console.error('Error updating cart count:', e));
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', updateCartCount);
</script>
