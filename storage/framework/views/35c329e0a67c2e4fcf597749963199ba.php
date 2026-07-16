<?php $__env->startSection('title', 'Categorías - Administración'); ?>

<?php $__env->startSection('content'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">📂 Categorías</h1>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">➕ Nueva Categoría</a>
</div>

<?php if($categories->count() > 0): ?>
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Nombre</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Slug</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Productos</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 1rem;"><?php echo e($cat->name); ?></td>
                            <td style="text-align: center; padding: 1rem;"><code><?php echo e($cat->slug); ?></code></td>
                            <td style="text-align: center; padding: 1rem;"><?php echo e($cat->products_count ?? 0); ?></td>
                            <td style="text-align: center; padding: 1rem;">
                                <a href="<?php echo e(route('admin.categories.edit', $cat->id)); ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">✏️</a>
                                <?php if(auth('admin')->user()->isSuperAdmin()): ?>
                                    <form method="POST" action="<?php echo e(route('admin.categories.destroy', $cat->id)); ?>" onsubmit="return confirm('¿Eliminar?');" style="display: inline;">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;">🗑️</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div style="text-align: center; padding: 4rem; background: #f8f9fa; border-radius: 8px;">
        <p style="color: #666; margin-bottom: 1.5rem;">No hay categorías</p>
        <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">Crear Primera Categoría</a>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>