<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Rings',
            'Necklaces',
            'Bracelets',
            'Earrings',
            'Bangles',
            'Pendants',
            'Signets',
        ]).' '.fake()->unique()->word();

        return [
            'name' => Str::headline($name),
            'slug' => Str::slug($name),
            'description' => fake()->sentence(10),
            'icon' => fake()->randomElement(['fa-ring', 'fa-gem', 'fa-circle', 'fa-sparkles']),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
