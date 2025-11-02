<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{

    public function definition(): array
    {
        // $name = $this->faker->unique()->word();
        $name = $this->faker->unique()->words(5, true);

        return [
            'name'      => ucfirst($name),
            'slug'      => Str::slug($name),
            'is_active' => $this->faker->boolean(80), // 80% active
        ];
    }
}
