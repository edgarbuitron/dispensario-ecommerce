<?php $__env->startSection('title', 'Dispensario Premium - Tienda Online'); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Section con Banners -->
<?php if($banners && $banners->count() > 0): ?>
    <div style="position: relative; width: 100%; height: 400px; background: linear-gradient(135deg, #000 0%, #1a1a1a 100%); overflow: hidden;">
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; text-align: center;">
                <div style="max-width: 600px; padding: 2rem;">
                    <h1 style="font-size: 3rem; margin-bottom: 1rem; font-weight: 700;"><?php echo e($banner->title); ?></h1>
                    <p style="font-size: 1.2rem; margin-bottom: 2rem;"><?php echo e($banner->subtitle); ?></p>
                    <?php if($banner->link): ?>
                        <a href="<?php echo e($banner->link); ?>" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 2rem;">Ver Más</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <div style="background: linear-gradient(135deg, #000 0%, #1a1a1a 100%); padding: 6rem 2rem; text-align: center; color: #fff;">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">🌿 Dispensario Premium</h1>
        <p style="font-size: 1.3rem; margin-bottom: 2rem;">Los mejores productos para ti</p>
        <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 2rem;">Explorar Catálogo</a>
    </div>
<?php endif; ?>

<!-- Categorías Destacadas -->
<div class="container" style="margin: 4rem auto;">
    <h2 style="text-align: center; font-size: 2rem; margin-bottom: 3rem; font-weight: 700;">Categorías</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 2rem;">
        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('category.show', $category->slug)); ?>" 
               style="text-decoration: none; color: inherit; transition: transform 0.3s;">
                <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; text-align: center; transition: all 0.3s; cursor: pointer; border: 1px solid #e9ecef;">
                    <?php if($category->image): ?>
                        <img src="<?php echo e(asset('storage/categories/' . $category->image)); ?>" 
                             style="width: 80px; height: 80px; object-fit: cover; margin-bottom: 1rem; border-radius: 50%;">
                    <?php else: ?>
                        <div style="width: 80px; height: 80px; background: #ddd; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem;">📦</div>
                    <?php endif; ?>
                    <h3 style="font-weight: 600; margin-bottom: 0.5rem;"><?php echo e($category->name); ?></h3>
                    <p style="color: #666; font-size: 0.9rem;">Ver categoría</p>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p style="text-align: center; color: #666; grid-column: 1/-1;">No hay categorías disponibles</p>
        <?php endif; ?>
    </div>
</div>

<!-- Productos Destacados -->
<div class="container" style="margin: 4rem auto;">
    <h2 style="text-align: center; font-size: 2rem; margin-bottom: 3rem; font-weight: 700;">⭐ Productos Destacados</h2>
    
    <?php if($featuredProducts->count() > 0): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem;">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s; border: 1px solid #e9ecef;">
                    <!-- Imagen -->
                    <div style="position: relative; width: 100%; height: 250px; background: #f8f9fa; overflow: hidden;">
                        <?php if($product->getPrimaryImage()): ?>
                            <img src="<?php echo e(asset('storage/products/' . $product->getPrimaryImage()->image_path)); ?>" 
                                 style="width: 100%; height: 100%; object-fit: cover;" alt="<?php echo e($product->name); ?>">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #e9ecef; font-size: 3rem;">📦</div>
                        <?php endif; ?>
                        
                        <?php if($product->is_new): ?>
                            <span style="position: absolute; top: 10px; right: 10px; background: #28a745; color: #fff; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">NUEVO</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Contenido -->
                    <div style="padding: 1.5rem;">
                        <h3 style="font-weight: 600; margin-bottom: 0.5rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" style="color: inherit; text-decoration: none;">
                                <?php echo e($product->name); ?>

                            </a>
                        </h3>
                        
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem; height: 40px; overflow: hidden;">
                            <?php echo e($product->short_description); ?>

                        </p>
                        
                        <?php if($product->brand): ?>
                            <p style="color: #999; font-size: 0.85rem; margin-bottom: 1rem;"><?php echo e($product->brand->name); ?></p>
                        <?php endif; ?>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <span style="font-size: 1.5rem; font-weight: 700; color: #000;">
                                $<?php echo e(number_format($product->price, 2)); ?>

                            </span>
                            
                            <?php if($product->is_new): ?>
                                <span style="background: #d4edda; color: #155724; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem;">Nuevo</span>
                            <?php endif; ?>
                        </div>
                        
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.75rem;">Ver</a>
                            <form method="POST" action="<?php echo e(route('cart.add')); ?>" style="flex: 1;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">🛒</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <p style="text-align: center; color: #666;">No hay productos destacados disponibles</p>
    <?php endif; ?>
