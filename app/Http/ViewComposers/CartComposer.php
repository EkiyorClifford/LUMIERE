<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind cart data to all views.
     */
    public function compose(View $view): void
    {
        $cartItems = collect();
        $cartCount = 0;
        $cartTotal = 0;

        if (Auth::check()) {
            $cart = Auth::user()->cart ?? null;

            if ($cart) {
                $cartItems = $cart->items ?? collect();
                $cartCount = $cartItems->count();
                $cartTotal = $cartItems->sum(fn ($item) => $item->price * $item->quantity);
            }
        }

        $view->with(compact('cartItems', 'cartCount', 'cartTotal'));
    }
}
