<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'craftsmanship' => 'Craftsmanship',
            'ethics-sourcing' => 'Ethics & Sourcing',
            'lifestyle' => 'Lifestyle',
            'people' => 'People',
        ];

        foreach ($categories as $slug => $name) {
            PostCategory::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }
    }
}
