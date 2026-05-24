<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::factory();

        return [
            'order_id' => Order::factory(),
            'product_id' => $product,
            'quantity' => fake()->numberBetween(1, 3),
            'product_name' => fake()->words(3, true),
            'variant_label' => fake()->optional()->randomElement(['Ring size 52', '18k Yellow Gold', '45 cm']),
            'price' => fake()->randomFloat(2, 450, 15000),
        ];
    }
}
