<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Delivery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_reference',
        'first_name',
        'last_name',
        'phone',
        'email',
        'vehicle_type_id',
        'pickup_date',
        'time_slot_id',
        'loading_option_id',
        'distance_km',
        'base_price',
        'loading_fee',
        'vehicle_surcharge',
        'surge_fee',
        'total_price',
        'status',
        'admin_notes',
        'customer_notes',
        'items',
        'uploaded_images',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'distance_km' => 'decimal:2',
        'base_price' => 'decimal:2',
        'loading_fee' => 'decimal:2',
        'vehicle_surcharge' => 'decimal:2',
        'surge_fee' => 'decimal:2',
        'total_price' => 'decimal:2',
        'items' => 'array',
        'uploaded_images' => 'array',
    ];

    // ── Relationships ─────────────────────────────────────

    public function stops()
    {
        return $this->hasMany(DeliveryStop::class)->orderBy('sort_order');
    }

    public function pickupStops()
    {
        return $this->hasMany(DeliveryStop::class)->where('type', 'pickup')->orderBy('sort_order');
    }

    public function deliveryStops()
    {
        return $this->hasMany(DeliveryStop::class)->where('type', 'delivery')->orderBy('sort_order');
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function loadingOption()
    {
        return $this->belongsTo(LoadingOption::class);
    }

    // ── Accessors ─────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'in_progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    // ── Static Helpers ────────────────────────────────────

    /**
     * Generate a unique booking reference: TN-XXXXXX
     */
    public static function generateBookingReference(): string
    {
        do {
            $ref = 'TN-' . strtoupper(Str::random(6));
        } while (static::where('booking_reference', $ref)->exists());

        return $ref;
    }
}
