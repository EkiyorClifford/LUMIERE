<?php

use Database\Seeders\CategorySeeder;
use Database\Seeders\CollectionSeeder;
use Database\Seeders\ProductSeeder;

test('catalog seeders create browseable demo products with relationships', function () {
    $this->seed([
        CategorySeeder::class,
        CollectionSeeder::class,
        ProductSeeder::class,
    ]);

    $this->assertDatabaseHas('categories', [
        'slug' => 'ring',
        'name' => 'Rings',
    ]);

    $this->assertDatabaseHas('collections', [
        'slug' => 'leclat',
        'name' => "L'Éclat",
    ]);

    $this->assertDatabaseHas('products', [
        'slug' => 'diamond-solitaire-ring',
        'category' => 'ring',
    ]);

    $this->assertDatabaseHas('product_variants', [
        'sku' => 'LM-RNG-SOL-52',
    ]);

    $this->assertDatabaseHas('product_images', [
        'is_primary' => true,
    ]);
});
