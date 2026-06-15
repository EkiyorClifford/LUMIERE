<?php

namespace Database\Seeders;

use App\Models\CollectionContent;
use Illuminate\Database\Seeder;

class CollectionContentSeeder extends Seeder
{
    public function run(): void
    {
        $collections = [
            [
                'slug' => 'leclat',
                'title' => 'L\'Éclat',
                'description' => 'L\'Éclat celebrates the architecture of brilliance. Each piece is designed to move with light, balancing clean geometry with quiet opulence for evenings that deserve presence.',
                'image_url' => 'https://example.com/leclat.jpg',
                'meta_description' => 'L\'Éclat fine jewelry collection - diamonds and gold with modern elegance.',
                'is_active' => true,
            ],
            [
                'slug' => 'lor',
                'title' => 'L\'Or',
                'description' => 'L\'Or is warmth translated into form. From polished cuffs to tactile textures, each creation is built for layering, daily ritual, and timeless confidence.',
                'image_url' => 'https://example.com/lor.jpg',
                'meta_description' => 'L\'Or collection - luxury gold jewelry designed for everyday wear.',
                'is_active' => true,
            ],
            [
                'slug' => 'la-perle',
                'title' => 'La Perle',
                'description' => 'La Perle explores subtle radiance through carefully matched pearls and clean gold settings. Modern proportions preserve the softness of classic pearl jewelry.',
                'image_url' => 'https://example.com/la-perle.jpg',
                'meta_description' => 'La Perle pearl jewelry - timeless elegance with contemporary design.',
                'is_active' => true,
            ],
        ];

        foreach ($collections as $collection) {
            CollectionContent::updateOrCreate(
                ['slug' => $collection['slug']],
                $collection
            );
        }
    }
}
