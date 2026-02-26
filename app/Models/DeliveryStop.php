<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryStop extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'type',
        'address',
        'postal_code',
        'lat',
        'lng',
        'place_id',
        'sort_order',
    ];

    protected $casts = [
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function scopePickups($query)
    {
        return $query->where('type', 'pickup');
    }

    public function scopeDeliveries($query)
    {
        return $query->where('type', 'delivery');
    }
}
