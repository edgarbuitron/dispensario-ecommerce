<?php $__env->startSection('title', 'Seguimiento de Orden ' . $order->order_number . ' - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto; max-width: 700px;">

    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">📦 Seguimiento de tu Orden</h1>
        <p style="color: var(--color-text-muted);">Orden <strong><?php echo e($order->order_number); ?></strong></p>
    </div>

    <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 2rem;">
        <?php if($tracking->count() > 0): ?>
            <div style="display: flex; flex-direction: column;">
                <?php $__currentLoopData = $tracking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="display: flex; gap: 1rem;">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 16px; height: 16px; border-radius: 50%; background: <?php echo e($index === 0 ? 'var(--color-accent)' : '#ccc'); ?>; flex-shrink: 0;"></div>
                            <?php if(!$loop->last): ?>
                                <div style="width: 2px; flex: 1; background: var(--color-border); min-height: 40px;"></div>
                            <?php endif; ?>
                        </div>
                        <div style="padding-bottom: 2rem;">
                            <p style="font-weight: 700; <?php echo e($index === 0 ? 'color: var(--color-accent);' : ''); ?>">
                                <?php echo e(\App\Models\Order::make(['status' => $event->status])->getStatusLabel()); ?>

                            </p>
                            <?php if($event->message): ?>
                                <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-top: 0.25rem;"><?php echo e($event->message); ?></p>
                            <?php endif; ?>
                            <p style="color: var(--color-text-muted); font-size: 0.8rem; margin-top: 0.25rem;"><?php echo e($event->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p style="color: var(--color-text-muted); text-align: center;">Todavía no hay actualizaciones de seguimiento para esta orden.</p>
        <?php endif; ?>
    </div>

    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
        <a href="<?php echo e(route('order.show', $order)); ?>" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">Ver Orden Completa</a>
        <?php if($order->status === 'pending_payment'): ?>
            <a href="<?php echo e(route('order.payment', $order)); ?>" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">Ir a Pagar</a>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/orders/tracking.blade.php ENDPATH**/ ?>