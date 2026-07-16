<?php $__env->startSection('title', 'Catálogo - Dispensario Premium'); ?>
<?php $__env->startSection('meta_description', 'Explora nuestro catálogo completo: vapes, flores, aceites, comestibles y más. Envíos a todo México.'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2.5rem auto; display: grid; grid-template-columns: 260px 1fr; gap: 2rem;">

    <!-- Sidebar - Filtros -->
    <aside>
        <div class="card" style="padding: 1.5rem; position: sticky; top: 90px;">
            <h3 style="font-weight: 700; margin-bottom: 1.5rem; font-size: 1.1rem;">Filtros</h3>

            <form method="GET" action="<?php echo e(route('catalog.index')); ?>" style="display: flex; flex-direction: column; gap: 1.5rem;">

                <!-- Búsqueda -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Buscar</label>
                    <input type="text" name="search" value="<?php echo e($filters['search'] ?? ''); ?>"
                           placeholder="Nombre del producto..."
                           style="width: 100%; padding: 0.65rem 0.85rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                </div>

                <!-- Categoría -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Categoría</label>
                    <select name="category" style="width: 100%; padding: 0.65rem 0.85rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); background: #fff;">
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
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Marca</label>
                    <select name="brand" style="width: 100%; padding: 0.65rem 0.85rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); background: #fff;">
                        <option value="">Todas las marcas</option>
                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($brand->slug); ?>" <?php echo e($filters['brand'] === $brand->slug ? 'selected' : ''); ?>>
                                <?php echo e($brand->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Precio -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Mín.</label>
                        <input type="number" name="min_price" value="<?php echo e($filters['min_price'] ?? ''); ?>"
                               placeholder="$0"
                               style="width: 100%; padding: 0.65rem 0.85rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Máx.</label>
                        <input type="number" name="max_price" value="<?php echo e($filters['max_price'] ?? ''); ?>"
                               placeholder="$5000"
                               style="width: 100%; padding: 0.65rem 0.85rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                    </div>
                </div>

                <!-- Ordenar por -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Ordenar por</label>
                    <select name="sort" onchange="this.form.submit()"
                            style="width: 100%; padding: 0.65rem 0.85rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); background: #fff;">
                        <option value="newest" <?php echo e($filters['sort'] === 'newest' ? 'selected' : ''); ?>>Más nuevo</option>
                        <option value="oldest" <?php echo e($filters['sort'] === 'oldest' ? 'selected' : ''); ?>>Más viejo</option>
                        <option value="rating" <?php echo e($filters['sort'] === 'rating' ? 'selected' : ''); ?>>Mejor calificados (estrellas)</option>
                        <option value="price-asc" <?php echo e($filters['sort'] === 'price-asc' ? 'selected' : ''); ?>>Precio: menor a mayor</option>
                        <option value="price-desc" <?php echo e($filters['sort'] === 'price-desc' ? 'selected' : ''); ?>>Precio: mayor a menor</option>
                        <option value="name-asc" <?php echo e($filters['sort'] === 'name-asc' ? 'selected' : ''); ?>>Nombre: A a la Z</option>
                        <option value="name-desc" <?php echo e($filters['sort'] === 'name-desc' ? 'selected' : ''); ?>>Nombre: Z a la A</option>
                    </select>
                </div>

                <!-- Descuento -->
                <div>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                        <input type="checkbox" name="on_sale" value="1" <?php echo e(!empty($filters['on_sale']) ? 'checked' : ''); ?>

                               onchange="this.form.submit()">
                        Solo con descuento
                    </label>
                </div>

                <!-- Botones -->
                <div style="display: flex; gap: 0.75rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Filtrar</button>
                    <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-secondary" style="flex: 1; text-align: center;">Limpiar</a>
                </div>
            </form>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main>
        <!-- Header del Catálogo -->
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 1.9rem; margin-bottom: 0.35rem;">Catálogo de Productos</h1>
            <p class="text-muted"><?php echo e($products->total()); ?> productos encontrados</p>
        </div>

        <!-- Grid de Productos -->
        <?php if($products->count() > 0): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.75rem; margin-bottom: 3rem;">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card" style="overflow: hidden; transition: box-shadow var(--transition), transform var(--transition);"
                         onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.transform='translateY(-3px)';"
                         onmouseout="this.style.boxShadow='var(--shadow-sm)'; this.style.transform='';">

                        <div style="position: relative; width: 100%; height: 220px; background: var(--color-surface-alt); overflow: hidden;">
                            <?php if($product->getPrimaryImage()): ?>
                                <img src="<?php echo e(asset('storage/products/' . $product->getPrimaryImage()->image_path)); ?>"
                                     style="width: 100%; height: 100%; object-fit: cover;" alt="<?php echo e($product->name); ?>">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
                            <?php endif; ?>

                            <?php if($product->stock_status === 'out_of_stock'): ?>
                                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(10,10,10,0.72); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; letter-spacing: 0.03em;">
                                    AGOTADO
                                </div>
                            <?php endif; ?>

                            <?php if($product->hasDiscount()): ?>
                                <span class="badge-pill" style="position: absolute; top: 10px; left: 10px; background: var(--color-danger); color: #fff; font-weight: 700;">
                                    -<?php echo e(rtrim(rtrim(number_format($product->discount_percentage, 1), '0'), '.')); ?>%
                                </span>
                            <?php endif; ?>

                            <?php if(auth()->guard()->check()): ?>
                                <form method="POST" action="<?php echo e(route('wishlist.toggle', $product)); ?>" style="position: absolute; top: 10px; right: 10px;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" title="<?php echo e(in_array($product->id, $wishlistedIds ?? []) ? 'Quitar de favoritos' : 'Agregar a favoritos'); ?>"
                                            style="width: 34px; height: 34px; border-radius: 50%; border: none; background: #fff; box-shadow: var(--shadow-sm); font-size: 1rem; cursor: pointer; opacity: <?php echo e(in_array($product->id, $wishlistedIds ?? []) ? '1' : '0.65'); ?>;">
                                        <?php echo e(in_array($product->id, $wishlistedIds ?? []) ? '❤️' : '🤍'); ?>

                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <div style="padding: 1.25rem;">
                            <h3 style="font-weight: 600; font-size: 1rem; margin-bottom: 0.4rem;">
                                <a href="<?php echo e(route('product.show', $product->slug)); ?>" style="color: inherit; text-decoration: none;">
                                    <?php echo e($product->name); ?>

                                </a>
                            </h3>

                            <?php if($product->brand): ?>
                                <p class="text-muted" style="font-size: 0.82rem; margin-bottom: 0.4rem;"><?php echo e($product->brand->name); ?></p>
                            <?php endif; ?>

                            <p style="color: #f5a623; font-size: 0.82rem; margin-bottom: 0.5rem;">
                                <?php echo e(str_repeat('★', round($product->rating))); ?><?php echo e(str_repeat('☆', 5 - round($product->rating))); ?>

                                <span class="text-muted">(<?php echo e($product->reviews_count); ?>)</span>
                            </p>

                            <p class="text-muted" style="font-size: 0.88rem; margin-bottom: 1rem; height: 40px; overflow: hidden;">
                                <?php echo e($product->short_description); ?>

                            </p>

                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <span>
                                    <?php if($product->hasDiscount()): ?>
                                        <span style="display: block; text-decoration: line-through; color: var(--color-text-muted); font-size: 0.85rem;">
                                            $<?php echo e(number_format($product->price, 2)); ?>

                                        </span>
                                        <strong style="font-size: 1.35rem; color: var(--color-danger);">
                                            <?php echo e($product->getFormattedFinalPrice()); ?>

                                        </strong>
                                    <?php else: ?>
                                        <strong style="font-size: 1.35rem;">
                                            $<?php echo e(number_format($product->price, 2)); ?>

                                        </strong>
                                    <?php endif; ?>
                                </span>
                                <?php
                                    $stockClass = $product->stock_status === 'out_of_stock' ? 'badge-danger' : ($product->stock_status === 'low' ? 'badge-warning' : 'badge-success');
                                ?>
                                <span class="badge-pill <?php echo e($stockClass); ?>">
                                    <?php echo e($product->stock_status === 'out_of_stock' ? 'Agotado' : ($product->stock_status === 'low' ? 'Pocas' : 'Disponible')); ?>

                                </span>
                            </div>

                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.65rem;">Ver</a>
                                <?php if($product->stock_status !== 'out_of_stock'): ?>
                                    <form method="POST" action="<?php echo e(route('cart.add')); ?>" style="flex: 1;">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.65rem;">🛒</button>
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
                        <span style="padding: 0.65rem 1rem; background: var(--color-surface-alt); border-radius: var(--radius-sm); color: var(--color-text-muted);">← Anterior</span>
                    <?php else: ?>
                        <a href="<?php echo e($products->previousPageUrl()); ?>" class="btn btn-secondary">← Anterior</a>
                    <?php endif; ?>

                    <?php $__currentLoopData = $products->getUrlRange(1, $products->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $products->currentPage()): ?>
                            <span style="padding: 0.65rem 1rem; background: var(--color-accent); color: #fff; border-radius: var(--radius-sm); font-weight: 600;"><?php echo e($page); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" style="padding: 0.65rem 1rem; background: var(--color-surface-alt); border-radius: var(--radius-sm); text-decoration: none; color: var(--color-text);"><?php echo e($page); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($products->hasMorePages()): ?>
                        <a href="<?php echo e($products->nextPageUrl()); ?>" class="btn btn-secondary">Siguiente →</a>
                    <?php else: ?>
                        <span style="padding: 0.65rem 1rem; background: var(--color-surface-alt); border-radius: var(--radius-sm); color: var(--color-text-muted);">Siguiente →</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="card" style="text-align: center; padding: 4rem 2rem;">
                <p style="font-size: 1.1rem; color: var(--color-text-muted); margin-bottom: 1rem;">No hay productos que coincidan con tu búsqueda</p>
                <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary">Ver todos los productos</a>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/catalog/index.blade.php ENDPATH**/ ?>