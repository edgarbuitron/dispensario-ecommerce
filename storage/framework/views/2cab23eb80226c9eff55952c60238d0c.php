<?php $brand = $brand ?? null; ?>

<?php $__env->startSection('title', isset($brand) ? 'Editar Marca' : 'Nueva Marca'); ?>

<?php $__env->startSection('content'); ?>

<h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;"><?php echo e(isset($brand) ? '✏️ Editar Marca' : '➕ Nueva Marca'); ?></h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(isset($brand) ? route('admin.brands.update', $brand->id) : route('admin.brands.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(isset($brand)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $brand->name ?? '')); ?>" required>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="3"><?php echo e(old('description', $brand->description ?? '')); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Sitio web</label>
                <input type="url" name="website" class="form-control" placeholder="https://..." value="<?php echo e(old('website', $brand->website ?? '')); ?>">
            </div>

            <?php if(isset($brand) && $brand->logo): ?>
                <div class="mb-3">
                    <label class="form-label d-block">Logo actual</label>
                    <img src="<?php echo e(asset('storage/brands/' . $brand->logo)); ?>" style="width: 100px; height: 100px; object-fit: contain; border-radius: 4px; border: 1px solid #ddd;">
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label"><?php echo e(isset($brand) ? 'Reemplazar logo' : 'Logo'); ?></label>
                <input type="file" name="logo" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Orden</label>
                <input type="number" name="sort_order" class="form-control" style="max-width: 150px;" value="<?php echo e(old('sort_order', $brand->sort_order ?? 0)); ?>">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" <?php echo e(old('is_active', $brand->is_active ?? true) ? 'checked' : ''); ?>>
                <label class="form-check-label">Activa</label>
            </div>

            <button type="submit" class="btn btn-success btn-lg">✅ Guardar</button>
            <a href="<?php echo e(route('admin.brands.index')); ?>" class="btn btn-secondary btn-lg">Cancelar</a>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/brands/form.blade.php ENDPATH**/ ?>