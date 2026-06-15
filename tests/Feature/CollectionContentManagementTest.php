<?php

use App\Models\Admin;
use App\Models\Collection;
use App\Models\CollectionContent;
use App\Models\Product;

test('collection page uses active database content when available', function () {
    $collection = Collection::factory()->create([
        'name' => 'Leclat',
        'slug' => 'leclat',
        'description' => 'Fallback collection description.',
        'cover_image' => 'images/fallback-cover.jpg',
    ]);

    Product::factory()->for($collection)->create([
        'name' => 'Radiant Test Ring',
        'slug' => 'radiant-test-ring',
        'price' => 1250,
        'sort_order' => 1,
    ]);

    CollectionContent::create([
        'slug' => 'leclat',
        'title' => 'Editorial Leclat',
        'description' => 'Database editorial story for the collection.',
        'image_url' => 'https://example.com/editorial-leclat.jpg',
        'meta_description' => 'Private styling for Leclat.',
        'is_active' => true,
    ]);

    $response = $this->get(route('collections.show', $collection->slug));

    $response
        ->assertOk()
        ->assertSee('EDITORIAL LECLAT COLLECTION')
        ->assertSee('Database editorial story for the collection.')
        ->assertSee('https://example.com/editorial-leclat.jpg', false)
        ->assertSee('Private styling for Leclat.');
});

test('collection page falls back to collection content when database content is inactive', function () {
    $collection = Collection::factory()->create([
        'name' => 'LOr',
        'slug' => 'lor',
        'description' => 'The fallback story remains visible.',
        'cover_image' => 'images/lor-cover.jpg',
    ]);

    CollectionContent::create([
        'slug' => 'lor',
        'title' => 'Hidden Editorial',
        'description' => 'This inactive content should not render.',
        'is_active' => false,
    ]);

    $response = $this->get(route('collections.show', $collection->slug));

    $response
        ->assertOk()
        ->assertSee('The fallback story remains visible.')
        ->assertDontSee('This inactive content should not render.');
});

test('admin can create update toggle and delete collection content', function () {
    $admin = Admin::create([
        'name' => 'Lumiere Admin',
        'email' => 'admin@lumiere.test',
        'password' => 'molotov',
        'role' => 'superadmin',
    ]);

    $this->actingAs($admin, 'admin');

    $this->post(route('admin.collection-contents.store'), [
        'slug' => 'la-perle',
        'title' => 'La Perle',
        'description' => 'Pearl-led editorial copy.',
        'image_url' => 'https://example.com/la-perle.jpg',
        'meta_description' => 'Pearl styling support.',
        'is_active' => '1',
    ])->assertRedirect(route('admin.collection-contents.index'));

    $content = CollectionContent::where('slug', 'la-perle')->firstOrFail();

    expect($content->is_active)->toBeTrue();

    $this->get(route('admin.collection-contents.index'))
        ->assertOk()
        ->assertSee('la-perle')
        ->assertSee('La Perle');

    $this->patch(route('admin.collection-contents.update', $content), [
        'title' => 'La Perle Updated',
        'description' => 'Updated pearl-led editorial copy.',
        'image_url' => 'https://example.com/la-perle-updated.jpg',
        'meta_description' => 'Updated pearl styling support.',
    ])->assertRedirect(route('admin.collection-contents.index'));

    expect($content->refresh())
        ->title->toBe('La Perle Updated')
        ->is_active->toBeFalse();

    $this->patch(route('admin.collection-contents.toggle-active', $content))
        ->assertRedirect();

    expect($content->refresh()->is_active)->toBeTrue();

    $this->delete(route('admin.collection-contents.destroy', $content))
        ->assertRedirect(route('admin.collection-contents.index'));

    expect(CollectionContent::where('slug', 'la-perle')->exists())->toBeFalse();
});
