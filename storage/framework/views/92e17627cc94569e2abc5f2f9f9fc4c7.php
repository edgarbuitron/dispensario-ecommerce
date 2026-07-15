<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Nueva orden recibida</h2>
    <p><strong>Orden:</strong> <?php echo e($order->order_number); ?></p>
    <p><strong>Cliente:</strong> <?php echo e($order->user->name); ?> (<?php echo e($order->user->email); ?>)</p>
    <p><strong>Total:</strong> $<?php echo e(number_format($order->total, 2)); ?></p>
    <p><strong>Método de pago:</strong> <?php echo e($order->payment_method); ?></p>

    <table style="width: 100%; border-collapse: collapse; margin: 1rem 0;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="text-align: left; padding: 0.5rem;">Producto</th>
                <th style="text-align: center; padding: 0.5rem;">Cant.</th>
                <th style="text-align: right; padding: 0.5rem;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 0.5rem; border-bottom: 1px solid #eee;"><?php echo e($item->product_name); ?></td>
                    <td style="text-align: center; padding: 0.5rem; border-bottom: 1px solid #eee;"><?php echo e($item->quantity); ?></td>
                    <td style="text-align: right; padding: 0.5rem; border-bottom: 1px solid #eee;">$<?php echo e(number_format($item->subtotal, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <p>Revísala en el panel de administración.</p>
</body>
</html>
<?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/emails/orders/created-admin.blade.php ENDPATH**/ ?>