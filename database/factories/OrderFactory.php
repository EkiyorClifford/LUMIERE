<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_number' => 'LM-'.now()->format('Y').'-'.fake()->unique()->numerify('####'),
            'total' => fake()->randomFloat(2, 450, 25000),
            'order_status' => 'pending',
            'shipping_full_name' => fake()->name(),
            'shipping_address' => fake()->streetAddress(),
            'shipping_city' => fake()->city(),
            'shipping_state' => fake()->state(),
            'shipping_postal_code' => fake()->postcode(),
            'shipping_country' => fake()->country(),
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'order_status' => 'paid',
        ]);
    }
}
