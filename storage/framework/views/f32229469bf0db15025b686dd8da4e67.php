<?php $coupon = $coupon ?? null; ?>

<?php $__env->startSection('title', isset($coupon) ? 'Editar Cupón' : 'Nuevo Cupón'); ?>

<?php $__env->startSection('content'); ?>

<h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;"><?php echo e(isset($coupon) ? '✏️ Editar Cupón' : '➕ Nuevo Cupón'); ?></h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(isset($coupon) ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store')); ?>">
            <?php echo csrf_field(); ?>
            <?php if(isset($coupon)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Código</label>
                    <input type="text" name="code" class="form-control text-uppercase" value="<?php echo e(old('code', $coupon->code ?? '')); ?>" placeholder="VERANO20" required>
                    <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipo de descuento</label>
                    <?php $type = old('type', $coupon->type ?? 'percentage'); ?>
                    <select name="type" class="form-select" required>
                        <option value="percentage" <?php echo e($type === 'percentage' ? 'selected' : ''); ?>>Porcentaje (%)</option>
                        <option value="fixed" <?php echo e($type === 'fixed' ? 'selected' : ''); ?>>Monto fijo ($)</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="2"><?php echo e(old('description', $coupon->description ?? '')); ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Valor del descuento</label>
                    <input type="number" step="0.01" min="0" name="discount_value" class="form-control" value="<?php echo e(old('discount_value', $coupon->discount_value ?? '')); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Compra mínima ($)</label>
                    <input type="number" step="0.01" min="0" name="minimum_purchase" class="form-control" value="<?php echo e(old('minimum_purchase', $coupon->minimum_purchase ?? '')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Máx. usos por cliente</label>
                    <input type="number" min="1" name="max_per_customer" class="form-control" value="<?php echo e(old('max_per_customer', $coupon->max_per_customer ?? 1)); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Máx. usos totales (opcional)</label>
                    <input type="number" min="1" name="max_uses" class="form-control" value="<?php echo e(old('max_uses', $coupon->max_uses ?? '')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Válido desde</label>
                    <input type="date" name="valid_from" class="form-control" value="<?php echo e(old('valid_from', isset($coupon) ? $coupon->valid_from->format('Y-m-d') : now()->format('Y-m-d'))); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Válido hasta (opcional)</label>
                    <input type="date" name="valid_until" class="form-control" value="<?php echo e(old('valid_until', $coupon?->valid_until?->format('Y-m-d') ?? '')); ?>">
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" <?php echo e(old('is_active', $coupon->is_active ?? true) ? 'checked' : ''); ?>>
                <label class="form-check-label">Activo</label>
            </div>

            <button type="submit" class="btn btn-success btn-lg">✅ Guardar</button>
            <a href="<?php echo e(route('admin.coupons.index')); ?>" class="btn btn-secondary btn-lg">Cancelar</a>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/coupons/form.blade.php ENDPATH**/ ?>