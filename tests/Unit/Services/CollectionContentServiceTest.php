<?php

use App\Models\CollectionContent;
use App\Services\CollectionContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('service returns only active collection content by slug', function () {
    $service = app(CollectionContentService::class);

    CollectionContent::create([
        'slug' => 'leclat',
        'title' => 'Active Leclat',
        'description' => 'Visible copy.',
        'is_active' => true,
    ]);

    CollectionContent::create([
        'slug' => 'lor',
        'title' => 'Inactive Lor',
        'description' => 'Hidden copy.',
        'is_active' => false,
    ]);

    expect($service->getBySlug('leclat'))->not->toBeNull()
        ->and($service->getBySlug('lor'))->toBeNull();
});

test('service creates updates lists deletes and toggles content', function () {
    $service = app(CollectionContentService::class);

    $content = $service->createOrUpdate([
        'slug' => 'la-perle',
        'title' => 'La Perle',
        'description' => 'Pearl story.',
        'image_url' => null,
        'meta_description' => null,
        'is_active' => true,
    ]);

    expect($content)
        ->slug->toBe('la-perle')
        ->title->toBe('La Perle');

    $updated = $service->createOrUpdate([
        'slug' => 'la-perle',
        'title' => 'La Perle Updated',
        'description' => 'Updated pearl story.',
        'image_url' => 'https://example.com/la-perle.jpg',
        'meta_description' => 'Updated meta.',
        'is_active' => true,
    ]);

    expect($updated->id)->toBe($content->id)
        ->and($updated->title)->toBe('La Perle Updated')
        ->and($service->getAllActive())->toHaveCount(1);

    $service->toggleActive('la-perle');

    expect($updated->refresh()->is_active)->toBeFalse()
        ->and($service->getAllActive())->toHaveCount(0)
        ->and($service->delete('la-perle'))->toBeTrue()
        ->and(CollectionContent::where('slug', 'la-perle')->exists())->toBeFalse();
});