</div>

<!-- Productos Nuevos -->
<div class="container" style="margin: 4rem auto;">
    <h2 style="text-align: center; font-size: 2rem; margin-bottom: 3rem; font-weight: 700;">🆕 Productos Nuevos</h2>
    
    <?php if($newProducts->count() > 0): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem;">
            <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s; border: 1px solid #e9ecef;">
                    <div style="position: relative; width: 100%; height: 250px; background: #f8f9fa; overflow: hidden;">
                        <?php if($product->getPrimaryImage()): ?>
                            <img src="<?php echo e(asset('storage/products/' . $product->getPrimaryImage()->image_path)); ?>" 
                                 style="width: 100%; height: 100%; object-fit: cover;" alt="<?php echo e($product->name); ?>">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #e9ecef; font-size: 3rem;">📦</div>
                        <?php endif; ?>
                        <span style="position: absolute; top: 10px; right: 10px; background: #ffc107; color: #000; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">NUEVO</span>
                    </div>
                    
                    <div style="padding: 1.5rem;">
                        <h3 style="font-weight: 600; margin-bottom: 0.5rem;">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" style="color: inherit; text-decoration: none;">
                                <?php echo e($product->name); ?>

                            </a>
                        </h3>
                        
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;"><?php echo e($product->short_description); ?></p>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 1.5rem; font-weight: 700; color: #000;">
                                $<?php echo e(number_format($product->price, 2)); ?>

                            </span>
                        </div>
                        
                        <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.75rem;">Ver</a>
                            <form method="POST" action="<?php echo e(route('cart.add')); ?>" style="flex: 1;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">🛒</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <p style="text-align: center; color: #666;">No hay productos nuevos disponibles</p>
    <?php endif; ?>
</div>

<!-- Promociones -->
<?php if($promotions && $promotions->count() > 0): ?>
    <div style="background: #f8f9fa; padding: 4rem 2rem; margin: 4rem 0;">
        <div class="container">
            <h2 style="text-align: center; font-size: 2rem; margin-bottom: 3rem; font-weight: 700;">🎉 Promociones Vigentes</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <?php $__currentLoopData = $promotions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="background: #fff; padding: 2rem; border-radius: 8px; border-left: 4px solid #ffc107;">
                        <h3 style="font-weight: 600; margin-bottom: 0.5rem;"><?php echo e($promo->name); ?></h3>
                        <p style="color: #666; margin-bottom: 1rem;"><?php echo e($promo->description); ?></p>
                        <p style="color: #ffc107; font-weight: 600;">Válida hasta: <?php echo e($promo->end_date->format('d/m/Y')); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- CTA Final -->
<div style="background: linear-gradient(135deg, #000 0%, #1a1a1a 100%); padding: 4rem 2rem; text-align: center; color: #fff; margin: 4rem 0;">
    <h2 style="font-size: 2rem; margin-bottom: 1rem; font-weight: 700;">¿Listo para comprar?</h2>
    <p style="font-size: 1.1rem; margin-bottom: 2rem;">Explora nuestro catálogo completo de productos premium</p>
    <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 2rem; background: #fff; color: #000;">
        Ir al Catálogo
    </a>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/index.blade.php ENDPATH**/ ?>