<?php

namespace Tests\Feature;

use App\Models\Delivery;
use App\Models\LoadingOption;
use App\Models\TimeSlot;
use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create necessary related models
        VehicleType::factory()->create();
        LoadingOption::factory()->create();
        TimeSlot::factory()->create();
    }

    public function test_can_list_deliveries(): void
    {
        Delivery::factory()->count(3)->create();

        $response = $this->getJson('/api/deliveries');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_get_single_delivery(): void
    {
        $delivery = Delivery::factory()->create();

        $response = $this->getJson("/api/deliveries/{$delivery->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $delivery->id)
            ->assertJsonPath('data.booking_reference', $delivery->booking_reference);
    }

    public function test_can_create_delivery(): void
    {
        $vehicleType = VehicleType::first();
        $loadingOption = LoadingOption::first();
        $timeSlot = TimeSlot::first();

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '204-555-1234',
            'email' => 'john@example.com',
            'vehicle_type_id' => $vehicleType->id,
            'pickup_date' => now()->addDays(3)->format('Y-m-d'),
            'time_slot_id' => $timeSlot->id,
            'loading_option_id' => $loadingOption->id,
            'pickup_locations' => [
                ['address' => '123 Main St', 'postal_code' => 'R3C 0A1']
            ],
            'delivery_locations' => [
                ['address' => '456 Oak Ave', 'postal_code' => 'R3M 0Y1']
            ],
        ];

        $response = $this->postJson('/api/deliveries', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.first_name', 'John')
            ->assertJsonPath('data.email', 'john@example.com');

        $this->assertDatabaseHas('deliveries', [
            'email' => 'john@example.com',
            'first_name' => 'John',
        ]);
    }

    public function test_can_update_delivery_status(): void
    {
        $delivery = Delivery::factory()->create(['status' => 'pending']);

        $response = $this->patchJson("/api/deliveries/{$delivery->id}/status", [
            'status' => 'confirmed',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'confirmed');

        $this->assertDatabaseHas('deliveries', [
            'id' => $delivery->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_cannot_create_delivery_with_invalid_data(): void
    {
        $response = $this->postJson('/api/deliveries', [
            'first_name' => '',
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'email']);
    }

    public function test_returns_404_for_nonexistent_delivery(): void
    {
        $response = $this->getJson('/api/deliveries/99999');

        $response->assertStatus(404);
    }
}
