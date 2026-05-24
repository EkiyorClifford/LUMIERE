<?php

use App\Models\Product;
use App\Models\ProductImage;
use Tests\TestCase;

test('guest add to cart returns updated quantity count', function () {
    $product = Product::create([
        'name' => 'Test Ring',
        'slug' => 'test-ring',
        'price' => 2500,
        'category' => 'ring',
        'is_active' => true,
    ]);

    $this->postJson(route('api.cart.add'), [
        'product_id' => $product->id,
        'quantity' => 2,
    ])->assertOk()
        ->assertJson([
            'cart_count' => 2,
        ]);
});

test('guest cart payload includes primary image url', function () {
    $product = Product::create([
        'name' => 'Test Pendant',
        'slug' => 'test-pendant',
        'price' => 1250,
        'category' => 'necklace',
        'is_active' => true,
    ]);

    ProductImage::create([
        'product_id' => $product->id,
        'image_path' => 'products/test-pendant.jpg',
        'is_primary' => true,
    ]);

    $this->withSession([
        'cart' => [
            $product->id.'-' => [
                'product_id' => $product->id,
                'variant_id' => null,
                'quantity' => 1,
            ],
        ],
    ]);

    $this->getJson(route('api.cart.index'))
        ->assertOk()
        ->assertJsonPath('items.0.product.primary_image.image_url', asset('storage/products/test-pendant.jpg'));
});

test('guest can decrement cart item quantity without removing item', function () {
    /** @var TestCase $this */
    $this->withSession([
        'cart' => [
            '1-' => [
                'product_id' => 1,
                'variant_id' => null,
                'quantity' => 2,
            ],
        ],
    ]);

    $response = $this->patchJson(route('api.cart.quantity', ['item' => '1-']), [
        'quantity' => 1,
    ]);

    $response->assertOk();
    $this->assertEquals(1, session('cart.1-.quantity'));
});

test('guest cart item quantity cannot be set below one from quantity endpoint', function () {
    /** @var TestCase $this */
    $this->withSession([
        'cart' => [
            '1-' => [
                'product_id' => 1,
                'variant_id' => null,
                'quantity' => 1,
            ],
        ],
    ]);

    $response = $this->patchJson(route('api.cart.quantity', ['item' => '1-']), [
        'quantity' => 0,
    ]);

    $response->assertUnprocessable();
    $this->assertEquals(1, session('cart.1-.quantity'));
});
