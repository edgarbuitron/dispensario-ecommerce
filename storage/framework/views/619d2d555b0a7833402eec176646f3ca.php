<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; font-size: 12px; }
        h1 { font-size: 20px; margin-bottom: 0; }
        .muted { color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; background: #f8f9fa; padding: 8px; border-bottom: 2px solid #ddd; }
        td { padding: 8px; border-bottom: 1px solid #eee; }
        .text-right { text-align: right; }
        .totals { width: 300px; margin-left: auto; margin-top: 20px; }
        .totals td { border: none; padding: 4px 8px; }
        .totals .total-row td { font-weight: bold; font-size: 14px; border-top: 2px solid #333; }
    </style>
</head>
<body>
    <h1>🌿 Dispensario Premium</h1>
    <p class="muted">Factura / Comprobante de Orden</p>

    <table style="margin-top: 20px;">
        <tr>
            <td style="border: none; padding: 0;">
                <strong>Orden:</strong> <?php echo e($order->order_number); ?><br>
                <strong>Fecha:</strong> <?php echo e($order->created_at->format('d/m/Y H:i')); ?><br>
                <strong>Estado:</strong> <?php echo e($order->getStatusLabel()); ?>

            </td>
            <td style="border: none; padding: 0;" class="text-right">
                <strong>Cliente:</strong> <?php echo e($order->user->name); ?><br>
                <strong>Email:</strong> <?php echo e($order->user->email); ?><br>
                <?php if($order->address): ?>
                    <strong>Dirección:</strong> <?php echo e($order->address->getFullAddress()); ?>

                <?php endif; ?>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->product_name); ?></td>
                    <td class="text-right">$<?php echo e(number_format($item->unit_price, 2)); ?></td>
                    <td class="text-right"><?php echo e($item->quantity); ?></td>
                    <td class="text-right">$<?php echo e(number_format($item->subtotal, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <table class="totals">
        <tr><td>Subtotal:</td><td class="text-right">$<?php echo e(number_format($order->subtotal, 2)); ?></td></tr>
        <tr><td>Envío:</td><td class="text-right">$<?php echo e(number_format($order->shipping, 2)); ?></td></tr>
        <?php if($order->discount): ?>
            <tr><td>Descuento:</td><td class="text-right">-$<?php echo e(number_format($order->discount, 2)); ?></td></tr>
        <?php endif; ?>
        <tr class="total-row"><td>Total:</td><td class="text-right">$<?php echo e(number_format($order->total, 2)); ?></td></tr>
    </table>

    <p class="muted" style="margin-top: 40px;">Gracias por tu compra en Dispensario Premium.</p>
</body>
</html>
<?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/orders/invoice.blade.php ENDPATH**/ ?>