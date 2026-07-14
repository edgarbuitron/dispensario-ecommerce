<?php $__env->startSection('title', 'Carrito - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto;">
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">🛒 Tu Carrito</h1>
    
    <?php if($cart && $cart->items()->count() > 0): ?>
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
            
            <!-- Lista de Productos -->
            <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e9ecef;">
                                <th style="text-align: left; padding: 1rem; font-weight: 600;">Producto</th>
                                <th style="text-align: center; padding: 1rem; font-weight: 600;">Precio</th>
                                <th style="text-align: center; padding: 1rem; font-weight: 600;">Cantidad</th>
                                <th style="text-align: right; padding: 1rem; font-weight: 600;">Subtotal</th>
                                <th style="text-align: center; padding: 1rem; font-weight: 600;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="border-bottom: 1px solid #e9ecef;">
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 1rem; align-items: center;">
                                            <?php if($item->product->getPrimaryImage()): ?>
                                                <img src="<?php echo e(asset('storage/products/' . $item->product->getPrimaryImage()->image_path)); ?>" 
                                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;" alt="">
                                            <?php else: ?>
                                                <div style="width: 80px; height: 80px; background: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">📦</div>
                                            <?php endif; ?>
                                            <div>
                                                <p style="font-weight: 600; margin-bottom: 0.25rem;">
                                                    <a href="<?php echo e(route('product.show', $item->product->slug)); ?>" style="color: inherit; text-decoration: none;">
                                                        <?php echo e($item->product->name); ?>

                                                    </a>
                                                </p>
                                                <p style="color: #666; font-size: 0.9rem;">SKU: <?php echo e($item->product->sku); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center; padding: 1rem;">
                                        $<?php echo e(number_format($item->price, 2)); ?>

                                    </td>
                                    <td style="text-align: center; padding: 1rem;">
                                        <form method="POST" action="<?php echo e(route('cart.update', $item->id)); ?>" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                            <?php echo csrf_field(); ?>
                                            <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" min="1" max="10"
                                                   style="width: 60px; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
                                            <button type="submit" style="padding: 0.5rem 1rem; background: #000; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 0.8rem;">✓</button>
                                        </form>
                                    </td>
                                    <td style="text-align: right; padding: 1rem; font-weight: 600;">
                                        $<?php echo e(number_format($item->subtotal, 2)); ?>

                                    </td>
                                    <td style="text-align: center; padding: 1rem;">
                                        <form method="POST" action="<?php echo e(route('cart.remove', $item->id)); ?>" onsubmit="return confirm('¿Eliminar del carrito?');">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" style="background: #dc3545; color: #fff; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer;">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Botones de Acción -->
                <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e9ecef;">
                    <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-secondary">← Continuar Comprando</a>
                    <form method="POST" action="<?php echo e(route('cart.clear')); ?>" onsubmit="return confirm('¿Vaciar carrito?');" style="margin-left: auto;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger">🗑️ Vaciar Carrito</button>
                    </form>
                </div>
            </div>
            
            <!-- Resumen del Pedido -->
            <aside>
                <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; position: sticky; top: 20px;">
                    <h2 style="font-weight: 700; margin-bottom: 1.5rem;">Resumen</h2>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef;">
                        <span>Subtotal:</span>
                        <strong>$<?php echo e(number_format($cart->subtotal, 2)); ?></strong>
                    </div>
                    
                    <?php if($cart->tax): ?>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef;">
                            <span>Impuestos:</span>
                            <strong>$<?php echo e(number_format($cart->tax, 2)); ?></strong>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($cart->discount): ?>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e9ecef; color: #28a745;">
                            <span>Descuento:</span>
                            <strong>-$<?php echo e(number_format($cart->discount, 2)); ?></strong>
                        </div>
                    <?php endif; ?>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; font-size: 1.2rem; font-weight: 700;">
                        <span>Total:</span>
                        <strong>$<?php echo e(number_format($cart->total, 2)); ?></strong>
                    </div>
                    
                    <!-- Cupón -->
                    <form method="POST" action="<?php echo e(route('cart.coupon')); ?>" style="margin-bottom: 1.5rem;">
                        <?php echo csrf_field(); ?>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" name="coupon_code" placeholder="Código de cupón"
                                   style="flex: 1; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                            <button type="submit" class="btn btn-secondary">Aplicar</button>
                        </div>
                        <?php if($errors->has('coupon_code')): ?>
                            <p style="color: #dc3545; font-size: 0.9rem; margin-top: 0.5rem;"><?php echo e($errors->first('coupon_code')); ?></p>
                        <?php endif; ?>
                    </form>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('checkout')); ?>" class="btn btn-primary" style="width: 100%; text-align: center; padding: 1rem; display: block; font-weight: 600;">
                            Proceder al Pago
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-primary" style="width: 100%; text-align: center; padding: 1rem; display: block; font-weight: 600;">
                            Iniciar Sesión para Comprar
                        </a>
                    <?php endif; ?>
                    
                    <p style="color: #666; font-size: 0.9rem; text-align: center; margin-top: 1rem;">
                        Envío gratis en compras mayores a $500
                    </p>
                </div>
            </aside>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 4rem 2rem; background: #f8f9fa; border-radius: 8px;">
            <p style="font-size: 1.5rem; color: #666; margin-bottom: 1.5rem;">🛒 Tu carrito está vacío</p>
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1rem;">
                Explorar Productos
            </a>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/cart/index.blade.php ENDPATH**/ ?>