<?php $__env->startSection('title', 'Orden ' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Orden <?php echo e($order->order_number); ?></h1>
        <p style="color: #666;">Cliente: <?php echo e($order->user->name); ?> (<?php echo e($order->user->email); ?>)</p>
    </div>
    
    <div>
        <span style="display: inline-block; padding: 0.5rem 1.5rem; border-radius: 20px; font-weight: 600; font-size: 1rem; background: <?php echo e($order->status === 'pending_payment' ? '#ffc107' : ($order->status === 'payment_confirmed' ? '#28a745' : ($order->status === 'delivered' ? '#17a2b8' : '#e9ecef'))); ?>; color: <?php echo e($order->status === 'pending_payment' ? '#000' : '#fff'); ?>;">
            <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

        </span>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
    
    <!-- Contenido Principal -->
    <div>
        
        <!-- Información General -->
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem;">
            <h2 style="font-weight: 700; margin-bottom: 1rem;">📋 Información</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <p style="color: #666; font-size: 0.85rem;">Fecha</p>
                    <p style="font-weight: 600;"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.85rem;">Total</p>
                    <p style="font-weight: 600; color: #28a745;">$<?php echo e(number_format($order->total, 2)); ?></p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.85rem;">Método de Pago</p>
                    <p style="font-weight: 600;"><?php echo e($order->payment_method ?? 'Transferencia Bancaria'); ?></p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.85rem;">Items</p>
                    <p style="font-weight: 600;"><?php echo e($order->items->count()); ?> productos</p>
                </div>
            </div>
        </div>
        
        <!-- Comprobante de Pago -->
        <?php if($order->proof): ?>
            <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem; border-left: 4px solid <?php echo e($order->proof->status === 'approved' ? '#28a745' : ($order->proof->status === 'rejected' ? '#dc3545' : '#ffc107')); ?>;">
                <h2 style="font-weight: 700; margin-bottom: 1rem;">💳 Comprobante de Transferencia</h2>
                
                <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; margin-bottom: 1rem;">
                    <div>
                        <p style="color: #666; font-size: 0.85rem; margin-bottom: 0.5rem;">Referencia</p>
                        <p style="font-family: monospace; background: #f8f9fa; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem;">
                            <?php echo e($order->proof->reference ?? 'No especificada'); ?>

                        </p>
                        
                        <?php if($order->proof->notes): ?>
                            <p style="color: #666; font-size: 0.85rem; margin-bottom: 0.5rem;">Notas del Cliente</p>
                            <p style="background: #f8f9fa; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                                <?php echo e($order->proof->notes); ?>

                            </p>
                        <?php endif; ?>
                        
                        <p style="color: #666; font-size: 0.85rem; margin-bottom: 0.5rem;">Estado</p>
                        <span style="display: inline-block; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; background: <?php echo e($order->proof->status === 'approved' ? '#d4edda' : ($order->proof->status === 'rejected' ? '#f8d7da' : '#fff3cd')); ?>; color: <?php echo e($order->proof->status === 'approved' ? '#155724' : ($order->proof->status === 'rejected' ? '#721c24' : '#856404')); ?>;">
                            <?php echo e(ucfirst($order->proof->status)); ?>

                        </span>
                    </div>
                    
                    <?php if($order->proof->image_path): ?>
                        <div>
                            <p style="color: #666; font-size: 0.85rem; margin-bottom: 0.5rem;">Imagen</p>
                            <img src="<?php echo e(asset('storage/proofs/' . $order->proof->image_path)); ?>" 
                                 style="width: 100%; max-height: 250px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; cursor: pointer;"
                                 onclick="window.open(this.src, '_blank')">
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if($order->proof->status === 'rejected'): ?>
                    <div style="background: #f8d7da; border-left: 4px solid #dc3545; padding: 1rem; border-radius: 4px;">
                        <p style="color: #721c24; font-weight: 600; margin-bottom: 0.5rem;">Razón del rechazo:</p>
                        <p style="color: #721c24; margin: 0;"><?php echo e($order->proof->rejection_reason); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div style="background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
                <p style="color: #856404; font-weight: 600;">⚠️ Sin comprobante</p>
                <p style="color: #856404; margin-top: 0.5rem;">El cliente aún no ha subido el comprobante de transferencia.</p>
            </div>
        <?php endif; ?>
        
        <!-- Productos -->
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 2rem;">
            <h2 style="font-weight: 700; margin-bottom: 1rem;">📦 Productos</h2>
            
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
                                <td style="padding: 1rem;"><?php echo e($item->product->name); ?></td>
                                <td style="text-align: center; padding: 1rem;">$<?php echo e(number_format($item->unit_price, 2)); ?></td>
                                <td style="text-align: center; padding: 1rem;"><?php echo e($item->quantity); ?></td>
                                <td style="text-align: right; padding: 1rem; font-weight: 600;">$<?php echo e(number_format($item->subtotal, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Dirección de Envío -->
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem;">
            <h2 style="font-weight: 700; margin-bottom: 1rem;">📍 Dirección de Envío</h2>
            
            <p style="font-weight: 600; margin-bottom: 0.5rem;"><?php echo e($order->address->label); ?></p>
            <p style="color: #666; margin-bottom: 0.5rem;"><?php echo e($order->address->getFullAddress()); ?></p>
            <p style="color: #666; margin-bottom: 0.5rem;">📞 <?php echo e($order->address->phone); ?></p>

            <?php if($order->notes): ?>
                <p style="color: #666; font-size: 0.9rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e9ecef;">
                    <strong>Notas del cliente:</strong> <?php echo e($order->notes); ?>

                </p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Sidebar -->
    <aside>
        <!-- Resumen Financiero -->
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 1.5rem;">
            <h3 style="font-weight: 700; margin-bottom: 1rem;">Resumen</h3>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #e9ecef; font-size: 0.9rem;">
                <span>Subtotal:</span>
                <strong>$<?php echo e(number_format($order->subtotal, 2)); ?></strong>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #e9ecef; font-size: 0.9rem;">
                <span>Envío:</span>
                <strong>$<?php echo e(number_format($order->shipping, 2)); ?></strong>
            </div>
            
            <?php if($order->discount): ?>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #e9ecef; font-size: 0.9rem; color: #28a745;">
                    <span>Descuento:</span>
                    <strong>-$<?php echo e(number_format($order->discount, 2)); ?></strong>
                </div>
            <?php endif; ?>
            
            <div style="display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 700;">
                <span>Total:</span>
                <strong>$<?php echo e(number_format($order->total, 2)); ?></strong>
            </div>
        </div>
        
        <!-- Acciones -->
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem;">
            <h3 style="font-weight: 700; margin-bottom: 1rem;">Acciones</h3>
            
            <?php if($order->status === 'proof_received' && $order->proof && $order->proof->status === 'pending'): ?>
                <form method="POST" action="<?php echo e(route('admin.proofs.approve', $order->proof->id)); ?>" style="margin-bottom: 1rem;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.75rem;">
                        ✅ Aprobar Pago
                    </button>
                </form>
                
                <button type="button" class="btn btn-danger" style="width: 100%; padding: 0.75rem;"
                        onclick="document.getElementById('reject-form').style.display='block'">
                    ❌ Rechazar
                </button>
            <?php elseif($order->status === 'payment_confirmed'): ?>
                <select onchange="if(this.value) window.location.href='<?php echo e(route('admin.orders.index')); ?>?status='+this.value"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">Cambiar estado...</option>
                    <option value="preparing">📋 Preparando</option>
                    <option value="ready_to_ship">📦 Listo para enviar</option>
                    <option value="shipped">🚚 Enviado</option>
                    <option value="delivered">✓ Entregado</option>
                </select>
            <?php endif; ?>
            
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary" style="width: 100%; text-align: center; padding: 0.75rem; margin-top: 1rem; display: block;">
                ← Volver
            </a>
        </div>
    </aside>
</div>

<?php if($order->proof): ?>
    <!-- Modal Rechazo (oculto) -->
    <div id="reject-form" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;">
        <div style="background: #fff; padding: 2rem; border-radius: 8px; max-width: 500px; width: 90%;">
            <h3 style="font-weight: 700; margin-bottom: 1rem;">Rechazar Comprobante</h3>

            <form method="POST" action="<?php echo e(route('admin.proofs.reject', $order->proof->id)); ?>">
                <?php echo csrf_field(); ?>

                <textarea name="rejection_reason" required placeholder="¿Por qué se rechaza este comprobante?"
                          style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px; min-height: 120px; margin-bottom: 1rem;"></textarea>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-danger" style="flex: 1;">Confirmar rechazo</button>
                    <button type="button" class="btn btn-secondary" style="flex: 1;"
                            onclick="document.getElementById('reject-form').style.display='none'">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>