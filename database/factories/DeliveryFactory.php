<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\LoadingOption;
use App\Models\TimeSlot;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeliveryFactory extends Factory
{
    protected $model = Delivery::class;

    public function definition(): array
    {
        return [
            'booking_reference' => 'DEL-' . strtoupper(Str::random(8)),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'vehicle_type_id' => VehicleType::factory(),
            'pickup_date' => $this->faker->dateTimeBetween('+1 day', '+30 days'),
            'time_slot_id' => TimeSlot::factory(),
            'loading_option_id' => LoadingOption::factory(),
            'distance_km' => $this->faker->randomFloat(2, 5, 50),
            'base_price' => $this->faker->randomFloat(2, 50, 200),
            'loading_fee' => $this->faker->randomFloat(2, 0, 50),
            'vehicle_surcharge' => $this->faker->randomFloat(2, 0, 100),
            'surge_fee' => 0,
            'total_price' => $this->faker->randomFloat(2, 100, 400),
            'status' => 'pending',
            'customer_notes' => $this->faker->optional()->sentence(),
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
