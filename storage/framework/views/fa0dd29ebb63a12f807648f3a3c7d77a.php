<?php $__env->startSection('title', 'Mi Perfil - Dispensario Premium'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">
    
    <?php echo $__env->make('client.profile._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Contenido Principal -->
    <main>
        <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1 style="font-size: 2rem; font-weight: 700;">👤 Mi Perfil</h1>
                <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-secondary">✏️ Editar</a>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">Nombre Completo</p>
                    <p style="font-weight: 600; font-size: 1.1rem;"><?php echo e(Auth::user()->name); ?></p>
                </div>
                
                <div>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">Email</p>
                    <p style="font-weight: 600; font-size: 1.1rem;"><?php echo e(Auth::user()->email); ?></p>
                </div>
                
                <div>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">Teléfono</p>
                    <p style="font-weight: 600; font-size: 1.1rem;"><?php echo e(Auth::user()->phone ?? 'No registrado'); ?></p>
                </div>
                
                <div>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">Miembro desde</p>
                    <p style="font-weight: 600; font-size: 1.1rem;"><?php echo e(Auth::user()->created_at->format('d/m/Y')); ?></p>
                </div>
            </div>
            
            <hr style="border: none; border-top: 1px solid var(--color-border); margin: 2rem 0;">
            
            <div style="background: var(--color-surface-alt); padding: 1.5rem; border-radius: var(--radius-sm);">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Estado de Verificación</h3>
                
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <?php if(Auth::user()->email_verified_at): ?>
                        <span style="display: inline-block; background: #d4edda; color: #155724; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">✓ Email Verificado</span>
                    <?php else: ?>
                        <span style="display: inline-block; background: #f8d7da; color: #721c24; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">✕ Email Sin Verificar</span>
                    <?php endif; ?>
                    
                    <?php if(Auth::user()->age_verified): ?>
                        <span style="display: inline-block; background: #d4edda; color: #155724; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">✓ Mayoría de Edad Verificada</span>
                    <?php else: ?>
                        <span style="display: inline-block; background: #fff3cd; color: #856404; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">⚠️ Verificar Mayoría de Edad</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Estadísticas -->
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; margin-top: 2rem;">
            <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 1.5rem; text-align: center;">
                <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">Órdenes Totales</p>
                <p style="font-size: 2rem; font-weight: 700;"><?php echo e(Auth::user()->orders->count()); ?></p>
            </div>
            
            <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 1.5rem; text-align: center;">
                <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">Gasto Total</p>
                <p style="font-size: 2rem; font-weight: 700; color: var(--color-accent);">$<?php echo e(number_format(Auth::user()->orders->sum('total'), 2)); ?></p>
            </div>
            
            <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 1.5rem; text-align: center;">
                <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">Direcciones Guardadas</p>
                <p style="font-size: 2rem; font-weight: 700;"><?php echo e(Auth::user()->addresses->count()); ?></p>
            </div>
        </div>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/profile/index.blade.php ENDPATH**/ ?>