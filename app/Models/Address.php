<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone',
        'street_address',
        'reference',
        'state',
        'city',
        'postal_code',
        'country',
        'is_default',
        'is_billing',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_billing' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Methods
    public function getFullAddress()
    {
        return "{$this->street_address}, {$this->reference}, {$this->city}, {$this->state}, {$this->postal_code}";
    }

    public function markAsDefault()
    {
        $this->user->addresses()->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }
}
