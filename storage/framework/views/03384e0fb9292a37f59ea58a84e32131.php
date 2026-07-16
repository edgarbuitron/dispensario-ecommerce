<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>🌿 ¿Olvidaste algo en tu carrito?</h2>
    <p>Hola <?php echo e($cart->user->name); ?>, dejaste estos productos esperando por ti:</p>

    <table style="width: 100%; border-collapse: collapse; margin: 1rem 0;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="text-align: left; padding: 0.5rem;">Producto</th>
                <th style="text-align: center; padding: 0.5rem;">Cant.</th>
                <th style="text-align: right; padding: 0.5rem;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="padding: 0.5rem; border-bottom: 1px solid #eee;"><?php echo e($item->product->name ?? 'Producto'); ?></td>
                    <td style="text-align: center; padding: 0.5rem; border-bottom: 1px solid #eee;"><?php echo e($item->quantity); ?></td>
                    <td style="text-align: right; padding: 0.5rem; border-bottom: 1px solid #eee;">$<?php echo e(number_format($item->subtotal, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <p style="font-size: 1.1rem;"><strong>Total: $<?php echo e(number_format($cart->total, 2)); ?></strong></p>

    <p>
        <a href="<?php echo e(route('cart.index')); ?>" style="display: inline-block; background: #2f5d3a; color: #fff; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 6px;">
            Completar mi compra
        </a>
    </p>
</body>
</html>
<?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/emails/carts/abandoned.blade.php ENDPATH**/ ?>