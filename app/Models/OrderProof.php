<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class OrderProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'image_path',
        'status',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Methods
    public function getImageUrl()
    {
        return asset('storage/proofs/' . $this->image_path);
    }

    public function approve($notes = null)
    {
        $this->update([
            'status' => 'approved',
            'admin_notes' => $notes,
            'reviewed_at' => now(),
        ]);

        $this->order->updateStatus('payment_confirmed');
    }

    public function reject($notes)
    {
        $this->update([
            'status' => 'rejected',
            'admin_notes' => $notes,
            'reviewed_at' => now(),
        ]);

        $this->order->updateStatus('pending_payment', 'Comprobante rechazado');
    }
}
