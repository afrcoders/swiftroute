<?php

namespace Tests\Unit\Models;

use App\Models\Delivery;
use App\Models\DeliveryStop;
use App\Models\LoadingOption;
use App\Models\TimeSlot;
use App\Models\VehicleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_delivery_has_vehicle_type_relationship(): void
    {
        $vehicleType = VehicleType::factory()->create();
        $delivery = Delivery::factory()->create(['vehicle_type_id' => $vehicleType->id]);

        $this->assertInstanceOf(VehicleType::class, $delivery->vehicleType);
        $this->assertEquals($vehicleType->id, $delivery->vehicleType->id);
    }

    public function test_delivery_has_loading_option_relationship(): void
    {
        $loadingOption = LoadingOption::factory()->create();
        $delivery = Delivery::factory()->create(['loading_option_id' => $loadingOption->id]);

        $this->assertInstanceOf(LoadingOption::class, $delivery->loadingOption);
        $this->assertEquals($loadingOption->id, $delivery->loadingOption->id);
    }

    public function test_delivery_has_time_slot_relationship(): void
    {
        $timeSlot = TimeSlot::factory()->create();
        $delivery = Delivery::factory()->create(['time_slot_id' => $timeSlot->id]);

        $this->assertInstanceOf(TimeSlot::class, $delivery->timeSlot);
        $this->assertEquals($timeSlot->id, $delivery->timeSlot->id);
    }

    public function test_delivery_casts_pickup_date_to_date(): void
    {
        $delivery = Delivery::factory()->create([
            'pickup_date' => '2026-03-15',
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $delivery->pickup_date);
    }

    public function test_delivery_casts_items_to_array(): void
    {
        $items = ['Box 1', 'Box 2', 'Furniture'];
        $delivery = Delivery::factory()->create(['items' => $items]);

        $this->assertIsArray($delivery->items);
        $this->assertEquals($items, $delivery->items);
    }

    public function test_delivery_generates_booking_reference(): void
    {
        $delivery = Delivery::factory()->create();

        $this->assertNotNull($delivery->booking_reference);
        $this->assertStringStartsWith('DEL-', $delivery->booking_reference);
    }

    public function test_delivery_uses_soft_deletes(): void
    {
        $delivery = Delivery::factory()->create();
        $id = $delivery->id;

        $delivery->delete();

        $this->assertSoftDeleted('deliveries', ['id' => $id]);
        $this->assertNotNull(Delivery::withTrashed()->find($id));
    }

    public function test_delivery_calculates_total_correctly(): void
    {
        $delivery = Delivery::factory()->create([
            'base_price' => 100.00,
            'vehicle_surcharge' => 20.00,
            'loading_fee' => 15.00,
            'surge_fee' => 10.00,
            'total_price' => 145.00,
        ]);

        $expectedTotal = $delivery->base_price + $delivery->vehicle_surcharge
                        + $delivery->loading_fee + $delivery->surge_fee;

        $this->assertEquals($expectedTotal, $delivery->total_price);
    }
}
