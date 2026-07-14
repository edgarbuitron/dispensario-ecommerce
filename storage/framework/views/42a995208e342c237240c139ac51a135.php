

<?php $__env->startSection("title", "Catálogo - " . $category->name); ?>

<?php $__env->startSection("content"); ?>
<div class="container py-5">
    <h1><?php echo e($category->name); ?></h1>
    <p class="text-muted"><?php echo e($category->description); ?></p>

    <div class="row">
        <div class="col-md-3">
            <h5>Filtros</h5>
            <form method="GET" class="mb-4">
                <div class="mb-3">
                    <label>Marca</label>
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check">
                            <input type="checkbox" name="brand" value="<?php echo e($brand->slug); ?>" class="form-check-input">
                            <label class="form-check-label"><?php echo e($brand->name); ?></label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button type="submit" class="btn btn-dark w-100">Filtrar</button>
            </form>
        </div>

        <div class="col-md-9">
            <?php if($products->count()): ?>
                <div class="row">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?php echo e(asset($product->images->first()?->image_path ?? 'placeholder.jpg')); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo e($product->name); ?></h5>
                                    <p class="card-text">$<?php echo e($product->price); ?></p>
                                    <a href="/product/<?php echo e($product->slug); ?>" class="btn btn-primary">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="d-flex justify-content-center">
                    <?php echo e($products->links()); ?>

                </div>
            <?php else: ?>
                <p class="alert alert-info">No hay productos en esta categoría</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.client", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/catalog/category.blade.php ENDPATH**/ ?>