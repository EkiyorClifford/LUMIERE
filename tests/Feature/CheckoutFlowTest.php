<?php

use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('authenticated customer can checkout with stripe and clear their cart', function () {
    Mail::fake();

    $user = User::factory()->create();
    $product = Product::factory()->category('ring')->create([
        'name' => 'Diamond Solitaire Ring',
        'price' => 1000,
    ]);
    $cart = Cart::factory()->for($user)->create();

    CartItems::factory()->for($cart, 'Cart')->for($product, 'Product')->create([
        'quantity' => 2,
    ]);

    $this->actingAs($user)
        ->postJson(route('checkout.store'), [
            'shipping_full_name' => 'Julianne V.',
            'shipping_address' => '12 Rue de Lumiere',
            'shipping_city' => 'Paris',
            'shipping_state' => 'Ile-de-France',
            'shipping_postal_code' => '75001',
            'shipping_country' => 'France',
            'billing_same_as_shipping' => true,
            'payment_method' => 'stripe',
            'card_number' => '4242424242424242',
            'card_expiry' => '12/30',
            'card_cvc' => '123',
            'stripeToken' => 'tok_visa',
        ])
        ->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonStructure(['order_number', 'redirect_url']);

    $this->assertDatabaseHas('orders', [
        'user_id' => $user->id,
        'order_status' => 'paid',
        'total' => 2160,
    ]);

    $this->assertDatabaseHas('order_items', [
        'product_id' => $product->id,
        'product_name' => 'Diamond Solitaire Ring',
        'quantity' => 2,
        'price' => 1000,
    ]);

    $this->assertDatabaseHas('payments', [
        'amount' => 2160,
        'payment_status' => 'completed',
    ]);

    expect($cart->items()->count())->toBe(0);
    Mail::assertSent(OrderConfirmation::class);
});
