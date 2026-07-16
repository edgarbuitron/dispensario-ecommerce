<?php $__env->startSection('title', 'Registro de Auditoría'); ?>

<?php $__env->startSection('content'); ?>

<h1 class="mb-4">🕵️ Registro de Auditoría</h1>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="action" class="form-select" onchange="this.form.submit()">
                    <option value="">Todas las acciones</option>
                    <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($action); ?>" <?php echo e(request('action') === $action ? 'selected' : ''); ?>><?php echo e($action); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-5">
                <select name="model_type" class="form-select" onchange="this.form.submit()">
                    <option value="">Todos los tipos</option>
                    <?php $__currentLoopData = $modelTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type); ?>" <?php echo e(request('model_type') === $type ? 'selected' : ''); ?>><?php echo e(class_basename($type)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <a href="<?php echo e(route('admin.audit-logs.index')); ?>" class="btn btn-outline-secondary w-100">Limpiar filtros</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Admin</th>
                    <th>Acción</th>
                    <th>Modelo</th>
                    <th>Detalles</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-nowrap"><?php echo e($log->created_at->format('d/m/Y H:i')); ?></td>
                        <td><?php echo e($log->adminUser->name ?? '—'); ?></td>
                        <td><span class="badge bg-secondary"><?php echo e($log->action); ?></span></td>
                        <td><?php echo e(class_basename($log->model_type)); ?> #<?php echo e($log->model_id); ?></td>
                        <td class="small text-muted">
                            <?php if($log->changes): ?>
                                <?php echo e(json_encode($log->changes)); ?>

                            <?php endif; ?>
                        </td>
                        <td class="small text-muted"><?php echo e($log->ip_address); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Todavía no hay actividad registrada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3"><?php echo e($logs->links()); ?></div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/audit-logs/index.blade.php ENDPATH**/ ?>