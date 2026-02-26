<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'province',
        'country',
        'postal_prefixes',
        'lat_center',
        'lng_center',
        'radius_km',
        'is_active',
    ];

    protected $casts = [
        'postal_prefixes' => 'array',
        'lat_center' => 'decimal:7',
        'lng_center' => 'decimal:7',
        'radius_km' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Check if a postal code is within this service area.
     */
    public function containsPostalCode(string $postalCode): bool
    {
        $normalized = strtoupper(str_replace(' ', '', $postalCode));
        foreach ($this->postal_prefixes as $prefix) {
            if (str_starts_with($normalized, strtoupper($prefix))) {
                return true;
            }
        }
        return false;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
