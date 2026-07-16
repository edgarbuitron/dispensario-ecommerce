<?php $__env->startSection("title", "Editar Producto"); ?>

<?php $__env->startSection("content"); ?>
<div class="row mb-4">
    <div class="col-md-8">
        <h2>Editar Producto: <?php echo e($product->name); ?></h2>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.products.update', $product)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field("PUT"); ?>

                    <?php echo $__env->make('admin.products._form', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <button type="submit" class="btn btn-success btn-lg">✅ Guardar Cambios</button>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary btn-lg">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.admin", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>