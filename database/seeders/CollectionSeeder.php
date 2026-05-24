<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $collections = $this->collections();

        // Remove collections that are no longer in seeder
        Collection::whereNotIn('slug', array_keys($collections))->delete();

        foreach ($collections as $slug => $attributes) {
            Collection::updateOrCreate(
                ['slug' => $slug],
                $attributes + [
                    'slug' => $slug,
                    'is_active' => true,
                ]
            );
        }
    }

    private function collections(): array
    {
        return [
            'leclat' => [
                'name' => "L'Éclat",
                'description' => 'The brilliance collection. Flawless diamonds set in 18k gold, each stone hand-selected for its fire and clarity. Pieces that catch every light in every room.',
                'cover_image' => 'images/diamond_midnight_luxury.png',
                'sort_order' => 10,
            ],

            'lor' => [
                'name' => "L'Or",
                'description' => "Pure warmth in every form. Sculpted in 18k and 22k gold by master artisans who have spent lifetimes understanding the metal's temperament.",
                'cover_image' => 'images/gold_ring_lifestyle.png',
                'sort_order' => 20,
            ],

            'la-perle' => [
                'name' => 'LA PERLE',
                'description' => "The ocean's quiet luxury. South Sea and Akoya pearls, sourced from sustainable farms, set in gold to frame their natural luminescence.",
                'cover_image' => 'images/pearl_prod_pendant.png',
                'sort_order' => 30,
            ],
        ];
    }
}
