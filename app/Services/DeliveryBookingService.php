<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\LoadingOption;
use App\Models\VehicleType;
use App\Repositories\Contracts\DeliveryRepositoryInterface;
use Illuminate\Support\Facades\Session;

class DeliveryBookingService
{
    public function __construct(
        protected DeliveryRepositoryInterface $deliveryRepo,
        protected PricingService $pricingService,
        protected DistanceService $distanceService,
        protected GeographyService $geographyService,
    ) {}

    /**
     * Process Step 1: Validate, calculate distance, store in session.
     */
    public function processStep1(array $data): array
    {
        // Build addresses for distance calculation
        $pickupAddresses = [];
        foreach ($data['pickup_locations'] as $loc) {
            $pickupAddresses[] = $loc['address'] . ', ' . $loc['postal_code'] . ', Winnipeg, MB, Canada';
        }

        $deliveryAddresses = [];
        foreach ($data['delivery_locations'] as $loc) {
            $deliveryAddresses[] = $loc['address'] . ', ' . $loc['postal_code'] . ', Winnipeg, MB, Canada';
        }

        // Calculate distance
        $distanceKm = $this->distanceService->calculateMultiStopDistance($pickupAddresses, $deliveryAddresses);

        // Get vehicle type
        $vehicleType = VehicleType::findOrFail($data['vehicle_type_id']);

        // Calculate initial base price (without loading option yet)
        $basePrice = $this->pricingService->calculateBasePrice($distanceKm);
        $vehicleSurcharge = $this->pricingService->calculateVehicleSurcharge($basePrice, $vehicleType);
        $surgeFee = $this->pricingService->calculateSurgeFee($basePrice, $data['pickup_date']);

        $sessionData = [
            'step1' => [
                'pickup_locations' => $data['pickup_locations'],
                'delivery_locations' => $data['delivery_locations'],
                'vehicle_type_id' => $data['vehicle_type_id'],
                'pickup_date' => $data['pickup_date'],
                'time_slot_id' => $data['time_slot_id'],
                'distance_km' => $distanceKm,
                'base_price' => $basePrice,
                'vehicle_surcharge' => $vehicleSurcharge,
                'surge_fee' => $surgeFee,
                'display_price' => $basePrice + $vehicleSurcharge + $surgeFee,
            ],
            'completed_steps' => [1],
        ];

        Session::put('delivery_booking', $sessionData);

        return $sessionData['step1'];
    }

    /**
     * Process Step 2: Loading option selection, update pricing.
     */
    public function processStep2(array $data): array
    {
        $sessionData = Session::get('delivery_booking');
        $step1 = $sessionData['step1'];

        $loadingOption = LoadingOption::findOrFail($data['loading_option_id']);
        $vehicleType = VehicleType::findOrFail($step1['vehicle_type_id']);

        // Recalculate properly with loading option
        $pricing = $this->pricingService->calculateTotal(
            $step1['distance_km'],
            $vehicleType,
            $loadingOption,
            $step1['pickup_date']
        );

        $sessionData['step2'] = [
            'loading_option_id' => $data['loading_option_id'],
            'loading_fee' => $pricing['loading_fee'],
            'items' => $data['items'] ?? [],
            'customer_notes' => $data['customer_notes'] ?? null,
        ];

        $sessionData['pricing'] = $pricing;
        $sessionData['completed_steps'][] = 2;

        Session::put('delivery_booking', $sessionData);

        return $pricing;
    }

    /**
     * Process Step 3: Customer details, create booking.
     */
    public function processStep3(array $data): Delivery
    {
        $sessionData = Session::get('delivery_booking');
        $step1 = $sessionData['step1'];
        $step2 = $sessionData['step2'];
        $pricing = $sessionData['pricing'];

        // Build stops array
        $stops = [];
        foreach ($step1['pickup_locations'] as $i => $loc) {
            $stops[] = [
                'type' => 'pickup',
                'address' => $loc['address'],
                'postal_code' => $this->formatPostalCode($loc['postal_code']),
                'place_id' => $loc['place_id'] ?? null,
                'lat' => $loc['lat'] ?? null,
                'lng' => $loc['lng'] ?? null,
                'sort_order' => $i,
            ];
        }
        foreach ($step1['delivery_locations'] as $i => $loc) {
            $stops[] = [
                'type' => 'delivery',
                'address' => $loc['address'],
                'postal_code' => $this->formatPostalCode($loc['postal_code']),
                'place_id' => $loc['place_id'] ?? null,
                'lat' => $loc['lat'] ?? null,
                'lng' => $loc['lng'] ?? null,
                'sort_order' => $i,
            ];
        }

        $deliveryData = [
            'booking_reference' => Delivery::generateBookingReference(),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'vehicle_type_id' => $step1['vehicle_type_id'],
            'pickup_date' => $step1['pickup_date'],
            'time_slot_id' => $step1['time_slot_id'],
            'loading_option_id' => $step2['loading_option_id'],
            'distance_km' => $pricing['distance_km'],
            'base_price' => $pricing['base_price'],
            'loading_fee' => $pricing['loading_fee'],
            'vehicle_surcharge' => $pricing['vehicle_surcharge'],
            'surge_fee' => $pricing['surge_fee'],
            'total_price' => $pricing['total_price'],
            'items' => $step2['items'],
            'customer_notes' => $step2['customer_notes'],
            'stops' => $stops,
        ];

        $delivery = $this->deliveryRepo->create($deliveryData);

        // Clear session
        Session::forget('delivery_booking');

        return $delivery;
    }

    /**
     * Check if a step is accessible (previous steps completed).
     */
    public function canAccessStep(int $step): bool
    {
        if ($step === 1) return true;

        $sessionData = Session::get('delivery_booking', []);
        $completedSteps = $sessionData['completed_steps'] ?? [];

        for ($i = 1; $i < $step; $i++) {
            if (!in_array($i, $completedSteps)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get session data for display.
     */
    public function getSessionData(): array
    {
        return Session::get('delivery_booking', []);
    }

    private function formatPostalCode(string $code): string
    {
        return (new GeographyService())->formatPostalCode($code);
    }
}
