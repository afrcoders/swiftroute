<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadingOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'label',
        'description',
        'additional_fee',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'additional_fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
