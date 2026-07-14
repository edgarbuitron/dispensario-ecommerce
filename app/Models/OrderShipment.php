<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class OrderShipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'carrier',
        'tracking_number',
        'tracking_url',
        'notes',
        'shipped_date',
        'estimated_delivery',
        'delivered_date',
    ];

    protected $casts = [
        'shipped_date' => 'datetime',
        'estimated_delivery' => 'datetime',
        'delivered_date' => 'datetime',
    ];

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
