<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_holder',
        'account_number',
        'clabe',
        'swift_code',
        'instructions',
        'qr_code',
        'is_active',
        'sort_order',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // Methods
    public function getMaskedAccount()
    {
        return '****' . substr($this->account_number, -4);
    }
}
