<?php $__env->startSection('title', 'Historial - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">

    <?php echo $__env->make('client.profile._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main>
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">🕓 Historial de Actividad</h1>

        <?php $orders = $user->orders()->latest()->get(); ?>

        <?php if($orders->count() > 0): ?>
            <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--color-surface-alt); border-bottom: 2px solid var(--color-border);">
                                <th style="text-align: left; padding: 1rem; font-weight: 600;">Orden</th>
                                <th style="text-align: left; padding: 1rem; font-weight: 600;">Fecha</th>
                                <th style="text-align: center; padding: 1rem; font-weight: 600;">Estado</th>
                                <th style="text-align: right; padding: 1rem; font-weight: 600;">Total</th>
                                <th style="text-align: center; padding: 1rem; font-weight: 600;">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="border-bottom: 1px solid var(--color-border);">
                                    <td style="padding: 1rem; font-family: monospace;"><?php echo e($order->order_number); ?></td>
                                    <td style="padding: 1rem;"><?php echo e($order->created_at->format('d/m/Y')); ?></td>
                                    <td style="text-align: center; padding: 1rem;">
                                        <span style="background: var(--color-surface-alt); padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8rem;"><?php echo e($order->getStatusLabel()); ?></span>
                                    </td>
                                    <td style="text-align: right; padding: 1rem; font-weight: 600;">$<?php echo e(number_format($order->total, 2)); ?></td>
                                    <td style="text-align: center; padding: 1rem;">
                                        <a href="<?php echo e(route('order.show', $order)); ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Ver</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 4rem 2rem; background: var(--color-surface-alt); border-radius: var(--radius-lg);">
                <p style="color: var(--color-text-muted); margin-bottom: 1.5rem;">Todavía no tienes órdenes registradas</p>
                <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary">Explorar Catálogo</a>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/profile/history.blade.php ENDPATH**/ ?>