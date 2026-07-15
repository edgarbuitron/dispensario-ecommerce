<?php $address = $address ?? null; ?>

<?php $__env->startSection('title', $address ? 'Editar Dirección' : 'Nueva Dirección'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">

    <?php echo $__env->make('client.profile._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main>
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem; max-width: 600px;">
            <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">
                <?php echo e($address ? '✏️ Editar Dirección' : '➕ Nueva Dirección'); ?>

            </h1>

            <form method="POST" action="<?php echo e($address ? route('profile.addresses.update', $address) : route('profile.addresses.store')); ?>">
                <?php echo csrf_field(); ?>
                <?php if($address): ?> <?php echo method_field('POST'); ?> <?php endif; ?>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre de la dirección (opcional)</label>
                    <input type="text" name="label" placeholder="Casa, Oficina..." value="<?php echo e(old('label', $address->label ?? '')); ?>"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre de quien recibe</label>
                    <input type="text" name="recipient_name" value="<?php echo e(old('recipient_name', $address->recipient_name ?? '')); ?>" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Teléfono</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone', $address->phone ?? '')); ?>" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Calle y número</label>
                    <input type="text" name="street_address" value="<?php echo e(old('street_address', $address->street_address ?? '')); ?>" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Referencia (opcional)</label>
                    <input type="text" name="reference" placeholder="Entre calles, color de fachada..." value="<?php echo e(old('reference', $address->reference ?? '')); ?>"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Ciudad</label>
                        <input type="text" name="city" value="<?php echo e(old('city', $address->city ?? '')); ?>" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Estado</label>
                        <input type="text" name="state" value="<?php echo e(old('state', $address->state ?? '')); ?>" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem; max-width: 200px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Código Postal</label>
                    <input type="text" name="postal_code" value="<?php echo e(old('postal_code', $address->postal_code ?? '')); ?>" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_default" value="1" <?php echo e(old('is_default', $address->is_default ?? false) ? 'checked' : ''); ?>>
                        Usar como dirección predeterminada
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">Guardar Dirección</button>
                <a href="<?php echo e(route('profile.addresses')); ?>" class="btn btn-secondary" style="padding: 0.75rem 2rem;">Cancelar</a>
            </form>
        </div>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/profile/address-form.blade.php ENDPATH**/ ?>