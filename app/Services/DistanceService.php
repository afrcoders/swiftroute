<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DistanceService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google.maps_api_key', '');
    }

    /**
     * Calculate distance between two addresses using Google Distance Matrix API.
     *
     * @return array{distance_km: float, duration_min: float, origin: string, destination: string}
     * @throws \Exception
     */
    public function calculateDistance(string $origin, string $destination): array
    {
        if (empty($this->apiKey)) {
            // Fallback: estimate distance if no API key configured
            return $this->estimateFallbackDistance();
        }

        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
                'origins' => $origin,
                'destinations' => $destination,
                'units' => 'metric',
                'region' => 'ca',
                'key' => $this->apiKey,
            ]);

            $data = $response->json();

            if ($data['status'] !== 'OK') {
                Log::error('Google Distance Matrix API error', ['response' => $data]);
                throw new \Exception('Unable to calculate distance. Please verify the addresses.');
            }

            $element = $data['rows'][0]['elements'][0];

            if ($element['status'] !== 'OK') {
                throw new \Exception('No route found between the specified locations.');
            }

            return [
                'distance_km' => round($element['distance']['value'] / 1000, 2),
                'duration_min' => round($element['duration']['value'] / 60, 1),
                'origin' => $data['origin_addresses'][0] ?? $origin,
                'destination' => $data['destination_addresses'][0] ?? $destination,
            ];
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('Distance Matrix API request failed', ['error' => $e->getMessage()]);
            throw new \Exception('Distance calculation service is temporarily unavailable.');
        }
    }

    /**
     * Calculate total route distance across multiple stops.
     *
     * @param array $pickupAddresses
     * @param array $deliveryAddresses
     * @return float Total distance in km
     */
    public function calculateMultiStopDistance(array $pickupAddresses, array $deliveryAddresses): float
    {
        $allStops = array_merge($pickupAddresses, $deliveryAddresses);

        if (count($allStops) < 2) {
            return 0;
        }

        $totalDistance = 0;
        for ($i = 0; $i < count($allStops) - 1; $i++) {
            $result = $this->calculateDistance($allStops[$i], $allStops[$i + 1]);
            $totalDistance += $result['distance_km'];
        }

        return round($totalDistance, 2);
    }

    /**
     * Fallback distance for when API key is not set (dev/testing).
     */
    private function estimateFallbackDistance(): array
    {
        return [
            'distance_km' => 15.0,
            'duration_min' => 20.0,
            'origin' => 'Estimated',
            'destination' => 'Estimated',
        ];
    }
}
