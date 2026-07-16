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

    /**
     * Registra una acción de un admin sobre un modelo.
     * Ej: AuditLog::log('delete', $product); AuditLog::log('update', $order, ['status' => 'shipped']);
     */
    public static function log(string $action, Model $model, ?array $changes = null): self
    {
        return self::create([
            'admin_user_id' => auth('admin')->id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
