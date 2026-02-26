<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'label',
        'description',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get a pricing rule value by key.
     */
    public static function getValue(string $key, float $default = 0): float
    {
        $rule = static::where('key', $key)->where('is_active', true)->first();
        return $rule ? (float) $rule->value : $default;
    }
}
