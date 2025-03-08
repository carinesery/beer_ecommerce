<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
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
        return [
            'product_id' => fake()->numberBetween(1, 50),
            'slug' => fake()->slug(),
            'volume' => fake()->randomElement(['25 cL', '33 cL', '75 cL', '6 x 25 cL', '6 x 33 cL']),
            'stock_quantity' => fake()->numberBetween(1, 100),
            'price_without_tax' => fake()->numberBetween(200, 10000),
            'tax_amount' => fake()->randomElement([20]),
            'available' => fake()->boolean(chanceOfGettingTrue:90),
        ];
    }
}
