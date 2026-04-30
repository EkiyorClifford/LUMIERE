<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Craftsmanship',
                'slug' => 'craftsmanship',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ethics & Sourcing',
                'slug' => 'ethics-sourcing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'People',
                'slug' => 'people',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
