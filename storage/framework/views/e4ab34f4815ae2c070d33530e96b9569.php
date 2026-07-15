<?php $__env->startSection('title', 'Órdenes - Administración'); ?>

<?php $__env->startSection('content'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">📦 Órdenes</h1>
    <a href="<?php echo e(route('admin.orders.index')); ?>?export=excel" class="btn btn-secondary">
        📊 Exportar a Excel
    </a>
</div>

<!-- Filtros -->
<div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem;">
    <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Buscar por número de orden..."
               style="flex: 1; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; min-width: 200px;">
        
        <select name="status" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
            <option value="">Todos los estados</option>
            <option value="pending_payment" <?php echo e(request('status') === 'pending_payment' ? 'selected' : ''); ?>>Pendiente de Pago</option>
            <option value="proof_received" <?php echo e(request('status') === 'proof_received' ? 'selected' : ''); ?>>Comprobante Recibido</option>
            <option value="payment_confirmed" <?php echo e(request('status') === 'payment_confirmed' ? 'selected' : ''); ?>>Pago Confirmado</option>
            <option value="preparing" <?php echo e(request('status') === 'preparing' ? 'selected' : ''); ?>>Preparando</option>
            <option value="ready_to_ship" <?php echo e(request('status') === 'ready_to_ship' ? 'selected' : ''); ?>>Listo para Enviar</option>
            <option value="shipped" <?php echo e(request('status') === 'shipped' ? 'selected' : ''); ?>>Enviado</option>
            <option value="delivered" <?php echo e(request('status') === 'delivered' ? 'selected' : ''); ?>>Entregado</option>
        </select>
        
        <button type="submit" class="btn btn-secondary">🔍 Filtrar</button>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">Limpiar</a>
    </form>
</div>

<!-- Tabla de Órdenes -->
<?php if($orders->count() > 0): ?>
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Orden</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Cliente</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Total</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Estado</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Fecha</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 1rem;">
                                <p style="font-weight: 600; margin-bottom: 0.25rem;">
                                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" style="color: #000; text-decoration: none;">
                                        <?php echo e($order->order_number); ?>

                                    </a>
                                </p>
                                <p style="color: #666; font-size: 0.85rem;"><?php echo e($order->items_count); ?> items</p>
                            </td>
                            <td style="padding: 1rem;">
                                <p style="font-weight: 600;"><?php echo e($order->user->name); ?></p>
                                <p style="color: #666; font-size: 0.85rem;"><?php echo e($order->user->email); ?></p>
                            </td>
                            <td style="text-align: center; padding: 1rem; font-weight: 600;">
                                $<?php echo e(number_format($order->total, 2)); ?>

                            </td>
                            <td style="text-align: center; padding: 1rem;">
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; background: <?php echo e($order->status === 'pending_payment' ? '#ffc107' : ($order->status === 'payment_confirmed' ? '#28a745' : ($order->status === 'delivered' ? '#17a2b8' : '#e9ecef'))); ?>; color: <?php echo e($order->status === 'pending_payment' ? '#000' : '#fff'); ?>;">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                                </span>
                            </td>
                            <td style="text-align: center; padding: 1rem; color: #666; font-size: 0.9rem;">
                                <?php echo e($order->created_at->format('d/m/y H:i')); ?>

                            </td>
                            <td style="text-align: center; padding: 1rem;">
                                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                                    Ver →
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Paginación -->
    <?php if($orders->hasPages()): ?>
        <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem;">
            <?php echo e($orders->links()); ?>

        </div>
    <?php endif; ?>
    
<?php else: ?>
    <div style="text-align: center; padding: 4rem 2rem; background: #f8f9fa; border-radius: 8px;">
        <p style="font-size: 1.1rem; color: #666;">No hay órdenes</p>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>