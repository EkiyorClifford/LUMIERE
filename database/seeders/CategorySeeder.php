<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->categories() as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            );
        }
    }

    /**
     * @return list<array{name: string, slug: string, description: string, icon: string, is_active: bool, sort_order: int}>
     */
    private function categories(): array
    {
        return [
            ['name' => 'Rings', 'slug' => 'ring', 'description' => 'Engagement, signet, and cocktail rings.', 'icon' => 'fa-ring', 'is_active' => true, 'sort_order' => 10],
            ['name' => 'Necklaces', 'slug' => 'necklace', 'description' => 'Pendants, chains, and high-jewelry necklaces.', 'icon' => 'fa-gem', 'is_active' => true, 'sort_order' => 20],
            ['name' => 'Bracelets', 'slug' => 'bracelet', 'description' => 'Tennis bracelets and sculptural cuffs.', 'icon' => 'fa-circle', 'is_active' => true, 'sort_order' => 30],
            ['name' => 'Earrings', 'slug' => 'earrings', 'description' => 'Studs, drops, and statement earrings.', 'icon' => 'fa-sparkles', 'is_active' => true, 'sort_order' => 40],
            ['name' => 'Bangles', 'slug' => 'bangle', 'description' => 'Stacking bangles and carved gold forms.', 'icon' => 'fa-circle-notch', 'is_active' => true, 'sort_order' => 50],
        ];
    }
}
