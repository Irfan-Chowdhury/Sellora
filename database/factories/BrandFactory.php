<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name'       => $this->faker->unique()->company(),
            'slug'       => $this->faker->unique()->slug(),
            'is_active'  => $this->faker->boolean(90), // 90% active
        ];
    }
}
