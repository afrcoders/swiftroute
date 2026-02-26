<?php

namespace Database\Factories;

use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleTypeFactory extends Factory
{
    protected $model = VehicleType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Standard Van', 'Large Van', 'Truck', 'Motorcycle']),
            'description' => $this->faker->sentence(),
            'price_multiplier' => $this->faker->randomFloat(2, 1.0, 2.0),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
