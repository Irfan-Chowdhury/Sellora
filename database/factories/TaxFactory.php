<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class TaxFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'name'      => ucfirst($name),             // Example: "VAT", "Income", etc.
            'rate'      => $this->faker->numberBetween(1, 50), // Rate in percentage
            'is_active' => $this->faker->boolean(80),  // 80% active
        ];
    }
}
