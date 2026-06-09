<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Capture guest session data before authentication flow.
        $guestCart = $request->session()->get('cart', []);
        $guestWishlist = $request->session()->get('wishlist', []);

        $request->authenticate();

        $request->session()->regenerate();

        $this->mergeGuestDataIntoAccount($request, $guestCart, $guestWishlist);

        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Merge guest cart/wishlist session data into the authenticated user's account.
     *
     * @param  array<string, array{product_id:mixed,variant_id:mixed,quantity:mixed}>  $guestCart
     * @param  array<int, mixed>  $guestWishlist
     */
    private function mergeGuestDataIntoAccount(Request $request, array $guestCart, array $guestWishlist): void
    {
        if (! auth('web')->check()) {
            return;
        }

        // Merge cart entries (same product+variant => increment quantity).
        if (! empty($guestCart)) {
            $cart = Cart::firstOrCreate(['user_id' => auth('web')->id()]);

            foreach ($guestCart as $item) {
                $productId = isset($item['product_id']) ? (int) $item['product_id'] : 0;
                $variantId = isset($item['variant_id']) && $item['variant_id'] !== '' ? (int) $item['variant_id'] : null;
                $quantity = max(1, (int) ($item['quantity'] ?? 1));

                if ($productId <= 0) {
                    continue;
                }

                $existing = $cart->items()
                    ->where('product_id', $productId)
                    ->where('variant_id', $variantId)
                    ->first();

                if ($existing) {
                    $existing->increment('quantity', $quantity);
                } else {
                    $cart->items()->create([
                        'product_id' => $productId,
                        'variant_id' => $variantId,
                        'quantity' => $quantity,
                    ]);
                }
            }
        }

        // Merge wishlist entries (avoid duplicates).
        if (! empty($guestWishlist)) {
            $wishlist = Wishlist::firstOrCreate(['user_id' => auth('web')->id()]);

            foreach ($guestWishlist as $productId) {
                $productId = (int) $productId;
                if ($productId <= 0) {
                    continue;
                }

                $alreadyExists = $wishlist->items()->where('product_id', $productId)->exists();
                if (! $alreadyExists) {
                    $wishlist->items()->create(['product_id' => $productId]);
                }
            }
        }

        // Clear guest copies after successful merge.
        $request->session()->forget(['cart', 'wishlist']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
