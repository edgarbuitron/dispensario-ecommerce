<?php $__env->startSection('title', 'Mis Direcciones - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">

    <?php echo $__env->make('client.profile._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; font-weight: 700;">📍 Mis Direcciones</h1>
            <a href="<?php echo e(route('profile.addresses.create')); ?>" class="btn btn-primary">➕ Nueva Dirección</a>
        </div>

        <?php if($addresses->count() > 0): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 1.5rem; <?php echo e($address->is_default ? 'border: 2px solid #000;' : ''); ?>">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <strong><?php echo e($address->label ?: 'Dirección'); ?></strong>
                            <?php if($address->is_default): ?>
                                <span style="background: #000; color: #fff; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem;">Predeterminada</span>
                            <?php endif; ?>
                        </div>
                        <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.25rem;"><?php echo e($address->recipient_name); ?></p>
                        <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.25rem;"><?php echo e($address->getFullAddress()); ?></p>
                        <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 1rem;">📞 <?php echo e($address->phone); ?></p>

                        <div style="display: flex; gap: 0.5rem;">
                            <a href="<?php echo e(route('profile.addresses.edit', $address)); ?>" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.5rem;">✏️ Editar</a>
                            <form method="POST" action="<?php echo e(route('profile.addresses.delete', $address)); ?>" style="flex: 1;" onsubmit="return confirm('¿Eliminar esta dirección?');">
                                <?php echo csrf_field(); ?> <?php echo method_field('POST'); ?>
                                <button type="submit" class="btn btn-danger" style="width: 100%; padding: 0.5rem;">🗑️ Eliminar</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 4rem 2rem; background: var(--color-surface-alt); border-radius: var(--radius-lg);">
                <p style="color: var(--color-text-muted); margin-bottom: 1.5rem;">No tienes direcciones guardadas todavía</p>
                <a href="<?php echo e(route('profile.addresses.create')); ?>" class="btn btn-primary">Agregar mi primera dirección</a>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/profile/addresses.blade.php ENDPATH**/ ?>