<?php $__env->startSection('title', 'Pagar Orden ' . $order->order_number . ' - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto; max-width: 800px;">

    <div style="background: #fff3cd; border: 2px solid #ffc107; border-radius: 8px; padding: 2rem; text-align: center; margin-bottom: 2rem;">
        <p style="font-size: 3rem; margin-bottom: 1rem;">⏳</p>
        <h1 style="color: #856404; font-size: 1.8rem; font-weight: 700; margin-bottom: 0.5rem;">Tu orden está pendiente de pago</h1>
        <p style="color: #856404;">Orden <strong><?php echo e($order->order_number); ?></strong> — Total: <strong>$<?php echo e(number_format($order->total, 2)); ?></strong></p>
    </div>

    <!-- Datos Bancarios -->
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem; margin-bottom: 2rem;">
        <h2 style="font-weight: 700; margin-bottom: 1.5rem;">💳 Datos para tu transferencia</h2>

        <?php if($bankAccounts && $bankAccounts->count() > 0): ?>
            <?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; margin-bottom: 1rem;">
                    <p style="font-weight: 700; margin-bottom: 0.5rem;"><?php echo e($account->bank_name); ?></p>
                    <p style="color: #666; font-size: 0.95rem;">Titular: <strong><?php echo e($account->account_holder); ?></strong></p>
                    <?php if($account->account_number): ?>
                        <p style="color: #666; font-size: 0.95rem;">Cuenta: <strong><?php echo e($account->account_number); ?></strong></p>
                    <?php endif; ?>
                    <p style="color: #666; font-size: 0.95rem;">CLABE: <strong><?php echo e($account->clabe); ?></strong></p>
                    <?php if($account->swift_code): ?>
                        <p style="color: #666; font-size: 0.95rem;">SWIFT: <strong><?php echo e($account->swift_code); ?></strong></p>
                    <?php endif; ?>
                    <?php if($account->instructions): ?>
                        <p style="color: #666; font-size: 0.85rem; margin-top: 0.5rem;"><?php echo e($account->instructions); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div style="background: #f8f9fa; padding: 1rem; border-radius: 4px;">
                <p style="font-weight: 600; margin-bottom: 0.5rem;">Concepto de pago:</p>
                <p style="font-family: monospace; background: #fff; padding: 0.5rem; border-radius: 4px; border: 1px solid #ddd;">
                    Pago pedido <?php echo e($order->order_number); ?>

                </p>
            </div>
        <?php else: ?>
            <p style="color: #666;">Aún no hay cuentas bancarias configuradas. Contáctanos para coordinar el pago.</p>
        <?php endif; ?>
    </div>

    <!-- Siguiente Paso -->
    <div style="background: #e3f2fd; border-left: 4px solid #2196f3; border-radius: 4px; padding: 1.5rem; margin-bottom: 2rem; text-align: center;">
        <h3 style="color: #1565c0; font-weight: 700; margin-bottom: 1rem;">📤 Ya hiciste la transferencia?</h3>
        <p style="color: #1565c0; margin-bottom: 1.5rem;">Sube tu comprobante para que podamos confirmar tu pago lo antes posible.</p>
        <a href="<?php echo e(route('order.upload-proof.form', $order)); ?>" class="btn btn-primary" style="padding: 1rem 2rem;">
            Subir Comprobante de Pago
        </a>
    </div>

    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="<?php echo e(route('order.show', $order)); ?>" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">Ver Orden Completa</a>
        <a href="<?php echo e(route('order.tracking', $order)); ?>" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">Ver Seguimiento</a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/checkout/payment.blade.php ENDPATH**/ ?>