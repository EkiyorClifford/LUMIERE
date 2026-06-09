<?php

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can toggle product active state via ajax endpoint', function () {
    $admin = Admin::create([
        'name' => 'Lumière Admin',
        'email' => 'admin@lumiere.com',
        'password' => 'molotov',
        'role' => 'superadmin',
    ]);

    $product = Product::create([
        'name' => 'Celestial Sapphire Ring',
        'slug' => 'celestial-sapphire-ring',
        'category' => 'ring',
        'description' => 'A luminous atelier piece.',
        'price' => 3450,
        'is_active' => true,
        'sort_order' => 0,
    ]);

    $this->actingAs($admin, 'admin');

    $response = $this->patchJson(route('admin.products.toggle-active', $product));

    $response->assertOk();
    $response->assertJson(['ok' => true, 'is_active' => false, 'label' => 'Disabled']);
    expect($product->refresh()->is_active)->toBeFalse();
});

test('admin can toggle product active state from the product index form', function () {
    $admin = Admin::create([
        'name' => 'LumiÃ¨re Admin',
        'email' => 'admin@lumiere.com',
        'password' => 'molotov',
        'role' => 'superadmin',
    ]);

    $product = Product::create([
        'name' => 'Golden Orbit Earrings',
        'slug' => 'golden-orbit-earrings',
        'category' => 'earrings',
        'description' => 'A luminous atelier piece.',
        'price' => 2200,
        'is_active' => true,
        'sort_order' => 0,
    ]);

    $this->actingAs($admin, 'admin');

    $this->get(route('admin.products.index'))
        ->assertOk()
        ->assertSee(route('admin.products.toggle-active', $product), false)
        ->assertDontSee('/admin/products/'.$product->id.'/toggle-active', false);

    $response = $this->patch(route('admin.products.toggle-active', $product));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Product disabled.');
    expect($product->refresh()->is_active)->toBeFalse();
});
