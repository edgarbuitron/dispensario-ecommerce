<?php $__env->startSection('title', 'Mis Órdenes - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2.5rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">

    <?php echo $__env->make('client.profile._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Contenido Principal -->
    <main>
        <h1 style="font-size: 1.9rem; margin-bottom: 2rem;">📦 Mis Órdenes</h1>

        <?php if($orders->count() > 0): ?>
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card" style="padding: 1.75rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                            <div>
                                <p class="text-muted" style="font-size: 0.9rem;">Orden</p>
                                <h2 style="font-size: 1.4rem; font-family: monospace;"><?php echo e($order->order_number); ?></h2>
                            </div>

                            <div style="text-align: right;">
                                <p class="text-muted" style="font-size: 0.9rem;">Total</p>
                                <p style="font-size: 1.4rem; font-weight: 700;">$ <?php echo e(number_format($order->total, 2)); ?></p>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--color-border);">
                            <div>
                                <p class="text-muted" style="font-size: 0.85rem;">Fecha</p>
                                <p style="font-weight: 600;"><?php echo e($order->created_at->format('d/m/Y')); ?></p>
                            </div>

                            <div>
                                <p class="text-muted" style="font-size: 0.85rem;">Productos</p>
                                <p style="font-weight: 600;"><?php echo e($order->items->count()); ?> items</p>
                            </div>

                            <div>
                                <p class="text-muted" style="font-size: 0.85rem;">Estado</p>
                                <?php
                                    $statusClass = match(true) {
                                        $order->status === 'pending_payment' => 'badge-warning',
                                        in_array($order->status, ['payment_confirmed', 'delivered']) => 'badge-success',
                                        $order->status === 'cancelled' => 'badge-danger',
                                        default => 'badge-muted',
                                    };
                                ?>
                                <span class="badge-pill <?php echo e($statusClass); ?>">
                                    <?php echo e($order->getStatusLabel()); ?>

                                </span>
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0.75rem;">Productos:</p>
                            <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.4rem;">
                                <?php $__currentLoopData = $order->items->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="text-muted" style="font-size: 0.9rem;"><?php echo e($item->product->name); ?> × <?php echo e($item->quantity); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($order->items->count() > 3): ?>
                                    <li class="text-muted" style="font-size: 0.85rem;">+<?php echo e($order->items->count() - 3); ?> más</li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <a href="<?php echo e(route('order.show', $order->id)); ?>" class="btn btn-primary" style="padding: 0.65rem 1.4rem;">
                                Ver Detalles →
                            </a>

                            <?php if($order->status === 'pending_payment' || $order->status === 'proof_received'): ?>
                                <a href="<?php echo e(route('order.payment', $order->id)); ?>" class="btn btn-secondary" style="padding: 0.65rem 1.4rem;">
                                    Subir Comprobante
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Paginación -->
            <?php if($orders->hasPages()): ?>
                <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem;">
                    <?php echo e($orders->links()); ?>

                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="card" style="text-align: center; padding: 4rem 2rem;">
                <p style="font-size: 1.1rem; color: var(--color-text-muted); margin-bottom: 1.5rem;">📦 Aún no tienes órdenes</p>
                <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">
                    Explorar Productos
                </a>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/orders/index.blade.php ENDPATH**/ ?>