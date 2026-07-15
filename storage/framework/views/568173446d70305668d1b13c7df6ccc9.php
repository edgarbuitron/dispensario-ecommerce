<?php $__env->startSection("title", "Productos Admin"); ?>

<?php $__env->startSection("content"); ?>
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h1>Gestión de Productos</h1>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-success">➕ Nuevo Producto</a>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Stock</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($product->id); ?></td>
                    <td><?php echo e($product->name); ?></td>
                    <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                    <td><?php echo e($product->brand->name ?? '-'); ?></td>
                    <td>$<?php echo e(number_format($product->price, 2)); ?></td>
                    <td>
                        <?php if($product->hasDiscount()): ?>
                            <span class="badge bg-danger">-<?php echo e(rtrim(rtrim(number_format($product->discount_percentage, 1), '0'), '.')); ?>%</span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                            $stockLabels = ['available' => ['✅ Disponible', 'success'], 'low' => ['⚠️ Pocas', 'warning'], 'out_of_stock' => ['❌ Agotado', 'danger'], 'hidden' => ['🚫 Oculto', 'secondary']];
                            [$label, $color] = $stockLabels[$product->stock_status] ?? ['-', 'secondary'];
                        ?>
                        <span class="badge bg-<?php echo e($color); ?>"><?php echo e($label); ?></span>
                    </td>
                    <td><?php echo e($product->is_active ? 'Sí' : 'No'); ?></td>
                    <td class="d-flex gap-2">
                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-primary">Editar</a>
                        <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>" onsubmit="return confirm('¿Eliminar este producto?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" class="text-center text-muted">No hay productos</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo e($products->links()); ?>


<a href="/admin" class="btn btn-secondary mt-3">Volver al Admin</a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.admin", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/products/index.blade.php ENDPATH**/ ?>