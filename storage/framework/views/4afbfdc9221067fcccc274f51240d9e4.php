<?php $__env->startSection('title', 'Orden ' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto; max-width: 1000px;">
    
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Orden <?php echo e($order->order_number); ?></h1>
            <p style="color: #666;">Creada el <?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
        </div>
        
        <span style="display: inline-block; padding: 0.5rem 1.5rem; border-radius: 20px; font-weight: 600; font-size: 1rem; background: <?php echo e($order->status === 'pending_payment' ? '#ffc107' : ($order->status === 'payment_confirmed' ? '#28a745' : ($order->status === 'delivered' ? '#17a2b8' : '#e9ecef'))); ?>; color: <?php echo e($order->status === 'pending_payment' ? '#000' : '#fff'); ?>;">
            <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

        </span>
    </div>
    
    <!-- Timeline de Estado -->
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem; margin-bottom: 2rem;">
        <h2 style="font-weight: 700; margin-bottom: 1.5rem;">📍 Seguimiento</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
            <div style="text-align: center;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: <?php echo e(in_array($order->status, ['pending_payment', 'proof_received', 'payment_confirmed', 'preparing', 'ready_to_ship', 'shipped', 'delivered']) ? '#28a745' : '#e9ecef'); ?>; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 700;">
                    1
                </div>
                <p style="font-weight: 600; margin-bottom: 0.25rem;">Pago Pendiente</p>
                <p style="color: #666; font-size: 0.85rem;"><?php echo e($order->status === 'pending_payment' ? 'Esperando...' : '✓ Completo'); ?></p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: <?php echo e(in_array($order->status, ['proof_received', 'payment_confirmed', 'preparing', 'ready_to_ship', 'shipped', 'delivered']) ? '#28a745' : '#e9ecef'); ?>; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 700;">
                    2
                </div>
                <p style="font-weight: 600; margin-bottom: 0.25rem;">Comprobante</p>
                <p style="color: #666; font-size: 0.85rem;"><?php echo e(in_array($order->status, ['proof_received', 'payment_confirmed', 'preparing', 'ready_to_ship', 'shipped', 'delivered']) ? '✓ Recibido' : 'Pendiente'); ?></p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: <?php echo e(in_array($order->status, ['payment_confirmed', 'preparing', 'ready_to_ship', 'shipped', 'delivered']) ? '#28a745' : '#e9ecef'); ?>; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 700;">
                    3
                </div>
                <p style="font-weight: 600; margin-bottom: 0.25rem;">Aprobado</p>
                <p style="color: #666; font-size: 0.85rem;"><?php echo e(in_array($order->status, ['payment_confirmed', 'preparing', 'ready_to_ship', 'shipped', 'delivered']) ? '✓ Confirmado' : 'Pendiente'); ?></p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: <?php echo e(in_array($order->status, ['preparing', 'ready_to_ship', 'shipped', 'delivered']) ? '#28a745' : '#e9ecef'); ?>; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 700;">
                    4
                </div>
                <p style="font-weight: 600; margin-bottom: 0.25rem;">Envío</p>
                <p style="color: #666; font-size: 0.85rem;"><?php echo e(in_array($order->status, ['shipped', 'delivered']) ? '✓ En camino' : 'Próximo'); ?></p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: <?php echo e($order->status === 'delivered' ? '#28a745' : '#e9ecef'); ?>; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 700;">
                    5
                </div>
                <p style="font-weight: 600; margin-bottom: 0.25rem;">Entregado</p>
                <p style="color: #666; font-size: 0.85rem;"><?php echo e($order->status === 'delivered' ? '✓ Recibido' : 'Pendiente'); ?></p>
            </div>
        </div>
    </div>
    
    <!-- Estado de Pago y Comprobante -->
    <?php if(in_array($order->status, ['pending_payment', 'proof_received'])): ?>
        <div style="background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="color: #856404; font-weight: 700; margin-bottom: 1rem;">⏳ Acción Requerida</h3>
            
            <?php if($order->status === 'pending_payment'): ?>
                <p style="color: #856404; margin-bottom: 1rem;">
                    Tu orden está esperando el comprobante de transferencia. Por favor, realiza la transferencia bancaria y sube el comprobante.
                </p>
                <a href="<?php echo e(route('order.upload-proof.form', $order->id)); ?>" class="btn btn-primary" style="padding: 0.75rem 1.5rem; display: inline-block;">
                    📤 Subir Comprobante
                </a>
            <?php elseif($order->status === 'proof_received'): ?>
                <p style="color: #856404; margin-bottom: 1rem;">
                    Tu comprobante fue recibido y está en revisión. Te notificaremos cuando sea aprobado (máximo 24 horas hábiles).
                </p>
                <?php if($order->proof): ?>
                    <div style="background: #fff; padding: 1rem; border-radius: 4px; margin-top: 1rem;">
                        <p style="color: #856404; font-weight: 600; margin-bottom: 0.5rem;">Estado del comprobante:</p>
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; background: #ffc107; color: #000;">
                            ⏳ En revisión
                        </span>
                    </div>
                <?php endif; ?>
                <a href="<?php echo e(route('order.upload-proof.form', $order->id)); ?>" class="btn btn-secondary" style="padding: 0.75rem 1.5rem; display: inline-block; margin-top: 1rem;">
                    📤 Subir otro comprobante
                </a>
            <?php endif; ?>
        </div>
    <?php elseif($order->status === 'payment_confirmed'): ?>
        <div style="background: #d4edda; border-left: 4px solid #28a745; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <h3 style="color: #155724; font-weight: 700; margin-bottom: 1rem;">✅ Pago Confirmado</h3>
            <p style="color: #155724; margin: 0;">
                Tu transferencia fue verificada exitosamente. Tu orden será preparada y enviada pronto.
            </p>
        </div>
    <?php endif; ?>
    
    <!-- Productos -->
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem; margin-bottom: 2rem;">
        <h2 style="font-weight: 700; margin-bottom: 1.5rem;">📦 Productos</h2>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #e9ecef;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Producto</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Precio</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Cantidad</th>
                        <th style="text-align: right; padding: 1rem; font-weight: 600;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 1rem;">
                                <a href="<?php echo e(route('product.show', $item->product->slug)); ?>" style="color: #000; text-decoration: none; font-weight: 600;">
                                    <?php echo e($item->product->name); ?>

                                </a>
                            </td>
                            <td style="text-align: center; padding: 1rem;">$<?php echo e(number_format($item->unit_price, 2)); ?></td>
                            <td style="text-align: center; padding: 1rem;"><?php echo e($item->quantity); ?></td>
                            <td style="text-align: right; padding: 1rem; font-weight: 600;">$<?php echo e(number_format($item->subtotal, 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Resumen -->
    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
        <!-- Información de Envío -->
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem;">
            <h3 style="font-weight: 700; margin-bottom: 1.5rem;">📍 Dirección de Envío</h3>
            
            <p style="font-weight: 600; margin-bottom: 0.5rem;"><?php echo e($order->address->label); ?></p>
            <p style="color: #666; margin-bottom: 0.5rem;"><?php echo e($order->address->getFullAddress()); ?></p>
            <p style="color: #666; font-size: 0.9rem;">📞 <?php echo e($order->address->phone); ?></p>
        </div>
        
        <!-- Resumen Financiero -->
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem;">
            <h3 style="font-weight: 700; margin-bottom: 1rem;">Resumen</h3>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #e9ecef;">
                <span>Subtotal:</span>
                <strong>$<?php echo e(number_format($order->subtotal, 2)); ?></strong>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #e9ecef;">
                <span>Envío:</span>
                <strong>$<?php echo e(number_format($order->shipping, 2)); ?></strong>
            </div>
            
            <?php if($order->discount): ?>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #e9ecef; color: #28a745;">
                    <span>Descuento:</span>
                    <strong>-$<?php echo e(number_format($order->discount, 2)); ?></strong>
                </div>
            <?php endif; ?>
            
            <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700;">
                <span>Total:</span>
                <strong>$<?php echo e(number_format($order->total, 2)); ?></strong>
            </div>
        </div>
    </div>
    
    <!-- Botones de Acción -->
    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
        <a href="<?php echo e(route('profile.orders')); ?>" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">
            ← Volver a Órdenes
        </a>
        <a href="<?php echo e(route('order.invoice', $order->id)); ?>" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">
            📄 Descargar Factura
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/orders/show.blade.php ENDPATH**/ ?>