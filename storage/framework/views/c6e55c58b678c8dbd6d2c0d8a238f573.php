<?php $__env->startSection('title', $product->name . ' - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
    
    <!-- Galería de Imágenes -->
    <div>
        <?php if($product->images && $product->images->count() > 0): ?>
            <div style="position: relative; width: 100%; height: 500px; background: #f8f9fa; border-radius: 8px; overflow: hidden; margin-bottom: 1rem;">
                <img id="mainImage" src="<?php echo e(asset('storage/products/' . $product->images->first()->image_path)); ?>"
                     onclick="openLightbox()"
                     style="width: 100%; height: 100%; object-fit: cover; cursor: zoom-in;" alt="<?php echo e($product->name); ?>">

                <?php if($product->images->count() > 1): ?>
                    <button type="button" onclick="showImage(currentIndex - 1)"
                            style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; border: none; background: rgba(255,255,255,0.9); font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        ‹
                    </button>
                    <button type="button" onclick="showImage(currentIndex + 1)"
                            style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; border: none; background: rgba(255,255,255,0.9); font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        ›
                    </button>
                <?php endif; ?>
            </div>

            <!-- Miniaturas -->
            <?php if($product->images->count() > 1): ?>
                <div style="display: flex; gap: 1rem; overflow-x: auto;">
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/products/' . $image->image_path)); ?>"
                             data-thumb="<?php echo e($index); ?>"
                             onclick="showImage(<?php echo e($index); ?>)"
                             class="product-thumb"
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; cursor: pointer; border: 2px solid <?php echo e($index === 0 ? '#000' : 'transparent'); ?>; transition: border 0.3s; flex-shrink: 0;"
                             alt="<?php echo e($product->name); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div style="width: 100%; height: 500px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 4rem;">📦</div>
        <?php endif; ?>
    </div>

    <!-- Lightbox -->
    <?php if($product->images && $product->images->count() > 0): ?>
        <div id="lightbox" onclick="if(event.target === this) closeLightbox()"
             style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.92); z-index: 1000; flex-direction: column; align-items: center; justify-content: center; padding: 2rem;">
            <button type="button" onclick="closeLightbox()"
                    style="position: absolute; top: 20px; right: 30px; background: none; border: none; color: #fff; font-size: 2.5rem; cursor: pointer; line-height: 1;">
                &times;
            </button>

            <div style="position: relative; width: 100%; max-width: 900px; display: flex; align-items: center; justify-content: center;">
                <?php if($product->images->count() > 1): ?>
                    <button type="button" onclick="showImage(currentIndex - 1)"
                            style="position: absolute; left: -10px; width: 50px; height: 50px; border-radius: 50%; border: none; background: rgba(255,255,255,0.9); font-size: 1.5rem; cursor: pointer;">
                        ‹
                    </button>
                <?php endif; ?>

                <img id="lightboxImage" src="<?php echo e(asset('storage/products/' . $product->images->first()->image_path)); ?>"
                     style="max-width: 100%; max-height: 78vh; object-fit: contain; border-radius: 4px;" alt="<?php echo e($product->name); ?>">

                <?php if($product->images->count() > 1): ?>
                    <button type="button" onclick="showImage(currentIndex + 1)"
                            style="position: absolute; right: -10px; width: 50px; height: 50px; border-radius: 50%; border: none; background: rgba(255,255,255,0.9); font-size: 1.5rem; cursor: pointer;">
                        ›
                    </button>
                <?php endif; ?>
            </div>

            <?php if($product->images->count() > 1): ?>
                <div style="display: flex; gap: 0.75rem; overflow-x: auto; margin-top: 1.5rem; max-width: 900px; padding: 0.5rem;">
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/products/' . $image->image_path)); ?>"
                             data-lightbox-thumb="<?php echo e($index); ?>"
                             onclick="showImage(<?php echo e($index); ?>)"
                             class="lightbox-thumb"
                             style="width: 70px; height: 70px; object-fit: cover; border-radius: 4px; cursor: pointer; border: 2px solid <?php echo e($index === 0 ? '#fff' : 'transparent'); ?>; opacity: <?php echo e($index === 0 ? '1' : '0.6'); ?>; flex-shrink: 0;"
                             alt="<?php echo e($product->name); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <script>
            const productImages = <?php echo json_encode($product->images->map(fn($img) => asset('storage/products/' . $img->image_path)), 15, 512) ?>;
            let currentIndex = 0;

            function showImage(index) {
                currentIndex = (index + productImages.length) % productImages.length;
                const url = productImages[currentIndex];

                const mainImage = document.getElementById('mainImage');
                if (mainImage) mainImage.src = url;

                const lightboxImage = document.getElementById('lightboxImage');
                if (lightboxImage) lightboxImage.src = url;

                document.querySelectorAll('.product-thumb').forEach((thumb) => {
                    thumb.style.border = Number(thumb.dataset.thumb) === currentIndex ? '2px solid #000' : '2px solid transparent';
                });

                document.querySelectorAll('.lightbox-thumb').forEach((thumb) => {
                    const active = Number(thumb.dataset.lightboxThumb) === currentIndex;
                    thumb.style.border = active ? '2px solid #fff' : '2px solid transparent';
                    thumb.style.opacity = active ? '1' : '0.6';
                });
            }

            function openLightbox() {
                document.getElementById('lightbox').style.display = 'flex';
                document.body.style.overflow = 'hidden';
                showImage(currentIndex);
            }

            function closeLightbox() {
                document.getElementById('lightbox').style.display = 'none';
                document.body.style.overflow = '';
            }

            document.addEventListener('keydown', function (e) {
                const lightbox = document.getElementById('lightbox');
                if (!lightbox || lightbox.style.display !== 'flex') return;

                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
                if (e.key === 'ArrowRight') showImage(currentIndex + 1);
            });
        </script>
    <?php endif; ?>
    
    <!-- Información del Producto -->
    <div>
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <?php if($product->brand): ?>
                    <span style="background: #f8f9fa; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                        <?php echo e($product->brand->name); ?>

                    </span>
                <?php endif; ?>
                <span style="background: <?php echo e($product->stock_status === 'out_of_stock' ? '#dc3545' : ($product->stock_status === 'low' ? '#ffc107' : '#28a745')); ?>; color: #fff; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                    <?php echo e($product->stock_status === 'out_of_stock' ? '❌ Agotado' : ($product->stock_status === 'low' ? '⚠️ Pocas unidades' : '✅ Disponible')); ?>

                </span>

                <?php if(auth()->guard()->check()): ?>
                    <form method="POST" action="<?php echo e(route('wishlist.toggle', $product)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php $isWishlisted = in_array($product->id, $wishlistedIds ?? []); ?>
                        <button type="submit" style="background: none; border: 1px solid #ddd; padding: 0.5rem 1rem; border-radius: 20px; cursor: pointer; font-weight: 600;">
                            <?php echo e($isWishlisted ? '❤️ En favoritos' : '🤍 Agregar a favoritos'); ?>

                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;"><?php echo e($product->name); ?></h1>
            
            <?php if($product->category): ?>
                <p style="color: #666; margin-bottom: 1rem;">
                    <a href="<?php echo e(route('category.show', $product->category->slug)); ?>" style="color: #666; text-decoration: none;">
                        <?php echo e($product->category->name); ?>

                    </a>
                </p>
            <?php endif; ?>
            
            <p style="color: #666; line-height: 1.6; margin-bottom: 2rem;">
                <?php echo e($product->description); ?>

            </p>
        </div>
        
        <!-- Precio -->
        <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
            <?php if($product->hasDiscount()): ?>
                <div style="display: flex; align-items: baseline; gap: 1rem;">
                    <span style="font-size: 3rem; font-weight: 700; color: #dc3545;"><?php echo e($product->getFormattedFinalPrice()); ?></span>
                    <span style="font-size: 1.3rem; color: #999; text-decoration: line-through;">$<?php echo e(number_format($product->price, 2)); ?></span>
                    <span style="background: #dc3545; color: #fff; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">
                        -<?php echo e(rtrim(rtrim(number_format($product->discount_percentage, 1), '0'), '.')); ?>%
                    </span>
                </div>
            <?php else: ?>
                <div style="font-size: 3rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">
                    $<?php echo e(number_format($product->price, 2)); ?>

                </div>
            <?php endif; ?>
            <p style="color: #666; font-size: 0.9rem; margin-top: 0.5rem;">IVA incluido</p>
        </div>

        <!-- Calificación -->
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem;">
            <span style="color: #f5a623; font-size: 1.2rem;">
                <?php echo e(str_repeat('★', round($product->rating))); ?><?php echo e(str_repeat('☆', 5 - round($product->rating))); ?>

            </span>
            <span style="color: #666;"><?php echo e(number_format($product->rating, 1)); ?> · <?php echo e($product->reviews_count); ?> reseñas</span>
        </div>
        
        <!-- Atributos -->
        <?php if($product->attributes && $product->attributes->count() > 0): ?>
            <div style="margin-bottom: 2rem;">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Características:</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
                    <?php $__currentLoopData = $product->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="display: flex; gap: 0.5rem;">
                            <span style="color: #666;"><?php echo e($attr->attribute_name); ?>:</span>
                            <strong><?php echo e($attr->attribute_value); ?></strong>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Cantidad y Agregar al Carrito -->
        <?php if($product->stock_status !== 'out_of_stock'): ?>
            <form method="POST" action="<?php echo e(route('cart.add')); ?>" style="margin-bottom: 2rem;">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                
                <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Cantidad:</label>
                        <input type="number" name="quantity" value="1" min="1" max="10"
                               style="width: 80px; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem; margin-top: 1.5rem;">
                        🛒 Agregar al Carrito
                    </button>
                </div>
            </form>
        <?php else: ?>
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; font-weight: 600;">
                ❌ Este producto está actualmente agotado
            </div>
        <?php endif; ?>
        
        <!-- Información de Envío -->
        <div style="background: #d1ecf1; color: #0c5460; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
            <h4 style="font-weight: 600; margin-bottom: 0.5rem;">📦 Información de Envío</h4>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
                <li>✓ Envío a CDMX: 3-5 días hábiles</li>
                <li>✓ Envío a otros estados: 5-10 días hábiles</li>
                <li>✓ Envío gratis en compras mayores a $500</li>
            </ul>
        </div>
        
        <!-- Compartir -->
        <div style="border-top: 1px solid #e9ecef; padding-top: 2rem;">
            <p style="font-weight: 600; margin-bottom: 1rem;">Compartir:</p>
            <div style="display: flex; gap: 1rem;">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(url()->current())); ?>" 
                   target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #1877f2; color: #fff; border-radius: 50%; text-decoration: none;">
                    f
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(url()->current())); ?>&text=<?php echo e(urlencode($product->name)); ?>" 
                   target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #1da1f2; color: #fff; border-radius: 50%; text-decoration: none;">
                    𝕏
                </a>
                <a href="https://wa.me/?text=<?php echo e(urlencode($product->name . ' ' . url()->current())); ?>" 
                   target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #25d366; color: #fff; border-radius: 50%; text-decoration: none;">
                    W
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Productos Relacionados -->
<?php if($relatedProducts && $relatedProducts->count() > 0): ?>
    <div style="margin-top: 4rem; padding-top: 2rem; border-top: 2px solid #e9ecef;">
        <div class="container">
            <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">Productos Relacionados</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem;">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e9ecef;">
                        <div style="position: relative; width: 100%; height: 250px; background: #f8f9fa;">
                            <?php if($related->getPrimaryImage()): ?>
                                <img src="<?php echo e(asset('storage/products/' . $related->getPrimaryImage()->image_path)); ?>" 
                                     style="width: 100%; height: 100%; object-fit: cover;" alt="<?php echo e($related->name); ?>">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
                            <?php endif; ?>
                        </div>
                        
                        <div style="padding: 1.5rem;">
                            <h3 style="font-weight: 600; margin-bottom: 0.5rem;">
                                <a href="<?php echo e(route('product.show', $related->slug)); ?>" style="color: inherit; text-decoration: none;">
                                    <?php echo e($related->name); ?>

                                </a>
                            </h3>
                            
                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;"><?php echo e($related->short_description); ?></p>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 1.5rem; font-weight: 700;">
                                    $<?php echo e(number_format($related->price, 2)); ?>

                                </span>
                            </div>
                            
                            <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                                <a href="<?php echo e(route('product.show', $related->slug)); ?>" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.75rem;">Ver</a>
                                <form method="POST" action="<?php echo e(route('cart.add')); ?>" style="flex: 1;">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($related->id); ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">🛒</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Reseñas de Clientes -->
