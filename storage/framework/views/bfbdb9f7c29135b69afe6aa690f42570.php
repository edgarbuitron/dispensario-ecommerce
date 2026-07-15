<?php $__env->startSection('title', 'Marcas - Administración'); ?>

<?php $__env->startSection('content'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">🏷️ Marcas</h1>
    <a href="<?php echo e(route('admin.brands.create')); ?>" class="btn btn-primary">➕ Nueva Marca</a>
</div>

<?php if($brands->count() > 0): ?>
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Logo</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Nombre</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Slug</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Productos</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Estado</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 1rem;">
                                <?php if($brand->logo): ?>
                                    <img src="<?php echo e(asset('storage/brands/' . $brand->logo)); ?>" style="width: 48px; height: 48px; object-fit: contain; border-radius: 4px;">
                                <?php else: ?>
                                    <span style="color: #999;">—</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 1rem;"><?php echo e($brand->name); ?></td>
                            <td style="text-align: center; padding: 1rem;"><code><?php echo e($brand->slug); ?></code></td>
                            <td style="text-align: center; padding: 1rem;"><?php echo e($brand->products_count ?? 0); ?></td>
                            <td style="text-align: center; padding: 1rem;">
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; background: <?php echo e($brand->is_active ? '#d4edda' : '#f8d7da'); ?>; color: <?php echo e($brand->is_active ? '#155724' : '#721c24'); ?>;">
                                    <?php echo e($brand->is_active ? '✓ Activa' : '✕ Inactiva'); ?>

                                </span>
                            </td>
                            <td style="text-align: center; padding: 1rem;">
                                <a href="<?php echo e(route('admin.brands.edit', $brand->id)); ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">✏️</a>
                                <form method="POST" action="<?php echo e(route('admin.brands.destroy', $brand->id)); ?>" onsubmit="return confirm('¿Eliminar?');" style="display: inline;">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3"><?php echo e($brands->links()); ?></div>
<?php else: ?>
    <div style="text-align: center; padding: 4rem; background: #f8f9fa; border-radius: 8px;">
        <p style="color: #666; margin-bottom: 1.5rem;">No hay marcas registradas</p>
        <a href="<?php echo e(route('admin.brands.create')); ?>" class="btn btn-primary">Crear Primera Marca</a>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/brands/index.blade.php ENDPATH**/ ?>