<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'price',
        'cost_price',
        'description',
        'short_description',
        'type',
        'flavor',
        'presentation',
        'stock_status',
        'sku',
        'quantity_sold',
        'rating',
        'reviews_count',
        'is_featured',
        'is_new',
        'featured_until',
        'new_until',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'featured_until' => 'datetime',
            'new_until' => 'datetime',
        ];
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('stock_status', '!=', 'hidden')->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('featured_until', '>=', now());
    }

    public function scopeNew($query)
    {
        return $query->where('is_new', true)->where('new_until', '>=', now());
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Methods
    public function getPrimaryImage()
    {
        return $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
    }

    public function isAvailable()
    {
        return $this->stock_status !== 'hidden' && $this->is_active;
    }

    public function isOutOfStock()
    {
        return $this->stock_status === 'out_of_stock';
    }

    public function hasLowStock()
    {
        return $this->stock_status === 'low';
    }

    public function getFormattedPrice()
    {
        return '$' . number_format($this->price, 2);
    }
}
