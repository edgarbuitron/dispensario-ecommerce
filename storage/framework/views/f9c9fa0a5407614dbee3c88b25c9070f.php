<?php $category = $category ?? null; ?>

<?php $__env->startSection('title', isset($category) ? 'Editar Categoría' : 'Nueva Categoría'); ?>

<?php $__env->startSection('content'); ?>

<h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;"><?php echo e(isset($category) ? '✏️ Editar Categoría' : '➕ Nueva Categoría'); ?></h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(isset($category)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $category->name ?? '')); ?>" required>
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
                <textarea name="description" class="form-control" rows="3"><?php echo e(old('description', $category->description ?? '')); ?></textarea>
            </div>

            <?php if(isset($category) && $category->image): ?>
                <div class="mb-3">
                    <label class="form-label d-block">Imagen actual</label>
                    <img src="<?php echo e(asset('storage/categories/' . $category->image)); ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 1px solid #ddd;">
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label"><?php echo e(isset($category) ? 'Reemplazar imagen' : 'Imagen'); ?></label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Orden</label>
                <input type="number" name="sort_order" class="form-control" style="max-width: 150px;" value="<?php echo e(old('sort_order', $category->sort_order ?? 0)); ?>">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" <?php echo e(old('is_active', $category->is_active ?? true) ? 'checked' : ''); ?>>
                <label class="form-check-label">Activa</label>
            </div>

            <button type="submit" class="btn btn-success btn-lg">✅ Guardar</button>
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary btn-lg">Cancelar</a>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/categories/form.blade.php ENDPATH**/ ?>