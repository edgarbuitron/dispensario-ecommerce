<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'status',
        'payment_method',
        'subtotal',
        'tax',
        'shipping',
        'discount',
        'total',
        'coupon_code',
        'notes',
        'admin_notes',
        'paid_at',
        'prepared_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'prepared_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tracking(): HasMany
    {
        return $this->hasMany(OrderTracking::class)->orderBy('created_at', 'desc');
    }

    public function proof(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderProof::class);
    }

    public function proofs(): HasMany
    {
        return $this->hasMany(OrderProof::class);
    }

    public function shipment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderShipment::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending_payment');
    }

    public function scopePaid($query)
    {
        return $query->where('status', '!=', 'pending_payment')
                     ->where('status', '!=', 'cancelled');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Methods
    public function getStatusLabel()
    {
        $labels = [
            'pending_payment' => 'Pendiente de pago',
            'proof_received' => 'Comprobante recibido',
            'payment_confirmed' => 'Pago confirmado',
            'preparing' => 'En preparación',
            'ready_to_ship' => 'Listo para envío',
            'shipped' => 'Enviado',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending_payment', 'proof_received']);
    }

    public function updateStatus($newStatus, $adminNotes = null)
    {
        $this->update([
            'status' => $newStatus,
            'admin_notes' => $adminNotes ?? $this->admin_notes,
        ]);

        // Add tracking record
        $this->tracking()->create([
            'status' => $newStatus,
            'message' => "Pedido actualizado a: " . $this->getStatusLabel(),
        ]);
    }

    public function generateOrderNumber()
    {
        return 'ORD-' . date('Y') . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
