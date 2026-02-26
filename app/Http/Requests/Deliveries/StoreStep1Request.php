<?php

namespace App\Http\Requests\Deliveries;

use App\Models\ServiceArea;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreStep1Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
            'pickup_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot_id' => ['required', 'exists:time_slots,id'],

            'pickup_locations' => ['required', 'array', 'min:1'],
            'pickup_locations.*.address' => ['required', 'string', 'max:500'],
            'pickup_locations.*.postal_code' => ['required', 'string', 'regex:/^[A-Za-z]\d[A-Za-z]\s?\d[A-Za-z]\d$/'],
            'pickup_locations.*.place_id' => ['nullable', 'string'],
            'pickup_locations.*.lat' => ['nullable', 'numeric'],
            'pickup_locations.*.lng' => ['nullable', 'numeric'],

            'delivery_locations' => ['required', 'array', 'min:1'],
            'delivery_locations.*.address' => ['required', 'string', 'max:500'],
            'delivery_locations.*.postal_code' => ['required', 'string', 'regex:/^[A-Za-z]\d[A-Za-z]\s?\d[A-Za-z]\d$/'],
            'delivery_locations.*.place_id' => ['nullable', 'string'],
            'delivery_locations.*.lat' => ['nullable', 'numeric'],
            'delivery_locations.*.lng' => ['nullable', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'pickup_locations.*.postal_code.regex' => 'Please enter a valid Canadian postal code (e.g., R3M 2Y8).',
            'delivery_locations.*.postal_code.regex' => 'Please enter a valid Canadian postal code (e.g., R3M 2Y8).',
            'pickup_date.after_or_equal' => 'Pickup date must be today or later.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $this->validatePostalCodesInServiceArea($validator);
            $this->validateTimeSlotAvailability($validator);
        });
    }

    protected function validatePostalCodesInServiceArea(Validator $validator): void
    {
        $serviceAreas = ServiceArea::active()->get();

        if ($serviceAreas->isEmpty()) {
            return; // No areas configured, skip validation
        }

        $allLocations = array_merge(
            $this->input('pickup_locations', []),
            $this->input('delivery_locations', [])
        );

        foreach ($allLocations as $i => $loc) {
            $inArea = false;
            foreach ($serviceAreas as $area) {
                if ($area->containsPostalCode($loc['postal_code'] ?? '')) {
                    $inArea = true;
                    break;
                }
            }
            if (!$inArea) {
                $validator->errors()->add(
                    "postal_code_{$i}",
                    "The postal code {$loc['postal_code']} is outside our service area (Winnipeg only)."
                );
            }
        }
    }

    protected function validateTimeSlotAvailability(Validator $validator): void
    {
        $timeSlotId = $this->input('time_slot_id');
        $pickupDate = $this->input('pickup_date');

        if (!$timeSlotId || !$pickupDate) return;

        $slot = \App\Models\TimeSlot::find($timeSlotId);
        if ($slot && !$slot->hasCapacityForDate($pickupDate)) {
            $validator->errors()->add('time_slot_id', 'This time slot is no longer available for the selected date.');
        }
    }
}
