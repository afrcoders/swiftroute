<?php

namespace App\Services;

use App\Models\ServiceArea;

class GeographyService
{
    /**
     * Validate that a postal code is within the Winnipeg service area.
     */
    public function isPostalCodeInServiceArea(string $postalCode): bool
    {
        $serviceAreas = ServiceArea::active()->get();

        foreach ($serviceAreas as $area) {
            if ($area->containsPostalCode($postalCode)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validate Winnipeg postal code format.
     * Winnipeg postal codes start with R2, R3, or R4 (and a few R0 areas).
     */
    public function isValidWinnipegPostalCode(string $postalCode): bool
    {
        $normalized = strtoupper(str_replace(' ', '', $postalCode));

        // Canadian postal code format: A1A1A1
        if (!preg_match('/^[A-Z]\d[A-Z]\d[A-Z]\d$/', $normalized)) {
            return false;
        }

        return $this->isPostalCodeInServiceArea($postalCode);
    }

    /**
     * Format a postal code to standard Canadian format: A1A 1A1
     */
    public function formatPostalCode(string $postalCode): string
    {
        $clean = strtoupper(str_replace(' ', '', $postalCode));

        if (strlen($clean) === 6) {
            return substr($clean, 0, 3) . ' ' . substr($clean, 3);
        }

        return $clean;
    }
}
