<?php

namespace Database\Factories;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Diamond Solitaire Ring',
            'Aurelia Gold Necklace',
            'Odette Pearl Drop Earrings',
            'Maison Knot Signet',
            'Celestial Sapphire Ring',
            'Marquise Tennis Bracelet',
        ]).' '.fake()->unique()->bothify('##');

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(3),
            'price' => fake()->randomFloat(2, 450, 15000),
            'collection_id' => Collection::factory(),
            'category' => fake()->randomElement(['rings', 'necklaces', 'earrings', 'bracelets', 'pendants']),
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

    public function category(string $slug): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $slug,
        ]);
    }
}
