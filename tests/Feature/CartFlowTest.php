<?php

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use App\Models\User;

test('authenticated customer can add update and remove a cart item', function () {
    $user = User::factory()->create();
    $product = Product::factory()->category('ring')->create(['price' => 4200]);

    $this->actingAs($user)
        ->postJson(route('api.cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ])
        ->assertOk()
        ->assertJsonPath('cart_count', 2);

    $cart = Cart::where('user_id', $user->id)->firstOrFail();
    $cartItem = CartItems::where('cart_id', $cart->id)->firstOrFail();

    $this->actingAs($user)
        ->patchJson(route('api.cart.quantity', ['item' => $cartItem->id]), [
            'quantity' => 3,
        ])
        ->assertOk()
        ->assertJsonPath('cart_count', 3);

    expect($cartItem->refresh()->quantity)->toBe(3);

    $this->actingAs($user)
        ->deleteJson(route('api.cart.destroy', ['item' => $cartItem->id]))
        ->assertOk()
        ->assertJsonPath('cart_count', 0);

    $this->assertDatabaseMissing('cart_items', [
        'id' => $cartItem->id,
    ]);
});
