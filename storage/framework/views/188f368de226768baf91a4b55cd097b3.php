<?php $__env->startSection('title', 'Mis Favoritos - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto;">
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">❤️ Mis Favoritos</h1>

    <?php if($products->count() > 0): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem;">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e9ecef;">
                    <div style="position: relative; width: 100%; height: 220px; background: #f8f9fa;">
                        <?php if($product->getPrimaryImage()): ?>
                            <img src="<?php echo e(asset('storage/products/' . $product->getPrimaryImage()->image_path)); ?>"
                                 style="width: 100%; height: 100%; object-fit: cover;" alt="<?php echo e($product->name); ?>">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('wishlist.toggle', $product)); ?>" style="position: absolute; top: 10px; right: 10px;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" title="Quitar de favoritos"
                                    style="width: 36px; height: 36px; border-radius: 50%; border: none; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.2); font-size: 1.1rem; cursor: pointer;">
                                ❤️
                            </button>
                        </form>
                    </div>

                    <div style="padding: 1.5rem;">
                        <h3 style="font-weight: 600; margin-bottom: 0.5rem;">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" style="color: inherit; text-decoration: none;">
                                <?php echo e($product->name); ?>

                            </a>
                        </h3>

                        <?php if($product->brand): ?>
                            <p style="color: #999; font-size: 0.85rem; margin-bottom: 1rem;"><?php echo e($product->brand->name); ?></p>
                        <?php endif; ?>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <?php if($product->hasDiscount()): ?>
                                <span>
                                    <span style="text-decoration: line-through; color: #999; font-size: 0.85rem; margin-right: 0.5rem;">$<?php echo e(number_format($product->price, 2)); ?></span>
                                    <strong style="font-size: 1.3rem; color: #dc3545;"><?php echo e($product->getFormattedFinalPrice()); ?></strong>
                                </span>
                            <?php else: ?>
                                <strong style="font-size: 1.3rem;">$<?php echo e(number_format($product->price, 2)); ?></strong>
                            <?php endif; ?>
                        </div>

                        <div style="display: flex; gap: 0.5rem;">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.75rem;">Ver</a>
                            <?php if($product->stock_status !== 'out_of_stock'): ?>
                                <form method="POST" action="<?php echo e(route('cart.add')); ?>" style="flex: 1;">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">🛒</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 4rem 2rem; background: #f8f9fa; border-radius: 8px;">
            <p style="font-size: 1.1rem; color: #666; margin-bottom: 1rem;">Todavía no tienes productos favoritos</p>
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary">Explorar Catálogo</a>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/wishlist/index.blade.php ENDPATH**/ ?>