<div style="margin-top: 4rem; padding-top: 2rem; padding-bottom: 4rem; border-top: 2px solid #e9ecef;">
    <div class="container" style="max-width: 900px;">
        <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">Reseñas de Clientes</h2>

        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <span style="font-size: 2.5rem; font-weight: 700;"><?php echo e(number_format($product->rating, 1)); ?></span>
            <div>
                <div style="color: #f5a623; font-size: 1.3rem;">
                    <?php echo e(str_repeat('★', round($product->rating))); ?><?php echo e(str_repeat('☆', 5 - round($product->rating))); ?>

                </div>
                <p style="color: #666; font-size: 0.9rem;">Basado en <?php echo e($product->reviews_count); ?> reseñas</p>
            </div>
        </div>

        <div style="background: #f8f9fa; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
            <?php if(auth()->guard()->check()): ?>
                <h3 style="font-weight: 600; margin-bottom: 1rem; font-size: 1.1rem;">
                    <?php echo e($userReview ? 'Editar tu reseña' : 'Deja tu reseña'); ?>

                </h3>
                <form method="POST" action="<?php echo e(route('reviews.store', $product)); ?>">
                    <?php echo csrf_field(); ?>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Calificación</label>
                        <select name="rating" style="padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;" required>
                            <?php for($i = 5; $i >= 1; $i--): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(old('rating', $userReview->rating ?? 5) == $i ? 'selected' : ''); ?>>
                                    <?php echo e(str_repeat('★', $i)); ?><?php echo e(str_repeat('☆', 5 - $i)); ?> (<?php echo e($i); ?>)
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Comentario</label>
                        <textarea name="comment" rows="3" maxlength="1000" required
                                  style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;"><?php echo e(old('comment', $userReview->comment ?? '')); ?></textarea>
                        <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color: #dc3545; font-size: 0.85rem;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo e($userReview ? 'Actualizar Reseña' : 'Publicar Reseña'); ?></button>
                </form>
            <?php else: ?>
                <p style="color: #666; margin: 0;">
                    <a href="<?php echo e(route('login')); ?>">Inicia sesión</a> para dejar tu reseña de este producto.
                </p>
            <?php endif; ?>
        </div>

        <?php if($product->reviews && $product->reviews->count() > 0): ?>
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <?php $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="border: 1px solid #e9ecef; border-radius: 8px; padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <strong><?php echo e($review->customer_name); ?></strong>
                            <span style="color: #999; font-size: 0.85rem;"><?php echo e($review->created_at->format('d/m/Y')); ?></span>
                        </div>
                        <div style="color: #f5a623; margin-bottom: 0.5rem;">
                            <?php echo e(str_repeat('★', $review->rating)); ?><?php echo e(str_repeat('☆', 5 - $review->rating)); ?>

                        </div>
                        <p style="color: #444; line-height: 1.5;"><?php echo e($review->comment); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p style="color: #666;">Este producto todavía no tiene reseñas.</p>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/catalog/show.blade.php ENDPATH**/ ?>