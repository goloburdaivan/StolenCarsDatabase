<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auto>
 */
class AutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vin_code' => fake()->word(),
            'plate_number' => fake()->word(),
            'brand' => fake()->word(),
            'model' => fake()->word(),
            'year' => fake()->randomDigit(),
            'color' => fake()->word(),
            'name' => fake()->word(),
        ];
    }
}
