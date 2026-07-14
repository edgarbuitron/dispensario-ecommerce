<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'type',
        'product_id',
        'category_id',
        'discount_percentage',
        'discount_amount',
        'start_date',
        'end_date',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->nullable();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->nullable();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('start_date', '<=', now())
                     ->where(function ($q) {
                         $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                     });
    }

    // Methods
    public function isActive()
    {
        if (!$this->is_active) return false;
        if (now()->lt($this->start_date)) return false;
        if ($this->end_date && now()->gt($this->end_date)) return false;
        return true;
    }
}
