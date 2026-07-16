<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'subtotal',
        'tax',
        'total',
        'coupon_code',
        'discount',
        'reminder_sent_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'discount' => 'decimal:2',
        'reminder_sent_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // Methods
    public function addProduct($product, $quantity = 1)
    {
        $cartItem = $this->items()->where('product_id', $product->id)->first();
        
        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity,
                'subtotal' => ($cartItem->quantity + $quantity) * $product->price
            ]);
        } else {
            $this->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'subtotal' => $quantity * $product->price,
            ]);
        }

        $this->recalculate();
    }

    public function recalculate()
    {
        $subtotal = $this->items()->sum('subtotal');
        $this->update([
            'subtotal' => $subtotal,
            'total' => $subtotal + ($this->tax ?? 0) - ($this->discount ?? 0),
            'reminder_sent_at' => null,
        ]);
    }

    public function isEmpty()
    {
        return $this->items()->count() === 0;
    }

    public function clear()
    {
        $this->items()->delete();
        $this->update([
            'subtotal' => 0,
            'tax' => 0,
            'total' => 0,
            'coupon_code' => null,
            'discount' => 0,
        ]);
    }
}
