<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_user_id',
        'action',
        'model_type',
        'model_id',
        'changes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'changes' => 'json',
    ];

    public $timestamps = true;
    const UPDATED_AT = null; // Audit logs are immutable

    // Relationships
    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class);
    }

    // Methods
    public static function log($adminUserId, $action, $modelType, $modelId, $changes = null)
    {
        return self::create([
            'admin_user_id' => $adminUserId,
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
