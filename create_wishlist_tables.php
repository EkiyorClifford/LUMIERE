<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Kernel::class)->bootstrap();

// Create wishlists and wishlist_items tables
Schema::create('wishlists', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->timestamps();
});

Schema::create('wishlist_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('wishlist_id')->constrained('wishlists')->cascadeOnDelete();
    $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
    $table->timestamps();
});

echo "Wishlist tables created successfully\n";
