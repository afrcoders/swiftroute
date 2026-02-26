<?php

namespace Tests\Unit\Services;

use App\Models\LoadingOption;
use App\Models\PricingRule;
use App\Models\VehicleType;
use App\Services\PricingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PricingService $pricingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pricingService = new PricingService();
    }

    public function test_calculate_base_price_with_minimum_charge(): void
    {
        // Set up pricing rules
        PricingRule::create(['key' => 'base_fee', 'value' => 25.00]);
        PricingRule::create(['key' => 'price_per_km', 'value' => 2.00]);
        PricingRule::create(['key' => 'minimum_charge', 'value' => 50.00]);

        // 5km distance: 25 + (2 * 5) = 35, but minimum is 50
        $price = $this->pricingService->calculateBasePrice(5.0);

        $this->assertEquals(50.00, $price);
    }

    public function test_calculate_base_price_above_minimum(): void
    {
        PricingRule::create(['key' => 'base_fee', 'value' => 25.00]);
        PricingRule::create(['key' => 'price_per_km', 'value' => 2.00]);
        PricingRule::create(['key' => 'minimum_charge', 'value' => 50.00]);

        // 20km distance: 25 + (2 * 20) = 65
        $price = $this->pricingService->calculateBasePrice(20.0);

        $this->assertEquals(65.00, $price);
    }

    public function test_calculate_vehicle_surcharge_with_multiplier(): void
    {
        $vehicleType = VehicleType::factory()->create([
            'name' => 'Large Van',
            'price_multiplier' => 1.5,
        ]);

        // Base price 100, multiplier 1.5 means 50% surcharge
        $surcharge = $this->pricingService->calculateVehicleSurcharge(100.00, $vehicleType);

        $this->assertEquals(50.00, $surcharge);
    }

    public function test_calculate_vehicle_surcharge_no_multiplier(): void
    {
        $vehicleType = VehicleType::factory()->create([
            'name' => 'Standard',
            'price_multiplier' => 1.0,
        ]);

        $surcharge = $this->pricingService->calculateVehicleSurcharge(100.00, $vehicleType);

        $this->assertEquals(0.00, $surcharge);
    }

    public function test_calculate_surge_fee_when_enabled(): void
    {
        PricingRule::create(['key' => 'surge_percentage', 'value' => 20]);

        $surgeFee = $this->pricingService->calculateSurgeFee(100.00, '2026-03-01');

        $this->assertEquals(20.00, $surgeFee);
    }

    public function test_calculate_surge_fee_when_disabled(): void
    {
        PricingRule::create(['key' => 'surge_percentage', 'value' => 0]);

        $surgeFee = $this->pricingService->calculateSurgeFee(100.00, '2026-03-01');

        $this->assertEquals(0.00, $surgeFee);
    }

    public function test_calculate_total_returns_complete_breakdown(): void
    {
        PricingRule::create(['key' => 'base_fee', 'value' => 25.00]);
        PricingRule::create(['key' => 'price_per_km', 'value' => 2.00]);
        PricingRule::create(['key' => 'minimum_charge', 'value' => 50.00]);
        PricingRule::create(['key' => 'surge_percentage', 'value' => 10]);

        $vehicleType = VehicleType::factory()->create([
            'price_multiplier' => 1.2,
        ]);

        $loadingOption = LoadingOption::factory()->create([
            'additional_fee' => 15.00,
        ]);

        // 25km: base = 25 + (2 * 25) = 75
        // vehicle surcharge = 75 * 0.2 = 15
        // loading = 15
        // surge = 75 * 0.1 = 7.5
        // total = 75 + 15 + 15 + 7.5 = 112.5
        $result = $this->pricingService->calculateTotal(
            25.0,
            $vehicleType,
            $loadingOption,
            '2026-03-01'
        );

        $this->assertArrayHasKey('distance_km', $result);
        $this->assertArrayHasKey('base_price', $result);
        $this->assertArrayHasKey('vehicle_surcharge', $result);
        $this->assertArrayHasKey('loading_fee', $result);
        $this->assertArrayHasKey('surge_fee', $result);
        $this->assertArrayHasKey('total_price', $result);

        $this->assertEquals(25.0, $result['distance_km']);
        $this->assertEquals(75.00, $result['base_price']);
        $this->assertEquals(15.00, $result['vehicle_surcharge']);
        $this->assertEquals(15.00, $result['loading_fee']);
        $this->assertEquals(7.50, $result['surge_fee']);
        $this->assertEquals(112.50, $result['total_price']);
    }
}
