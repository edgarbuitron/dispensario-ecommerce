<?php $__env->startSection('title', 'Checkout - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2.5rem auto;">
    <h1 style="font-size: 1.9rem; margin-bottom: 2rem;">📋 Checkout</h1>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">

        <!-- Formulario -->
        <form method="POST" action="<?php echo e(route('checkout.process')); ?>" class="card" style="padding: 2rem;">
            <?php echo csrf_field(); ?>

            <!-- Dirección de Envío -->
            <section style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.2rem; margin-bottom: 1.5rem;">📍 Dirección de Envío</h2>

                <?php if($addresses->count() > 0): ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                        <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label style="display: flex; align-items: flex-start; gap: 1rem; padding: 1rem; border: 2px solid var(--color-border); border-radius: var(--radius-sm); cursor: pointer; transition: border-color var(--transition);"
                                   onmouseover="this.style.borderColor='var(--color-accent)'" onmouseout="if(!this.querySelector('input').checked) this.style.borderColor='var(--color-border)'">
                                <input type="radio" name="address_id" value="<?php echo e($addr->id); ?>"
                                       <?php echo e($loop->first ? 'checked' : ''); ?> style="margin-top: 0.25rem;">
                                <div>
                                    <p style="font-weight: 600;"><?php echo e($addr->label ?? 'Dirección'); ?></p>
                                    <p class="text-muted" style="font-size: 0.9rem;"><?php echo e($addr->getFullAddress()); ?></p>
                                    <p class="text-muted" style="font-size: 0.85rem;">📞 <?php echo e($addr->phone); ?></p>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <p class="text-muted" style="margin-bottom: 1rem;">
                    <a href="<?php echo e(route('profile.addresses.create')); ?>" style="font-weight: 600;">+ Agregar Nueva Dirección</a>
                </p>
            </section>

            <hr style="border: none; border-top: 1px solid var(--color-border); margin: 2rem 0;">

            <!-- Método de Pago -->
            <section style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.2rem; margin-bottom: 1.5rem;">💳 Método de Pago</h2>

                <label style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 2px solid var(--color-accent); border-radius: var(--radius-sm); cursor: pointer; background: var(--color-accent-light);">
                    <input type="radio" name="payment_method" value="bank_transfer" checked style="width: 20px; height: 20px;">
                    <div>
                        <p style="font-weight: 600;">Transferencia Bancaria</p>
                        <p class="text-muted" style="font-size: 0.9rem;">Detalles de cuenta disponibles después de confirmación</p>
                    </div>
                </label>
            </section>

            <hr style="border: none; border-top: 1px solid var(--color-border); margin: 2rem 0;">

            <!-- Envío -->
            <section style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.2rem; margin-bottom: 1.5rem;">📦 Envío</h2>

                <div style="background: var(--color-accent-light); color: var(--color-accent-dark); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1rem; font-size: 0.9rem;">
                    <p style="margin: 0;">✓ Envío a CDMX: 3-5 días hábiles - $80</p>
                    <p style="margin: 0;">✓ Otros estados: 5-10 días - $150</p>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <label style="display: flex; gap: 1rem; padding: 1rem; border: 2px solid var(--color-border); border-radius: var(--radius-sm); cursor: pointer;">
                        <input type="radio" name="shipping" value="80" checked>
                        <span>Envío Estándar a CDMX: $80</span>
                    </label>

                    <label style="display: flex; gap: 1rem; padding: 1rem; border: 2px solid var(--color-border); border-radius: var(--radius-sm); cursor: pointer;">
                        <input type="radio" name="shipping" value="150">
                        <span>Envío a Otros Estados: $150</span>
                    </label>
                </div>
            </section>

            <hr style="border: none; border-top: 1px solid var(--color-border); margin: 2rem 0;">

            <!-- Notas -->
            <section style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.2rem; margin-bottom: 1.5rem;">📝 Notas Adicionales</h2>

                <textarea name="notes" placeholder="Notas especiales para tu orden (opcional)"
                          style="width: 100%; padding: 1rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-family: inherit; resize: vertical; min-height: 100px;"></textarea>
            </section>

            <!-- Botón -->
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem; font-size: 1rem;">
                Confirmar Orden
            </button>
        </form>

        <!-- Resumen -->
        <aside>
            <div class="card" style="padding: 1.75rem; position: sticky; top: 90px;">
                <h2 style="font-size: 1.3rem; margin-bottom: 1.5rem;">Resumen</h2>

                <?php if($cart && $cart->items->count() > 0): ?>
                    <div style="max-height: 300px; overflow-y: auto; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--color-border);">
                        <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.9rem;">
                                <span><?php echo e($item->product->name); ?> x<?php echo e($item->quantity); ?></span>
                                <strong>$<?php echo e(number_format($item->subtotal, 2)); ?></strong>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
                    <span>Subtotal:</span>
                    <strong>$<?php echo e(number_format($cart->subtotal, 2)); ?></strong>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border);">
                    <span>Envío:</span>
                    <strong id="shipping-cost">$80</strong>
                </div>

                <?php if($cart->discount): ?>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--color-border); color: var(--color-accent);">
                        <span>Descuento:</span>
                        <strong>-$<?php echo e(number_format($cart->discount, 2)); ?></strong>
                    </div>
                <?php endif; ?>

                <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700;" id="total-section">
                    <span>Total:</span>
                    <strong>$<?php echo e(number_format($cart->subtotal + 80 - ($cart->discount ?? 0), 2)); ?></strong>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
    // Actualizar total cuando cambia el envío
    document.querySelectorAll('input[name="shipping"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const shipping = parseFloat(this.value);
            const subtotal = <?php echo e($cart->subtotal); ?>;
            const discount = <?php echo e($cart->discount ?? 0); ?>;
            const total = subtotal + shipping - discount;

            document.getElementById('shipping-cost').textContent = '$' + shipping.toFixed(2);

            const totalElement = document.querySelector('#total-section strong');
            totalElement.textContent = '$' + total.toFixed(2);
        });
    });

    // Resaltar la dirección seleccionada
    document.querySelectorAll('input[name="address_id"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('input[name="address_id"]').forEach(r => {
                r.closest('label').style.borderColor = r.checked ? 'var(--color-accent)' : 'var(--color-border)';
            });
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/checkout/index.blade.php ENDPATH**/ ?>