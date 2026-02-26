<?php

namespace Database\Factories;

use App\Models\LoadingOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoadingOptionFactory extends Factory
{
    protected $model = LoadingOption::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Self Loading', 'Assisted Loading', 'Full Service']),
            'description' => $this->faker->sentence(),
            'additional_fee' => $this->faker->randomFloat(2, 0, 50),
            'is_active' => true,
        ];
    }

    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Self Loading',
            'additional_fee' => 0,
        ]);
    }
}
