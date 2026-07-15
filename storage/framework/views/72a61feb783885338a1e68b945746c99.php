<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>¡Gracias por tu compra, <?php echo e($order->user->name); ?>!</h2>
    <p>Recibimos tu orden <strong><?php echo e($order->order_number); ?></strong> y está pendiente de pago.</p>

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

    <p style="font-size: 1.2rem;"><strong>Total: $<?php echo e(number_format($order->total, 2)); ?></strong></p>

    <p>Sube tu comprobante de pago desde tu cuenta para que podamos procesar tu orden.</p>
</body>
</html>
<?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/emails/orders/created.blade.php ENDPATH**/ ?>