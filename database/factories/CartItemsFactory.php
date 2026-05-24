<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CartItems>
 */
class CartItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'product_id' => Product::factory(),
            'variant_id' => null,
            'quantity' => fake()->numberBetween(1, 4),
        ];
    }
}
