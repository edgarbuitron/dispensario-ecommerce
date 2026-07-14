<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link',
        'position',
        'sort_order',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('start_date', '<=', now())
                     ->where(function ($q) {
                         $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                     })
                     ->orderBy('sort_order');
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position)->active();
    }

    // Methods
    public function isActive()
    {
        if (!$this->is_active) return false;
        if (now()->lt($this->start_date)) return false;
        if ($this->end_date && now()->gt($this->end_date)) return false;
        return true;
    }

    public function getImageUrl()
    {
        return asset('storage/banners/' . $this->image);
    }
}
