<?php

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;

test('shop filters products by category collection price and search term', function () {
    $rings = Category::factory()->create(['name' => 'Rings', 'slug' => 'ring', 'sort_order' => 1]);
    Category::factory()->create(['name' => 'Necklaces', 'slug' => 'necklace', 'sort_order' => 2]);

    $classic = Collection::factory()->create(['name' => 'Classic', 'slug' => 'classic']);
    $modern = Collection::factory()->create(['name' => 'Modern', 'slug' => 'modern']);

    Product::factory()->for($classic)->category($rings->slug)->create([
        'name' => 'Diamond Solitaire Ring',
        'description' => 'A bright diamond engagement ring.',
        'price' => 4200,
        'sort_order' => 1,
    ]);

    Product::factory()->for($modern)->category('necklace')->create([
        'name' => 'Aurelia Gold Necklace',
        'description' => 'A polished gold necklace.',
        'price' => 2800,
        'sort_order' => 2,
    ]);

    $this->get(route('shop', [
        'category' => 'ring',
        'collection' => 'classic',
        'price_min' => 3000,
        'price_max' => 5000,
        'search' => 'solitaire',
    ]))
        ->assertOk()
        ->assertSeeText('Diamond Solitaire Ring')
        ->assertDontSeeText('Aurelia Gold Necklace');
});
