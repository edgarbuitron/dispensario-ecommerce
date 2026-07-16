<?php $__env->startSection('title', 'Dispensario Premium - Tienda Online'); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Section con Banners -->
<?php if($banners && $banners->count() > 0): ?>
    <div style="position: relative; width: 100%; min-height: 420px; background: radial-gradient(circle at 20% 20%, #1c2f21 0%, #0a0a0a 60%); overflow: hidden;">
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="width: 100%; min-height: 420px; display: flex; align-items: center; justify-content: center; color: #fff; text-align: center;">
                <div style="max-width: 640px; padding: 2rem;">
                    <h1 style="font-size: clamp(2rem, 5vw, 3.2rem); margin-bottom: 1rem;"><?php echo e($banner->title); ?></h1>
                    <p style="font-size: 1.15rem; margin-bottom: 2rem; color: rgba(255,255,255,0.85);"><?php echo e($banner->subtitle); ?></p>
                    <?php if($banner->link): ?>
                        <a href="<?php echo e($banner->link); ?>" class="btn btn-primary" style="font-size: 1.05rem; padding: 0.9rem 2rem;">Ver Más</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <div style="background: radial-gradient(circle at 20% 20%, #1c2f21 0%, #0a0a0a 60%); padding: 6rem 2rem; text-align: center; color: #fff;">
        <h1 style="font-size: clamp(2.2rem, 6vw, 3.5rem); margin-bottom: 1rem;">🌿 Dispensario Premium</h1>
        <p style="font-size: 1.25rem; margin-bottom: 2rem; color: rgba(255,255,255,0.85);">Los mejores productos para ti</p>
        <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary" style="font-size: 1.05rem; padding: 0.9rem 2rem;">Explorar Catálogo</a>
    </div>
<?php endif; ?>

<!-- Categorías Destacadas -->
<div class="container" style="margin: 4.5rem auto;">
    <h2 style="text-align: center; font-size: 2rem; margin-bottom: 0.5rem;">Categorías</h2>
    <p class="text-muted" style="text-align: center; margin-bottom: 2.5rem;">Encuentra justo lo que buscás</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem;">
        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('catalog.index', ['category' => $category->slug])); ?>"
               style="text-decoration: none; color: inherit;">
                <div class="card" style="padding: 2rem 1.5rem; text-align: center; transition: transform var(--transition), box-shadow var(--transition);"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='var(--shadow-md)';"
                     onmouseout="this.style.transform=''; this.style.boxShadow='var(--shadow-sm)';">
                    <?php if($category->image): ?>
                        <img src="<?php echo e(asset('storage/categories/' . $category->image)); ?>"
                             style="width: 72px; height: 72px; object-fit: cover; margin-bottom: 1rem; border-radius: 50%;">
                    <?php else: ?>
                        <div style="width: 72px; height: 72px; background: var(--color-accent-light); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">📦</div>
                    <?php endif; ?>
                    <h3 style="font-weight: 600; font-size: 1rem; margin-bottom: 0.25rem;"><?php echo e($category->name); ?></h3>
                    <p class="text-muted" style="font-size: 0.85rem;">Ver categoría</p>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted" style="text-align: center; grid-column: 1/-1;">No hay categorías disponibles</p>
        <?php endif; ?>
    </div>
</div>

<!-- Productos Destacados -->
<div class="container" style="margin: 4.5rem auto;">
    <h2 style="text-align: center; font-size: 2rem; margin-bottom: 2.5rem;">⭐ Productos Destacados</h2>

    <?php if($featuredProducts->count() > 0): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.75rem;">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card" style="overflow: hidden;">
                    <!-- Imagen -->
                    <div style="position: relative; width: 100%; height: 220px; background: var(--color-surface-alt); overflow: hidden;">
                        <?php if($product->getPrimaryImage()): ?>
                            <img src="<?php echo e(asset('storage/products/' . $product->getPrimaryImage()->image_path)); ?>"
                                 style="width: 100%; height: 100%; object-fit: cover;" alt="<?php echo e($product->name); ?>">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
                        <?php endif; ?>

                        <?php if($product->hasDiscount()): ?>
                            <span class="badge-pill badge-danger" style="position: absolute; top: 10px; left: 10px; background: var(--color-danger); color: #fff;">
                                -<?php echo e(rtrim(rtrim(number_format($product->discount_percentage, 1), '0'), '.')); ?>%
                            </span>
                        <?php endif; ?>

                        <?php if($product->is_new): ?>
                            <span class="badge-pill" style="position: absolute; top: 10px; right: 10px; background: var(--color-accent); color: #fff;">NUEVO</span>
                        <?php endif; ?>
                    </div>

                    <!-- Contenido -->
                    <div style="padding: 1.25rem;">
                        <h3 style="font-weight: 600; font-size: 1rem; margin-bottom: 0.35rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" style="color: inherit; text-decoration: none;">
                                <?php echo e($product->name); ?>

                            </a>
                        </h3>

                        <?php if($product->rating > 0): ?>
                            <p style="color: #f5a623; font-size: 0.8rem; margin-bottom: 0.5rem;">
                                <?php echo e(str_repeat('★', round($product->rating))); ?><?php echo e(str_repeat('☆', 5 - round($product->rating))); ?>

                                <span class="text-muted">(<?php echo e($product->reviews_count); ?>)</span>
                            </p>
                        <?php endif; ?>

                        <?php if($product->brand): ?>
                            <p class="text-muted" style="font-size: 0.82rem; margin-bottom: 0.75rem;"><?php echo e($product->brand->name); ?></p>
                        <?php endif; ?>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <?php if($product->hasDiscount()): ?>
                                <span>
                                    <span style="display: block; text-decoration: line-through; color: var(--color-text-muted); font-size: 0.8rem;">$<?php echo e(number_format($product->price, 2)); ?></span>
                                    <strong style="font-size: 1.3rem; color: var(--color-danger);"><?php echo e($product->getFormattedFinalPrice()); ?></strong>
                                </span>
                            <?php else: ?>
                                <strong style="font-size: 1.3rem;">$<?php echo e(number_format($product->price, 2)); ?></strong>
                            <?php endif; ?>
                        </div>

                        <div style="display: flex; gap: 0.5rem;">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.65rem;">Ver</a>
                            <form method="POST" action="<?php echo e(route('cart.add')); ?>" style="flex: 1;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.65rem;">🛒</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <p class="text-muted" style="text-align: center;">No hay productos destacados disponibles</p>
    <?php endif; ?>
