<aside style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; height: fit-content;">
    <h2 style="font-weight: 700; margin-bottom: 1.5rem;">Mi Cuenta</h2>

    <nav style="display: flex; flex-direction: column; gap: 0.75rem;">
        <a href="<?php echo e(route('profile.index')); ?>" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; <?php echo e(request()->routeIs('profile.index') ? 'background: #000; color: #fff;' : ''); ?>">👤 Mi Perfil</a>
        <a href="<?php echo e(route('profile.addresses')); ?>" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; <?php echo e(request()->routeIs('profile.addresses*') ? 'background: #000; color: #fff;' : ''); ?>">📍 Direcciones</a>
        <a href="<?php echo e(route('profile.orders')); ?>" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; <?php echo e(request()->routeIs('profile.orders*') ? 'background: #000; color: #fff;' : ''); ?>">📦 Mis Órdenes</a>
        <a href="<?php echo e(route('profile.history')); ?>" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; <?php echo e(request()->routeIs('profile.history') ? 'background: #000; color: #fff;' : ''); ?>">🕓 Historial</a>
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin-top: auto;">
            <?php echo csrf_field(); ?>
            <button type="submit" style="width: 100%; padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; background: #f8f9fa; color: #666; border: none; cursor: pointer; text-align: left;">🚪 Cerrar Sesión</button>
        </form>
    </nav>
</aside>
<?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/profile/_sidebar.blade.php ENDPATH**/ ?>