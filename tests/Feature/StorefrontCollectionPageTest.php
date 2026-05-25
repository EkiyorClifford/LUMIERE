<?php

use App\Models\Collection;
use App\Models\Product;

test('collection detail page uses public atelier booking and configured currency', function () {
    config(['lumiere.currency_symbol' => '£']);

    $collection = Collection::factory()->create([
        'name' => "L'Eclat",
        'slug' => 'leclat',
        'cover_image' => 'images/collection_diamond_essence.png',
    ]);

    Product::factory()->for($collection)->create([
        'name' => 'Diamond Solitaire Ring',
        'slug' => 'diamond-solitaire-ring',
        'price' => 3450,
        'category' => 'ring',
        'sort_order' => 1,
    ]);

    $response = $this->get(route('collections.show', $collection->slug));

    $response
        ->assertOk()
        ->assertSee('href="'.route('atelier').'"', false)
        ->assertDontSee('href="'.route('profile.show').'"', false)
        ->assertSee('£3,450', false)
        ->assertSee('LUMIÈRE', false)
        ->assertSee('id="mobile-menu"', false)
        ->assertSee('id="menu-open"', false)
        ->assertSee('href="'.route('wishlist.index').'"', false);
});
