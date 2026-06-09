<?php

namespace App\Http\ViewComposers;

use App\Services\CartService;
use Illuminate\View\View;

class CartComposer
{
    public function __construct(
        private CartService $cartService,
    ) {}

    /**
     * Bind cart data to all views.
     */
    public function compose(View $view): void
    {
        $cartCount = $this->cartService->cartCount();
        $cartItems = $this->cartService->getCartData();

        $cartTotal = 0;
        foreach ($cartItems as $item) {
            if ($item->product) {
                $cartTotal += ($item->product->price ?? 0) * ($item->quantity ?? 1);
            }
        }

        $view->with(compact('cartItems', 'cartCount', 'cartTotal'));
    }
}
