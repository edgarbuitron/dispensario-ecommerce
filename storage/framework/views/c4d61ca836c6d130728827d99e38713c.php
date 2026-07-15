<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Actualización de tu orden</h2>
    <p>Hola <?php echo e($order->user->name); ?>, tu orden <strong><?php echo e($order->order_number); ?></strong> ahora está:</p>
    <p style="font-size: 1.3rem; font-weight: bold;"><?php echo e($order->getStatusLabel()); ?></p>
    <p>Puedes ver el detalle completo y el seguimiento desde tu cuenta.</p>
</body>
</html>
<?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/emails/orders/status-changed.blade.php ENDPATH**/ ?>