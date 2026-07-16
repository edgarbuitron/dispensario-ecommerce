<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent("title", "Admin"); ?> - Dispensario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-black: #0a0a0a;
            --brand-accent: #2f5d3a;
            --brand-accent-dark: #21422a;
            --brand-accent-light: #e7f0e9;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f7f7f5;
        }

        a { color: var(--brand-accent); }
        a:hover { color: var(--brand-accent-dark); }

        .bg-dark { background-color: var(--brand-black) !important; }

        .btn-primary, .btn-success {
            background-color: var(--brand-accent);
            border-color: var(--brand-accent);
        }

        .btn-primary:hover, .btn-primary:focus, .btn-success:hover, .btn-success:focus {
            background-color: var(--brand-accent-dark);
            border-color: var(--brand-accent-dark);
        }

        .btn-outline-primary {
            color: var(--brand-accent);
            border-color: var(--brand-accent);
        }

        .btn-outline-primary:hover {
            background-color: var(--brand-accent);
            border-color: var(--brand-accent);
        }

        .text-primary { color: var(--brand-accent) !important; }

        .badge.bg-success { background-color: var(--brand-accent) !important; }

        .form-control:focus, .form-select:focus {
            border-color: var(--brand-accent);
            box-shadow: 0 0 0 0.2rem var(--brand-accent-light);
        }

        .card {
            border: 1px solid #ececea;
            box-shadow: 0 1px 3px rgba(10, 10, 10, 0.05);
        }

        .table thead {
            background-color: #f7f7f5;
        }

        .secondary-nav {
            background: #fff;
        }

        .secondary-nav .nav-link {
            color: #4a4a48;
            font-weight: 500;
            border-radius: 6px;
            padding: 0.4rem 0.75rem;
        }

        .secondary-nav .nav-link:hover {
            background: var(--brand-accent-light);
            color: var(--brand-accent-dark);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">🌿 Dispensario Admin</span>
            <div>
                <a href="<?php echo e(route('admin.security.index')); ?>" class="btn btn-sm btn-outline-light me-2">🔐 Seguridad</a>
                <a href="/" class="btn btn-sm btn-outline-light me-2">Cliente</a>
                <a href="/admin/logout-now" class="btn btn-sm btn-outline-light">Salir</a>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg secondary-nav border-bottom">
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
                <?php if(auth('admin')->check() && auth('admin')->user()->isSuperAdmin()): ?>
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="nav-link">⚙️ Configuración</a>
                    <a href="<?php echo e(route('admin.audit-logs.index')); ?>" class="nav-link">🕵️ Auditoría</a>
                <?php endif; ?>
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