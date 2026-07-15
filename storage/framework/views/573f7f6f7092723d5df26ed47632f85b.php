<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent("title", "Admin"); ?> - Dispensario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Dispensario Admin</span>
            <div>
                <a href="/" class="btn btn-sm btn-outline-light me-2">Cliente</a>
                <a href="/admin/logout-now" class="btn btn-sm btn-outline-light">Salir</a>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container-fluid">
            <div class="navbar-nav flex-row flex-wrap gap-2">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">🏠 Inicio</a>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="nav-link">📦 Productos</a>
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-link">📂 Categorías</a>
                <a href="<?php echo e(route('admin.brands.index')); ?>" class="nav-link">🏷️ Marcas</a>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="nav-link">🧾 Órdenes</a>
                <a href="<?php echo e(route('admin.proofs.index')); ?>" class="nav-link">💳 Comprobantes</a>
                <a href="<?php echo e(route('admin.coupons.index')); ?>" class="nav-link">🎟️ Cupones</a>
                <a href="<?php echo e(route('admin.banners.index')); ?>" class="nav-link">🖼️ Banners</a>
                <a href="<?php echo e(route('admin.settings.index')); ?>" class="nav-link">⚙️ Configuración</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <?php if(session("success")): ?>
            <div class="alert alert-success"><?php echo e(session("success")); ?></div>
        <?php endif; ?>
        <?php echo $__env->yieldContent("content"); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/layouts/admin.blade.php ENDPATH**/ ?>