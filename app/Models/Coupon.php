<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'description',
        'type',
        'discount_value',
        'minimum_purchase',
        'max_uses',
        'times_used',
        'max_per_customer',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'minimum_purchase' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    // Methods
    public function isValid()
    {
        if (!$this->is_active) return false;
        if ($this->max_uses && $this->times_used >= $this->max_uses) return false;
        if (now()->lt($this->valid_from) || ($this->valid_until && now()->gt($this->valid_until))) return false;
        return true;
    }

    public function canBeUsed($cartTotal, $timesUsedByCustomer = 0)
    {
        if (!$this->isValid()) return false;
        if ($this->minimum_purchase && $cartTotal < $this->minimum_purchase) return false;
        if ($timesUsedByCustomer >= $this->max_per_customer) return false;
        return true;
    }

    public function getDiscountAmount($subtotal)
    {
        if ($this->type === 'percentage') {
            return ($subtotal * $this->discount_value) / 100;
        }
        return $this->discount_value;
    }
}
