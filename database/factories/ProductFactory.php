<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        return [
            'category_id' => fake()->numberBetween(1, 4),
            'brand_id' => fake()->numberBetween(1, 4),
            'slug' => fake()->slug(),
            'name' => fake()->word(),
            'description' => fake()->sentence(12),
            'alcohol_degree' => fake()->numberBetween(0, 15),
            'image' => fake()->imageUrl(), //'image' => substr(fake()->imageUrl(), 0, 255),
        ]; 
    }
}
