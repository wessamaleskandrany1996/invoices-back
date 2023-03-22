<?php

namespace Database\Factories;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => Str::random(10),
            'total' => fake()->numberBetween(1.0, 999.1000),
            'paid' => fake()->randomDigitNotZero(),
            'status' => fake()->randomElement(array('postponed', 'paid')),
            'type' => fake()->randomElement(array('purchases', 'sales')),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
