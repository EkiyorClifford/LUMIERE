<?php

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\File;

test('legacy static html views are removed', function () {
    expect(File::glob(resource_path('views/*.html')))->toBeEmpty();
    expect(File::glob(resource_path('views/admin/*.html')))->toBeEmpty();
});

test('password reset view does not read the token from the route directly', function () {
    expect(File::get(resource_path('views/auth/reset-password.blade.php')))
        ->not->toContain('$request->route(\'token\')');
});

test('size guide footer uses shop category routes', function () {
    $response = $this->get('/size-guide');

    $response->assertOk();
    $response->assertSee('href="'.route('shop', ['category' => 'necklace']).'"', false);
    $response->assertSee('href="'.route('shop', ['category' => 'ring']).'"', false);
    $response->assertSee('href="'.route('shop', ['category' => 'earrings']).'"', false);
    $response->assertSee('href="'.route('shop', ['category' => 'bracelet']).'"', false);
});

test('sur-mesure status button uses profile route', function () {
    $response = $this->get('/sur-mesure');

    $response->assertOk();
    $response->assertSee('href="'.route('profile.show').'"', false);
});

test('collections landing page uses actual collection links and atelier route', function () {
    $response = $this->get('/collections');

    $response->assertOk();
    $response->assertSee('href="'.route('collections.show', 'leclat').'"', false);
    $response->assertSee('href="'.route('collections.show', 'lor').'"', false);
    $response->assertSee('href="'.route('collections.show', 'la-perle').'"', false);
    $response->assertSee('href="'.route('atelier').'"', false);
    $response->assertSee('id="la-nuit-notify"', false);
    $response->assertSee('id="newsletter-collections-source"', false);
    $response->assertSee('la_nuit_notify', false);
    $response->assertDontSee('href="http://localhost/collections/la-nuit"', false);
});

test('checkout confirmation includes profile tracking route', function () {
    $user = User::factory()->create();
    $product = Product::create([
        'name' => 'Test Necklace',
        'slug' => 'test-necklace',
        'price' => 250,
        'category' => 'necklace',
        'is_active' => true,
    ]);
    $cart = Cart::create(['user_id' => $user->id]);
    CartItems::create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/checkout');

    $response->assertOk();
    $response->assertSee('href="'.route('profile.show').'"', false);
});

test('register form terms links are not placeholder anchors', function () {
    $response = $this->get('/register');

    $response->assertOk();
    $response->assertSee('href="javascript:void(0)"', false);
});
