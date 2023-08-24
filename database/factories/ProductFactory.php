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
            'name' => fake()->sentence(2),
            'description' => fake()->text(),
            'price' => fake()->randomDigitNotZero(),
            'image_url' => fake()->imageUrl('200', '200'),
        ];
    }
}
