<?php

namespace Tests\Feature;

use App\Models\LoadingOption;
use App\Models\PricingRule;
use App\Models\TimeSlot;
use App\Models\VehicleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up pricing rules
        PricingRule::create(['key' => 'base_fee', 'value' => 25.00]);
        PricingRule::create(['key' => 'price_per_km', 'value' => 2.00]);
        PricingRule::create(['key' => 'minimum_charge', 'value' => 50.00]);
        PricingRule::create(['key' => 'surge_percentage', 'value' => 0]);
    }

    public function test_can_list_vehicle_types(): void
    {
        VehicleType::factory()->count(3)->create();

        $response = $this->getJson('/api/vehicle-types');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_list_time_slots(): void
    {
        TimeSlot::factory()->count(4)->create();

        $response = $this->getJson('/api/time-slots');

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data');
    }

    public function test_can_list_loading_options(): void
    {
        LoadingOption::factory()->count(3)->create();

        $response = $this->getJson('/api/loading-options');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_calculate_pricing(): void
    {
        $vehicleType = VehicleType::factory()->create(['price_multiplier' => 1.0]);

        $response = $this->postJson('/api/pricing/calculate', [
            'pickup_locations' => [
                ['address' => '123 Main St', 'postal_code' => 'R3C 0A1']
            ],
            'delivery_locations' => [
                ['address' => '456 Oak Ave', 'postal_code' => 'R3M 0Y1']
            ],
            'vehicle_type_id' => $vehicleType->id,
            'pickup_date' => now()->addDays(3)->format('Y-m-d'),
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'distance_km',
                    'base_price',
                    'vehicle_surcharge',
                    'total_price',
                ]
            ]);
    }

    public function test_pricing_calculation_requires_valid_data(): void
    {
        $response = $this->postJson('/api/pricing/calculate', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['pickup_locations', 'delivery_locations', 'vehicle_type_id']);
    }

    public function test_only_active_vehicle_types_returned(): void
    {
        VehicleType::factory()->count(2)->create(['is_active' => true]);
        VehicleType::factory()->create(['is_active' => false]);

        $response = $this->getJson('/api/vehicle-types');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_only_active_time_slots_returned(): void
    {
        TimeSlot::factory()->count(3)->create(['is_active' => true]);
        TimeSlot::factory()->create(['is_active' => false]);

        $response = $this->getJson('/api/time-slots');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }
}
