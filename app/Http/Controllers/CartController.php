<?php

namespace App\Http\Controllers;

// I need these models for cart operations
// Cart for the user's cart container, Product for product details, ProductVariant for size/options
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
// Request for handling input, Collection for type hints, Auth for user authentication
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Helper method to check if user is logged in
     * I'm using this throughout the controller to decide between database vs session storage
     */
    private function isAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Get all cart items for the current user/guest
     * I'm handling both authenticated users (database) and guests (session)
     * This returns a consistent Collection format regardless of storage method
     */
    public function getCartData(): Collection
    {
        if ($this->isAuthenticated()) {
            // For logged-in users, get cart from database
            // Create cart if it doesn't exist yet
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            // Eager load product with primary image and variant details
            // This prevents N+1 queries when displaying cart items
            return $cart->items()->with('product.primaryImage', 'variant')->get();
        } else {
            // For guests, cart is stored in session as an array
            $cart = session('cart', []);
            $items = [];

            // Convert session array to object collection for consistency
            foreach ($cart as $key => $item) {
                // Load product and variant data for each cart item
                $product = Product::with('primaryImage')->find($item['product_id']);
                $variant = $item['variant_id'] ? ProductVariant::find($item['variant_id']) : null;

                // Create an object with the same structure as database cart items
                $items[] = (object) [
                    'id' => $key,
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $item['quantity'],
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                ];
            }

            return collect($items);
        }
    }

    /**
     * Calculate total number of items in cart
     * I'm summing quantities because cart can have multiple of same item
     * This is used for the cart count badge in the header
     */
    public function cartCount(): int
    {
        return (int) $this->getCartData()->sum(fn ($item) => $item->quantity ?? 1);
    }

    /**
     * Add item to guest cart (session storage)
     * I'm using a composite key of product_id-variant_id to handle variants
     * If the same product/variant combo exists, I increment quantity instead of duplicating
     */
    private function addToSession(int $productId, ?int $variantId, int $quantity): void
    {
        $cart = session('cart', []);
        // Create unique key: product_id-variant_id (or just product_id if no variant)
        $key = $productId.'-'.($variantId ?? '');

        if (isset($cart[$key])) {
            // Item already exists - increment quantity
            $cart[$key]['quantity'] += $quantity;
        } else {
            // New item - add to cart
            $cart[$key] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
            ];
        }
        session(['cart' => $cart]);
    }

    /**
     * Ensure guest cart exists in session
     * This creates an empty cart so items can be added
     */
    private function ensureGuestCart(): void
    {
        if (! session('cart')) {
            session(['cart' => []]);
        }
    }

    /**
     * Remove item from guest cart (session storage)
     * Using the same composite key as addToSession for consistency
     */
    private function removeFromSession(int $productId, ?int $variantId): void
    {
        $cart = session('cart', []);
        $key = $productId.'-'.($variantId ?? '');
        unset($cart[$key]); // Remove the item completely
        session(['cart' => $cart]);
    }

    /**
     * Update item quantity in guest cart (session storage)
     * This is used when user changes quantity in cart page
     */
    private function updateSession(int $productId, ?int $variantId, int $quantity): void
    {
        $cart = session('cart', []);
        $key = $productId.'-'.($variantId ?? '');
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
        }
        session(['cart' => $cart]);
    }

    /**
     * Home page method - loads cart and wishlist data for the welcome page
     * I'm passing cart items and counts to the header so badges show correct numbers
     */
    public function home()
    {
        // Ensure cart exists for guests so items can be added
        if (! $this->isAuthenticated()) {
            $this->ensureGuestCart();
        }

        $items = $this->getCartData();
        $cartCount = $this->cartCount();

        // Get wishlist count for the header badge
        $wishlistController = new WishlistController;
        $wishlistItems = $wishlistController->getWishlistData();
        $wishlistCount = $wishlistItems->count();

        // Get featured products for the bestsellers section
        $featuredProducts = Product::query()
            ->with('collection', 'primaryImage')
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('welcome', compact('cartCount', 'items', 'wishlistCount', 'featuredProducts'));
    }

    /**
     * Show the cart page
     * Returns JSON for AJAX requests or full view for normal requests
     * This flexibility lets me update cart drawer without page reload
     */
    public function index(Request $request)
    {
        $items = $this->getCartData();
        if ($request->wantsJson()) {
            return response()->json(['items' => $items]);
        }

        return view('cart.index', compact('items'));
    }

    /**
     * Add item to cart
     * Handles both authenticated users and guests
     * Returns JSON for AJAX requests or redirects for normal form submissions
     */
    public function add(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($this->isAuthenticated()) {
            // For logged-in users, handle cart in database
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            // Check if this product/variant combo already exists in cart
            $item = $cart->items()->where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)->first();

            if ($item) {
                // Item exists - increment quantity
                $item->increment('quantity', $request->quantity);
            } else {
                // New item - create it
                $cart->items()->create($request->only(['product_id', 'variant_id', 'quantity']));
            }
        } else {
            // For guests, handle cart in session
            $this->addToSession($request->product_id, $request->variant_id, $request->quantity);
        }

        if ($request->wantsJson()) {
            // Return JSON response for AJAX requests (like from product detail page)
            // Include cart_count so JavaScript can update the badge
            return response()->json(['message' => 'Item added to cart', 'cart_count' => $this->cartCount()]);
        }

        // For normal form submissions, redirect back with success message
        return redirect()->back()->with('success', 'Item added to cart');
    }

    /**
     * Remove item from cart
     * Similar to add() but removes instead of adds
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        if ($this->isAuthenticated()) {
            // Remove from database cart
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cart->items()->where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)->delete();
        } else {
            // Remove from session cart
            $this->removeFromSession($request->product_id, $request->variant_id);
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Item removed from cart', 'cart_count' => $this->cartCount()]);
        }

        return redirect()->back()->with('success', 'Item removed');
    }

    /**
     * Update quantity of a specific cart item
     * Used in the cart page when user changes quantity input
     * Takes itemId from the URL route
     */
    public function updateQuantity(Request $request, string $itemId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = (int) $validated['quantity'];

        if ($this->isAuthenticated()) {
            // For logged-in users, find the cart item by its primary key
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $item = $cart->items()->whereKey($itemId)->firstOrFail();

            $item->update(['quantity' => $quantity]);
        } else {
            // For guests, find the item in session by its array key
            $cart = session('cart', []);
            if (! array_key_exists($itemId, $cart)) {
                abort(404); // Item not found in session cart
            }

            $cart[$itemId]['quantity'] = $quantity;

            session(['cart' => $cart]);
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Cart quantity updated', 'cart_count' => $this->cartCount()]);
        }

        return redirect()->back()->with('success', 'Cart updated');
    }

    /**
     * Completely remove an item from cart
     * Different from remove() - this one takes itemId from route
     */
    public function destroy(Request $request, string $itemId)
    {
        if ($this->isAuthenticated()) {
            // Remove from database cart
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cart->items()->whereKey($itemId)->delete();
        } else {
            // Remove from session cart
            $cart = session('cart', []);
            unset($cart[$itemId]);
            session(['cart' => $cart]);
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Item removed from cart', 'cart_count' => $this->cartCount()]);
        }

        return redirect()->back()->with('success', 'Item removed');
    }

    /**
     * Generic update method - can add or update based on whether item exists
     * This is a more flexible version of add() that can handle both scenarios
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($this->isAuthenticated()) {
            // For logged-in users, find existing item or create new one
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $item = $cart->items()->where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)->first();
            if ($item) {
                // Update existing item quantity
                $item->update(['quantity' => $request->quantity]);
            }
        } else {
            // For guests, use the session update method
            $this->updateSession($request->product_id, $request->variant_id, $request->quantity);
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Cart updated', 'cart_count' => $this->cartCount()]);
        }

        return redirect()->back()->with('success', 'Cart updated');
    }

    /**
     * API endpoint to get current cart count
     * This is called by JavaScript to update the cart badge
     * Returns JSON with just the count value
     */
    public function getCartCount()
    {
        return response()->json(['count' => $this->cartCount()]);
    }
}
