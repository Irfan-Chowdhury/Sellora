<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'code' => $this->faker->word,
            'base_unit' => $this->faker->randomElement([null, 1, 2, 3, 4]), // random null or any base unit ID
            'operator' => $this->faker->randomElement(['*', '/']),
            'operation_value' => $this->faker->randomFloat(2, 1, 1000), // Random float value for operation_value
            'is_active' => $this->faker->boolean, // Random boolean value for is_active
        ];
    }
}
