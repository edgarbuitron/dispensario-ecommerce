<?php $__env->startSection('title', 'Configuración - Administración'); ?>

<?php $__env->startSection('content'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">⚙️ Configuración</h1>
    <a href="<?php echo e(route('admin.settings.bank-accounts')); ?>" class="btn btn-outline-dark">🏦 Cuentas Bancarias</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>">
            <?php echo csrf_field(); ?>

            <h5 class="mb-3">General</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre del sitio</label>
                    <input type="text" name="site_name" class="form-control" value="<?php echo e(old('site_name', $general['site_name'] ?? 'Dispensario Premium')); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Eslogan</label>
                    <input type="text" name="site_tagline" class="form-control" value="<?php echo e(old('site_tagline', $general['site_tagline'] ?? '')); ?>">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Email de soporte</label>
                    <input type="email" name="support_email" class="form-control" value="<?php echo e(old('support_email', $general['support_email'] ?? '')); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teléfono de soporte</label>
                    <input type="text" name="support_phone" class="form-control" value="<?php echo e(old('support_phone', $general['support_phone'] ?? '')); ?>" required>
                </div>
            </div>

            <hr>
            <h5 class="mb-3">Redes Sociales</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control" placeholder="+52..." value="<?php echo e(old('whatsapp', $social['whatsapp'] ?? '')); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="<?php echo e(old('instagram', $social['instagram'] ?? '')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Facebook</label>
                    <input type="text" name="facebook" class="form-control" value="<?php echo e(old('facebook', $social['facebook'] ?? '')); ?>">
                </div>
            </div>

            <hr>
            <h5 class="mb-3">Correo saliente</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nombre del remitente</label>
                    <input type="text" name="mail_from_name" class="form-control" value="<?php echo e(old('mail_from_name', $email['mail_from_name'] ?? 'Dispensario Premium')); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Correo del remitente</label>
                    <input type="email" name="mail_from_address" class="form-control" value="<?php echo e(old('mail_from_address', $email['mail_from_address'] ?? '')); ?>" required>
                </div>
            </div>

            <hr>
            <h5 class="mb-3">Envío e Impuestos</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Costo de envío ($)</label>
                    <input type="number" step="0.01" min="0" name="shipping_cost" class="form-control" value="<?php echo e(old('shipping_cost', $general['shipping_cost'] ?? 0)); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Envío gratis desde ($)</label>
                    <input type="number" step="0.01" min="0" name="free_shipping_threshold" class="form-control" value="<?php echo e(old('free_shipping_threshold', $general['free_shipping_threshold'] ?? 500)); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Impuesto (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="tax_percentage" class="form-control" value="<?php echo e(old('tax_percentage', $general['tax_percentage'] ?? 0)); ?>" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg">✅ Guardar Configuración</button>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>