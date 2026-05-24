<?php

use App\Models\Product;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

it('renders the product detail page for an active product', function () {
    Schema::dropIfExists('collections');
    Schema::create('collections', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->timestamps();
    });

    Schema::dropIfExists('products');
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('collection_id')->nullable();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->string('category');
        $table->boolean('is_active')->default(true);
        $table->softDeletes();
        $table->timestamps();
    });

    Schema::dropIfExists('product_images');
    Schema::create('product_images', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->text('image_path');
        $table->boolean('is_primary')->default(false);
        $table->integer('sort_order')->default(0);
        $table->timestamps();
    });

    Schema::dropIfExists('product_attributes');
    Schema::create('product_attributes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->string('name');
        $table->string('value');
        $table->timestamps();
    });

    Schema::dropIfExists('product_variants');
    Schema::create('product_variants', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->string('name');
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });

    Schema::dropIfExists('reviews');
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->unsignedBigInteger('user_id')->nullable();
        $table->text('content')->nullable();
        $table->integer('rating')->nullable();
        $table->timestamps();
    });

    $collectionId = DB::table('collections')->insertGetId([
        'name' => 'Test Collection',
        'slug' => 'test-collection',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $product = Product::create([
        'name' => 'Test Product',
        'slug' => 'test-product',
        'description' => 'This is a test product description.',
        'price' => 299.99,
        'category' => 'ring',
        'is_active' => true,
        'collection_id' => $collectionId,
    ]);

    DB::table('product_images')->insert([
        'product_id' => $product->id,
        'image_path' => 'https://example.com/test-product.jpg',
        'is_primary' => true,
        'sort_order' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->get(route('product.show', $product));

    $response->assertStatus(200);
    $response->assertSeeText('Test Product');
    $response->assertSeeText('This is a test product description.');
    $response->assertSee('https://example.com/test-product.jpg');
});
