<?php

namespace App\Services;

use App\Models\PricingRule;
use App\Models\LoadingOption;
use App\Models\VehicleType;

class PricingService
{
    /**
     * Calculate base price from distance.
     */
    public function calculateBasePrice(float $distanceKm): float
    {
        $baseFee = PricingRule::getValue('base_fee', 25.00);
        $pricePerKm = PricingRule::getValue('price_per_km', 2.00);
        $minimumCharge = PricingRule::getValue('minimum_charge', 50.00);

        $calculated = $baseFee + ($pricePerKm * $distanceKm);

        return max($calculated, $minimumCharge);
    }

    /**
     * Calculate the vehicle surcharge (multiplier based).
     */
    public function calculateVehicleSurcharge(float $basePrice, VehicleType $vehicleType): float
    {
        if ($vehicleType->price_multiplier <= 1.00) {
            return 0.00;
        }

        return round($basePrice * ($vehicleType->price_multiplier - 1), 2);
    }

    /**
     * Calculate surge pricing (future: time/date-based).
     */
    public function calculateSurgeFee(float $basePrice, string $pickupDate): float
    {
        $surgePct = PricingRule::getValue('surge_percentage', 0);

        if ($surgePct <= 0) {
            return 0.00;
        }

        return round($basePrice * ($surgePct / 100), 2);
    }

    /**
     * Calculate total delivery price.
     */
    public function calculateTotal(
        float $distanceKm,
        VehicleType $vehicleType,
        LoadingOption $loadingOption,
        string $pickupDate
    ): array {
        $basePrice = $this->calculateBasePrice($distanceKm);
        $vehicleSurcharge = $this->calculateVehicleSurcharge($basePrice, $vehicleType);
        $loadingFee = (float) $loadingOption->additional_fee;
        $surgeFee = $this->calculateSurgeFee($basePrice, $pickupDate);

        $total = $basePrice + $vehicleSurcharge + $loadingFee + $surgeFee;

        return [
            'distance_km' => round($distanceKm, 2),
            'base_price' => round($basePrice, 2),
            'vehicle_surcharge' => round($vehicleSurcharge, 2),
            'loading_fee' => round($loadingFee, 2),
            'surge_fee' => round($surgeFee, 2),
            'total_price' => round($total, 2),
        ];
    }
}
