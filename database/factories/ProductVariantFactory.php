<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['size', 'material', 'stone']);
        $value = match ($type) {
            'size' => (string) fake()->randomElement([48, 50, 52, 54, 56, 58]),
            'material' => fake()->randomElement(['18k-yellow-gold', '18k-white-gold', '18k-rose-gold']),
            default => fake()->randomElement(['diamond', 'sapphire', 'emerald']),
        };

        return [
            'product_id' => Product::factory(),
            'label' => str($value)->replace('-', ' ')->headline()->toString(),
            'type' => $type,
            'value' => $value,
            'price_modifier' => fake()->randomFloat(2, -250, 1500),
            'stock' => fake()->numberBetween(0, 12),
            'sku' => 'LM-'.fake()->unique()->bothify('???-####'),
        ];
    }
}
