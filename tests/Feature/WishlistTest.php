<?php

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

it('returns json for ajax wishlist add requests', function () {
    if (! Schema::hasTable('products')) {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('category');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    $product = Product::create([
        'name' => 'Test Product',
        'slug' => 'test-product',
        'description' => 'Test description',
        'price' => 199.99,
        'category' => 'test',
        'is_active' => true,
    ]);

    $response = $this->postJson('/wishlist/add', [
        'product_id' => $product->id,
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'count'])
        ->assertJson(['success' => true]);
});

it('renders wishlist from saved products', function () {
    $product = Product::create([
        'name' => 'Dynamic Wishlist Ring',
        'slug' => 'dynamic-wishlist-ring',
        'description' => 'A real saved product.',
        'price' => 199.99,
        'category' => 'ring',
        'is_active' => true,
    ]);

    ProductImage::create([
        'product_id' => $product->id,
        'image_path' => 'products/dynamic-wishlist-ring.jpg',
        'is_primary' => true,
    ]);

    $this->withSession(['wishlist' => [$product->id]]);

    $this->get(route('wishlist.index'))
        ->assertOk()
        ->assertSee('Dynamic Wishlist Ring')
        ->assertDontSee('Celestial Sapphire Ring');
});
