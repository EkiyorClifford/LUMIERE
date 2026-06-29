<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Database\Seeder;

class LuxuryCollectionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or update the luxury collection with your JSON layout engine config
        $collection = Collection::updateOrCreate(
            ['slug' => 'les-elements-or'],
            [
                'name' => 'Les Éléments d\'Or',
                'description' => 'An editorial exploration of raw, sculptural golds and timeless seaside white pearls.',
                'is_active' => true,
                'section_order' => [
                    [
                        'type' => 'hero',
                        'layout' => 'full-cover',
                        'config' => [
                            'title' => 'Les Éléments d\'Or',
                            'subtitle' => 'The Autumn/Winter Collection 2026',
                            'legacy_image' => 'images/diamond_bracelet_paris_night.png'
                        ]
                    ],
                    [
                        'type' => 'story-block',
                        'layout' => 'split-narrative',
                        'config' => [
                            'heading' => 'The Philosophy of Form',
                            'text' => "Our workshop in Paris approaches gold not as a metal, but as liquid light captured in motion.\n\nEach piece remains unpolished at the structural ridges to honor the organic touch of the artisan.",
                            'alignment' => 'left'
                        ]
                    ],
                    [
                        'type' => 'product-grid',
                        'layout' => 'editorial-feed',
                        'config' => []
                    ],
                    [
                        'type' => 'story-block',
                        'layout' => 'split-narrative',
                        'config' => [
                            'heading' => 'The Pearl Selection',
                            'text' => "Every single pearl chosen for this capsule spent a minimum of five years maturing under oceanic surveillance.\n\nOnly one in ten thousand makes it to the Lumière vault.",
                            'alignment' => 'right'
                        ]
                    ]
                ]
            ]
        );

        // 2. Build dummy luxury products matching your precise 'category' and 'collection_id' structure
        Product::updateOrCreate(
            ['slug' => 'or-pur-collier'],
            [
                'name' => 'L\'Or Pur Sculptural Necklace',
                'price' => 14500.00,
                'category' => 'necklaces', // Uses your text category column directly
                'collection_id' => $collection->id, // References the parent collection column
                'description' => 'Handcrafted 18k gold fluid lines.',
                'is_active' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'perle-rare-boucles'],
            [
                'name' => 'Perle Rare Droplet Earrings',
                'price' => 8900.00,
                'category' => 'earrings', // Uses your text category column directly
                'collection_id' => $collection->id, // References the parent collection column
                'description' => 'Sourced South Sea pearls set in white gold.',
                'is_active' => true,
            ]
        );
    }
}