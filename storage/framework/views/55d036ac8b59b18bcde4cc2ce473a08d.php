<?php $__env->startSection('title', 'Catálogo - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">
    
    <!-- Sidebar - Filtros -->
    <aside>
        <div style="background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h3 style="font-weight: 600; margin-bottom: 1.5rem; font-size: 1.1rem;">Filtros</h3>
            
            <form method="GET" action="<?php echo e(route('catalog.index')); ?>" style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Búsqueda -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Buscar</label>
                    <input type="text" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" 
                           placeholder="Nombre del producto..."
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                
                <!-- Categoría -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Categoría</label>
                    <select name="category" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Todas las categorías</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->slug); ?>" <?php echo e($filters['category'] === $cat->slug ? 'selected' : ''); ?>>
                                <?php echo e($cat->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <!-- Marca -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Marca</label>
                    <select name="brand" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Todas las marcas</option>
                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($brand->slug); ?>" <?php echo e($filters['brand'] === $brand->slug ? 'selected' : ''); ?>>
                                <?php echo e($brand->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <!-- Precio -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Precio Mínimo</label>
                    <input type="number" name="min_price" value="<?php echo e($filters['min_price'] ?? ''); ?>" 
                           placeholder="$0"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Precio Máximo</label>
                    <input type="number" name="max_price" value="<?php echo e($filters['max_price'] ?? ''); ?>" 
                           placeholder="$5000"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                
                <!-- Botones -->
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Filtrar</button>
                    <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-secondary" style="flex: 1; text-align: center;">Limpiar</a>
                </div>
            </form>
        </div>
    </aside>
    
    <!-- Contenido Principal -->
    <main>
        <!-- Header del Catálogo -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Catálogo de Productos</h1>
                <p style="color: #666;"><?php echo e($products->total()); ?> productos encontrados</p>
            </div>
            
            <div>
                <label style="font-weight: 600; margin-right: 0.5rem;">Ordenar por:</label>
                <select name="sort" onchange="location.href='<?php echo e(route('catalog.index')); ?>?sort=' + this.value" 
                        style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="newest" <?php echo e($filters['sort'] === 'newest' ? 'selected' : ''); ?>>Más recientes</option>
                    <option value="price-asc" <?php echo e($filters['sort'] === 'price-asc' ? 'selected' : ''); ?>>Precio: menor a mayor</option>
                    <option value="price-desc" <?php echo e($filters['sort'] === 'price-desc' ? 'selected' : ''); ?>>Precio: mayor a menor</option>
                    <option value="name" <?php echo e($filters['sort'] === 'name' ? 'selected' : ''); ?>>Nombre (A-Z)</option>
                </select>
            </div>
        </div>
        
        <!-- Grid de Productos -->
        <?php if($products->count() > 0): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s; border: 1px solid #e9ecef; hover:box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                        
                        <div style="position: relative; width: 100%; height: 250px; background: #f8f9fa; overflow: hidden;">
                            <?php if($product->getPrimaryImage()): ?>
                                <img src="<?php echo e(asset('storage/products/' . $product->getPrimaryImage()->image_path)); ?>" 
                                     style="width: 100%; height: 100%; object-fit: cover;" alt="<?php echo e($product->name); ?>">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #e9ecef; font-size: 3rem;">📦</div>
                            <?php endif; ?>
                            
                            <?php if($product->stock_status === 'out_of_stock'): ?>
                                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600;">
                                    AGOTADO
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div style="padding: 1.5rem;">
                            <h3 style="font-weight: 600; margin-bottom: 0.5rem;">
                                <a href="<?php echo e(route('product.show', $product->slug)); ?>" style="color: inherit; text-decoration: none;">
                                    <?php echo e($product->name); ?>

                                </a>
                            </h3>
                            
                            <?php if($product->brand): ?>
                                <p style="color: #999; font-size: 0.85rem; margin-bottom: 0.5rem;"><?php echo e($product->brand->name); ?></p>
                            <?php endif; ?>
                            
                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem; height: 40px; overflow: hidden;">
                                <?php echo e($product->short_description); ?>

                            </p>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <span style="font-size: 1.5rem; font-weight: 700; color: #000;">
                                    $<?php echo e(number_format($product->price, 2)); ?>

                                </span>
                                <span style="background: <?php echo e($product->stock_status === 'out_of_stock' ? '#dc3545' : ($product->stock_status === 'low' ? '#ffc107' : '#28a745')); ?>; color: #fff; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem;">
                                    <?php echo e($product->stock_status === 'out_of_stock' ? 'Agotado' : ($product->stock_status === 'low' ? 'Pocas' : 'Disponible')); ?>

                                </span>
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
            
            <!-- Paginación -->
            <?php if($products->hasPages()): ?>
                <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 3rem;">
                    <?php if($products->onFirstPage()): ?>
                        <span style="padding: 0.75rem 1rem; background: #e9ecef; border-radius: 4px; color: #999;">← Anterior</span>
                    <?php else: ?>
                        <a href="<?php echo e($products->previousPageUrl()); ?>" class="btn btn-secondary">← Anterior</a>
                    <?php endif; ?>
                    
                    <?php $__currentLoopData = $products->getUrlRange(1, $products->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $products->currentPage()): ?>
                            <span style="padding: 0.75rem 1rem; background: #000; color: #fff; border-radius: 4px; font-weight: 600;"><?php echo e($page); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" style="padding: 0.75rem 1rem; background: #e9ecef; border-radius: 4px; text-decoration: none; color: #333;"><?php echo e($page); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if($products->hasMorePages()): ?>
                        <a href="<?php echo e($products->nextPageUrl()); ?>" class="btn btn-secondary">Siguiente →</a>
                    <?php else: ?>
                        <span style="padding: 0.75rem 1rem; background: #e9ecef; border-radius: 4px; color: #999;">Siguiente →</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div style="text-align: center; padding: 4rem 2rem; background: #f8f9fa; border-radius: 8px;">
                <p style="font-size: 1.1rem; color: #666; margin-bottom: 1rem;">No hay productos que coincidan con tu búsqueda</p>
                <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary">Ver todos los productos</a>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/catalog/index.blade.php ENDPATH**/ ?>