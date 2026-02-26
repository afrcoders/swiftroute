<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        // ── Pricing Rules ─────────────────────────────────

        DB::table('pricing_rules')->insert([
            [
                'key' => 'base_fee',
                'value' => 25.00,
                'label' => 'Base Fee',
                'description' => 'Fixed base fee charged on every delivery regardless of distance.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'price_per_km',
                'value' => 2.00,
                'label' => 'Price per KM',
                'description' => 'Fee charged per kilometer of route distance.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'minimum_charge',
                'value' => 50.00,
                'label' => 'Minimum Charge',
                'description' => 'Minimum delivery charge even for short distances.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'surge_percentage',
                'value' => 0.00,
                'label' => 'Surge Percentage',
                'description' => 'Additional percentage applied during peak/surge periods. Set to 0 to disable.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ── Loading Options ───────────────────────────────

        DB::table('loading_options')->insert([
            [
                'key' => 'self',
                'label' => 'I will handle loading & offloading',
                'description' => 'You load and offload the truck yourself. The driver does not need to lift anything.',
                'additional_fee' => 0.00,
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'driver_customer',
                'label' => 'Driver and I will load & offload',
                'description' => 'The driver and you will both load and offload the truck together.',
                'additional_fee' => 20.00,
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'driver_assistant',
                'label' => 'Driver + assistant will load & offload',
                'description' => 'The driver will come with an assistant so both can help load and offload the truck.',
                'additional_fee' => 40.00,
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ── Vehicle Types ─────────────────────────────────

        DB::table('vehicle_types')->insert([
            [
                'key' => 'pickup_truck',
                'label' => 'Pickup Truck',
                'description' => 'e.g. Ford F-250 — ideal for furniture, appliances, smaller loads.',
                'image_url' => null,
                'price_multiplier' => 1.00,
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'box_truck',
                'label' => 'Box Truck',
                'description' => 'Enclosed box truck — ideal for larger loads, weather protection.',
                'image_url' => null,
                'price_multiplier' => 1.50,
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ── Time Slots (30-minute intervals, 8AM–6PM) ────

        $slots = [];
        $sortOrder = 1;
        for ($hour = 8; $hour < 18; $hour++) {
            foreach ([0, 30] as $min) {
                $start = sprintf('%02d:%02d:00', $hour, $min);
                $endMin = $min + 30;
                $endHour = $hour;
                if ($endMin >= 60) {
                    $endMin = 0;
                    $endHour++;
                }
                $end = sprintf('%02d:%02d:00', $endHour, $endMin);

                $startFormatted = date('g:i A', strtotime($start));
                $endFormatted = date('g:i A', strtotime($end));

                $slots[] = [
                    'start_time' => $start,
                    'end_time' => $end,
                    'label' => "$startFormatted – $endFormatted",
                    'day_of_week' => null, // Available all days
                    'max_bookings' => 2,
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('time_slots')->insert($slots);

        // ── Service Areas ─────────────────────────────────

        DB::table('service_areas')->insert([
            'name' => 'Winnipeg Metro',
            'city' => 'Winnipeg',
            'province' => 'MB',
            'country' => 'CA',
            'postal_prefixes' => json_encode([
                'R2C', 'R2E', 'R2G', 'R2H', 'R2J', 'R2K', 'R2L', 'R2M',
                'R2N', 'R2P', 'R2R', 'R2V', 'R2W', 'R2X', 'R2Y',
                'R3A', 'R3B', 'R3C', 'R3E', 'R3G', 'R3H', 'R3J', 'R3K',
                'R3L', 'R3M', 'R3N', 'R3P', 'R3R', 'R3S', 'R3T', 'R3V',
                'R3W', 'R3X', 'R3Y',
            ]),
            'lat_center' => 49.8951,
            'lng_center' => -97.1384,
            'radius_km' => 25.00,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