</div>

<!-- Productos Nuevos -->
<div class="container" style="margin: 4.5rem auto;">
    <h2 style="text-align: center; font-size: 2rem; margin-bottom: 2.5rem;">🆕 Productos Nuevos</h2>

    <?php if($newProducts->count() > 0): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.75rem;">
            <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card" style="overflow: hidden;">
                    <div style="position: relative; width: 100%; height: 220px; background: var(--color-surface-alt); overflow: hidden;">
                        <?php if($product->getPrimaryImage()): ?>
                            <img src="<?php echo e(asset('storage/products/' . $product->getPrimaryImage()->image_path)); ?>"
                                 style="width: 100%; height: 100%; object-fit: cover;" alt="<?php echo e($product->name); ?>">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
                        <?php endif; ?>
                        <span class="badge-pill" style="position: absolute; top: 10px; right: 10px; background: var(--color-accent); color: #fff;">NUEVO</span>
                    </div>

                    <div style="padding: 1.25rem;">
                        <h3 style="font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" style="color: inherit; text-decoration: none;">
                                <?php echo e($product->name); ?>

                            </a>
                        </h3>

                        <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 1rem;"><?php echo e($product->short_description); ?></p>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <strong style="font-size: 1.3rem;">$<?php echo e(number_format($product->price, 2)); ?></strong>
                        </div>

                        <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.65rem;">Ver</a>
                            <form method="POST" action="<?php echo e(route('cart.add')); ?>" style="flex: 1;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.65rem;">🛒</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <p class="text-muted" style="text-align: center;">No hay productos nuevos disponibles</p>
    <?php endif; ?>
</div>

<!-- Promociones -->
<?php if($promotions && $promotions->count() > 0): ?>
    <div style="background: var(--color-surface-alt); padding: 4rem 2rem; margin: 4.5rem 0;">
        <div class="container">
            <h2 style="text-align: center; font-size: 2rem; margin-bottom: 2.5rem;">🎉 Promociones Vigentes</h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.75rem;">
                <?php $__currentLoopData = $promotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card" style="padding: 1.75rem; border-left: 4px solid var(--color-accent);">
                        <h3 style="font-weight: 600; font-size: 1.05rem; margin-bottom: 0.5rem;"><?php echo e($promo->name); ?></h3>
                        <p class="text-muted" style="margin-bottom: 1rem;"><?php echo e($promo->description); ?></p>
                        <p style="color: var(--color-accent); font-weight: 600; font-size: 0.9rem;">Válida hasta: <?php echo e($promo->end_date->format('d/m/Y')); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- CTA Final -->
<div style="background: radial-gradient(circle at 80% 30%, #1c2f21 0%, #0a0a0a 60%); padding: 4.5rem 2rem; text-align: center; color: #fff; margin: 4.5rem 0 0;">
    <h2 style="font-size: 2rem; margin-bottom: 1rem;">¿Listo para comprar?</h2>
    <p style="font-size: 1.1rem; margin-bottom: 2rem; color: rgba(255,255,255,0.85);">Explora nuestro catálogo completo de productos premium</p>
    <a href="<?php echo e(route('catalog.index')); ?>" class="btn" style="font-size: 1.05rem; padding: 0.9rem 2rem; background: #fff; color: var(--color-black);">
        Ir al Catálogo
    </a>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/index.blade.php ENDPATH**/ ?>