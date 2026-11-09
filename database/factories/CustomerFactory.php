<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'age' => fake()->numberBetween(5, 80),
            'contact_number' => fake()->numerify('09#########'),
            'address' => fake()->address(),
        ];
    }
}
