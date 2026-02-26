<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'label',
        'day_of_week',
        'max_bookings',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'day_of_week' => 'integer',
        'max_bookings' => 'integer',
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Get available time slots for a given date.
     */
    public function scopeAvailableForDate($query, string $date)
    {
        $dayOfWeek = date('w', strtotime($date)); // 0=Sun..6=Sat

        return $query->where('is_active', true)
            ->where(function ($q) use ($dayOfWeek) {
                $q->whereNull('day_of_week')
                  ->orWhere('day_of_week', $dayOfWeek);
            })
            ->orderBy('sort_order');
    }

    /**
     * Check if this slot still has capacity for a given date.
     */
    public function hasCapacityForDate(string $date): bool
    {
        $bookedCount = Delivery::where('time_slot_id', $this->id)
            ->where('pickup_date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->count();

        return $bookedCount < $this->max_bookings;
    }
}
