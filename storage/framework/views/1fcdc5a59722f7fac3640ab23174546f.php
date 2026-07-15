<?php $__env->startSection('title', 'Cuentas Bancarias - Administración'); ?>

<?php $__env->startSection('content'); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">🏦 Cuentas Bancarias</h1>
    <a href="<?php echo e(route('admin.settings.index')); ?>" class="btn btn-outline-dark">⚙️ Configuración General</a>
</div>

<?php if($bankAccounts->count() > 0): ?>
    <div class="row mb-4">
        <?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="mb-0"><?php echo e($account->bank_name); ?></h5>
                            <span class="badge bg-<?php echo e($account->is_active ? 'success' : 'secondary'); ?>">
                                <?php echo e($account->is_active ? 'Activa' : 'Inactiva'); ?>

                            </span>
                        </div>
                        <p class="mb-1"><strong>Titular:</strong> <?php echo e($account->account_holder); ?></p>
                        <p class="mb-1"><strong>Cuenta:</strong> <?php echo e($account->account_number); ?></p>
                        <p class="mb-1"><strong>CLABE:</strong> <?php echo e($account->clabe); ?></p>
                        <?php if($account->swift_code): ?>
                            <p class="mb-1"><strong>SWIFT:</strong> <?php echo e($account->swift_code); ?></p>
                        <?php endif; ?>
                        <?php if($account->instructions): ?>
                            <p class="text-muted small mb-3"><?php echo e($account->instructions); ?></p>
                        <?php endif; ?>

                        <details>
                            <summary class="btn btn-sm btn-secondary">✏️ Editar</summary>
                            <form method="POST" action="<?php echo e(route('admin.settings.bankAccounts.update', $account->id)); ?>" class="mt-3">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <div class="mb-2">
                                    <label class="form-label small">Banco</label>
                                    <input type="text" name="bank_name" class="form-control form-control-sm" value="<?php echo e($account->bank_name); ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Titular</label>
                                    <input type="text" name="account_holder" class="form-control form-control-sm" value="<?php echo e($account->account_holder); ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Número de cuenta</label>
                                    <input type="text" name="account_number" class="form-control form-control-sm" value="<?php echo e($account->account_number); ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">CLABE</label>
                                    <input type="text" name="clabe" class="form-control form-control-sm" value="<?php echo e($account->clabe); ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">SWIFT (opcional)</label>
                                    <input type="text" name="swift_code" class="form-control form-control-sm" value="<?php echo e($account->swift_code); ?>">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Instrucciones</label>
                                    <textarea name="instructions" class="form-control form-control-sm" rows="2"><?php echo e($account->instructions); ?></textarea>
                                </div>
                                <div class="mb-2 form-check">
                                    <input type="checkbox" name="is_active" class="form-check-input" value="1" <?php echo e($account->is_active ? 'checked' : ''); ?>>
                                    <label class="form-check-label small">Activa</label>
                                </div>
                                <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                            </form>
                        </details>

                        <form method="POST" action="<?php echo e(route('admin.settings.bankAccounts.delete', $account->id)); ?>" onsubmit="return confirm('¿Eliminar esta cuenta?');" class="mt-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <p class="text-muted mb-4">No hay cuentas bancarias registradas todavía.</p>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">➕ Agregar cuenta bancaria</h5>
        <form method="POST" action="<?php echo e(route('admin.settings.bankAccounts.add')); ?>">
            <?php echo csrf_field(); ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Banco</label>
                    <input type="text" name="bank_name" class="form-control" value="<?php echo e(old('bank_name')); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Titular</label>
                    <input type="text" name="account_holder" class="form-control" value="<?php echo e(old('account_holder')); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Número de cuenta</label>
                    <input type="text" name="account_number" class="form-control" value="<?php echo e(old('account_number')); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">CLABE</label>
                    <input type="text" name="clabe" class="form-control" value="<?php echo e(old('clabe')); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">SWIFT (opcional)</label>
                    <input type="text" name="swift_code" class="form-control" value="<?php echo e(old('swift_code')); ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Instrucciones para el cliente</label>
                <textarea name="instructions" class="form-control" rows="2"><?php echo e(old('instructions')); ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">✅ Agregar Cuenta</button>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/settings/bank-accounts.blade.php ENDPATH**/ ?>