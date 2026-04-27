<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        //address
        Schema::create('addresses', function (Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained()->nullOnDelete();
            $table->enum('address_type', ['home', 'work', 'other'])->default('home');//home, work, etc.
            $table->string('phone')->nullable();
            $table->string('address_line');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code')->nullable();
            $table->string('country');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        //collections        
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->foreignId('collection_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('category', ['ring', 'necklace', 'bracelet', 'earrings', 'bangle'])->default('bangle');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->string('slug')->unique();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        //product variants
        Schema::create('product_variants', function (Blueprint $table){
            $table->id();
            $table->foreignId('product_id')->constrained()->nullOnDelete();
            $table->string('label');//"Size", "Color", "Material"
            $table->enum('type', ['size', 'length', 'width', 'height', 'weight', 'color', 'material'])->default('size');//"size", "length", "width", "height", "weight", "color", "material"
            $table->string('value');// "S", "M", "L", "XL" or "Red", "Blue", "Green"
            $table->decimal('price_modifier', 10, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->string('sku')->unique();
            $table->timestamps();
        });

        //FOR PRODUCT IMAGES
        Schema::create('product_images', function (Blueprint $table){
            $table->id();
            $table->foreignId('product_id')->constrained()->nullOnDelete();
            $table->string('image_path');
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        //product attributes
        Schema::create('product_attributes', function (Blueprint $table){
            $table->id();
            $table->foreignId('product_id')->constrained()->nullOnDelete();
            $table->string('key');//e.g. "color", "size"
            $table->string('value');//e.g. "red", "M"
            $table->string('unit')->nullable();//e.g. "mm", "cm", "kg"
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        //ORDERS
        Schema::create('orders', function (Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained()->nullOnDelete();
            $table->decimal('total', 10, 2);
            $table->enum('order_status', ['pending', 'paid', 'shipped', 'completed', 'cancelled'])->default('pending');

            //snapshot of address at time of order
            $table->string('shipping_full_name')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_country')->nullable();

            //snapshot of billing address at time of order
            $table->string('billing_full_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_postal_code')->nullable();
            $table->string('billing_country')->nullable();

            $table->timestamps();

        });

        //order items
        //it should have a snapshot of the product at time of order
        Schema::create('order_items', function (Blueprint $table){
            $table->id();
            $table->foreignId('order_id')->constrained()->nullOnDelete();
            $table->foreignId('product_id')->constrained()->nullOnDelete();
            $table->integer('quantity');
            $table->string('product_name');
            $table->string('variant_label')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        //payments
        Schema::create('payments', function (Blueprint $table){
            $table->id();
            $table->foreignId('order_id')->constrained()->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method');// credit_card, paypal, bank_transfer, cod
            $table->string('provider');
            $table->string('currency')->default('USD');
            $table->string('payment_reference')->unique();
            $table->json('gateway_response')->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });

        //shipping
        Schema::create('shipments', function (Blueprint $table){
            $table->id();
            $table->foreignId('order_id')->constrained()->nullOnDelete();
            $table->string('shipping_method');// standard, express, overnight
            $table->string('carrier');
            $table->string('tracking_number')->unique();
            $table->enum('status', ['pending', 'shipped', 'delivered'])->default('pending');
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        //reviews
        Schema::create('reviews', function (Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained()->nullOnDelete();
            $table->foreignId('product_id')->constrained()->nullOnDelete();
            $table->integer('rating');//1-5
            $table->text('comment')->nullable();
            $table->boolean('is_verified_purchase')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });

        //softdeletes
        Schema::table('users', function (Blueprint $table){
            $table->softDeletes();
        });
        Schema::table('products', function (Blueprint $table){
            $table->softDeletes();
        });
        Schema::table('orders', function (Blueprint $table){
            $table->softDeletes();
        });

        Schema::table('product_attributes', function (Blueprint $table){
            $table->softDeletes();
        });
        
        Schema::table('reviews', function (Blueprint $table){
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('products');        // products depends on collections
        Schema::dropIfExists('collections');     // drop after products
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};

