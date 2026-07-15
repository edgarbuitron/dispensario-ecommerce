<?php $banner = $banner ?? null; ?>

<?php $__env->startSection('title', isset($banner) ? 'Editar Banner' : 'Nuevo Banner'); ?>

<?php $__env->startSection('content'); ?>

<h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;"><?php echo e(isset($banner) ? '✏️ Editar Banner' : '➕ Nuevo Banner'); ?></h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(isset($banner) ? route('admin.banners.update', $banner->id) : route('admin.banners.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(isset($banner)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="title" class="form-control" value="<?php echo e(old('title', $banner->title ?? '')); ?>" required>
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Subtítulo</label>
                <textarea name="subtitle" class="form-control" rows="2"><?php echo e(old('subtitle', $banner->subtitle ?? '')); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Enlace (opcional)</label>
                <input type="url" name="link" class="form-control" placeholder="https://..." value="<?php echo e(old('link', $banner->link ?? '')); ?>">
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Posición</label>
                    <?php $position = old('position', $banner->position ?? 'hero'); ?>
                    <select name="position" class="form-select" required>
                        <option value="hero" <?php echo e($position === 'hero' ? 'selected' : ''); ?>>Hero (principal)</option>
                        <option value="secondary" <?php echo e($position === 'secondary' ? 'selected' : ''); ?>>Secundario</option>
                        <option value="bottom" <?php echo e($position === 'bottom' ? 'selected' : ''); ?>>Inferior</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha de inicio</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo e(old('start_date', isset($banner) ? $banner->start_date->format('Y-m-d') : now()->format('Y-m-d'))); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha de fin (opcional)</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo e(old('end_date', $banner?->end_date?->format('Y-m-d') ?? '')); ?>">
                </div>
            </div>

            <?php if(isset($banner) && $banner->image): ?>
                <div class="mb-3">
                    <label class="form-label d-block">Imagen actual</label>
                    <img src="<?php echo e(asset('storage/banners/' . $banner->image)); ?>" style="max-width: 300px; border-radius: 4px; border: 1px solid #ddd;">
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label"><?php echo e(isset($banner) ? 'Reemplazar imagen' : 'Imagen'); ?></label>
                <input type="file" name="image" class="form-control" accept="image/*" <?php echo e(isset($banner) ? '' : 'required'); ?>>
                <div class="form-text">Recomendado: 1600x400px aprox.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Orden</label>
                <input type="number" name="sort_order" class="form-control" style="max-width: 150px;" value="<?php echo e(old('sort_order', $banner->sort_order ?? 0)); ?>">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" <?php echo e(old('is_active', $banner->is_active ?? true) ? 'checked' : ''); ?>>
                <label class="form-check-label">Activo</label>
            </div>

            <button type="submit" class="btn btn-success btn-lg">✅ Guardar</button>
            <a href="<?php echo e(route('admin.banners.index')); ?>" class="btn btn-secondary btn-lg">Cancelar</a>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/banners/form.blade.php ENDPATH**/ ?>