<?php

namespace Database\Factories;

use App\Models\Category;
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
    public function definition()
    {
        return [
            'name' => fake()->word(),
            'sell_price' => fake()->numberBetween(21,30),
            'amount'=>fake()->numberBetween(0,1000),
            'category_id'=> Category::all()->random()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
