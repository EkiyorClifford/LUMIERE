<?php

namespace Database\Factories;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Collection>
 */
class CollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Classic',
            'Modern',
            'Bridal',
            'Maison',
            'Atelier',
            'High Jewellery',
        ]).' '.fake()->unique()->word();

        return [
            'name' => Str::headline($name),
            'slug' => Str::slug($name),
            'description' => fake()->sentence(12),
            'cover_image' => fake()->imageUrl(1600, 1200, 'jewelry', true),
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
