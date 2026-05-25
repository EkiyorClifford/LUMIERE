<?php

use App\Models\Collection;
use App\Models\Product;
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

    Collection::query()
        ->pluck('cover_image')
        ->each(function (string $coverImage): void {
            $this->assertFileExists(public_path($coverImage));
        });
});

test('product seeder restores soft deleted seeded products by slug', function () {
    $this->seed(CollectionSeeder::class);

    $collection = Collection::where('slug', 'lor')->firstOrFail();
    Product::factory()->for($collection)->create([
        'name' => 'Archived Aurelia',
        'slug' => 'aurelia-gold-necklace',
        'category' => 'necklace',
    ])->delete();

    $this->seed(ProductSeeder::class);

    expect(Product::withTrashed()->where('slug', 'aurelia-gold-necklace')->count())->toBe(1);
    expect(Product::where('slug', 'aurelia-gold-necklace')->exists())->toBeTrue();
});
