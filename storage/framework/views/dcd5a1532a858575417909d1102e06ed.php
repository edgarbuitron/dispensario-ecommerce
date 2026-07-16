<?php $__env->startSection("title", "Admin Dashboard"); ?>

<?php $__env->startSection("content"); ?>

<h1 class="mb-4">Panel de Control</h1>

<!-- Estadísticas principales -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1 small">Ingresos Hoy</p>
                <h3 class="mb-0">$<?php echo e(number_format($stats['today_revenue'], 2)); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1 small">Ingresos del Mes</p>
                <h3 class="mb-0">$<?php echo e(number_format($stats['month_revenue'], 2)); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1 small">Ingresos del Año</p>
                <h3 class="mb-0">$<?php echo e(number_format($stats['year_revenue'], 2)); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1 small">Pedidos Pendientes</p>
                <h3 class="mb-0"><?php echo e($stats['pending_orders']); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1 small">Pedidos Totales</p>
                <h4 class="mb-0"><?php echo e($stats['total_orders']); ?></h4>
                <p class="text-muted small mb-0"><?php echo e($stats['today_orders']); ?> hoy · <?php echo e($stats['month_orders']); ?> este mes</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1 small">Clientes</p>
                <h4 class="mb-0"><?php echo e($stats['total_customers']); ?></h4>
                <p class="text-muted small mb-0"><?php echo e($stats['new_customers']); ?> nuevos este mes</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1 small">Productos Activos</p>
                <h4 class="mb-0"><?php echo e($stats['active_products']); ?> / <?php echo e($stats['total_products']); ?></h4>
                <p class="text-muted small mb-0"><?php echo e($stats['featured_products']); ?> destacados</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted mb-1 small">Agotados</p>
                <h4 class="mb-0 <?php echo e($stats['out_of_stock'] > 0 ? 'text-danger' : ''); ?>"><?php echo e($stats['out_of_stock']); ?></h4>
                <?php if($stats['out_of_stock'] > 0): ?>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="small">Revisar →</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Gráfica de ventas -->
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">Ventas de los últimos 7 días</h5></div>
            <div class="card-body">
                <canvas id="salesChart" height="90"></canvas>
            </div>
        </div>
    </div>

    <!-- Categorías más vendidas -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">Categorías con más productos</h5></div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $topCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span><?php echo e($category->name); ?></span>
                        <span class="badge bg-secondary"><?php echo e($category->products_count); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted mb-0">Sin datos todavía</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Pedidos pendientes de aprobar -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">⏳ Comprobantes por Revisar</h5></div>
            <div class="card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $pendingApprovals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                        <div>
                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="fw-semibold text-decoration-none"><?php echo e($order->order_number); ?></a>
                            <p class="text-muted small mb-0"><?php echo e($order->user->name); ?> · $<?php echo e(number_format($order->total, 2)); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-primary">Revisar</a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted p-3 mb-0">No hay comprobantes pendientes 🎉</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Órdenes recientes -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">Órdenes Recientes</h5></div>
            <div class="card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                        <div>
                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="fw-semibold text-decoration-none"><?php echo e($order->order_number); ?></a>
                            <p class="text-muted small mb-0"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <span class="badge bg-secondary"><?php echo e($order->getStatusLabel()); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted p-3 mb-0">Sin órdenes todavía</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0">Acciones Rápidas</h5></div>
    <div class="card-body d-flex flex-wrap gap-2">
        <a href="/admin/products" class="btn btn-primary">Gestionar Productos</a>
        <a href="/admin/orders" class="btn btn-success">Ver Órdenes</a>
        <a href="/admin/proofs" class="btn btn-warning">Comprobantes</a>
        <a href="/admin/categories" class="btn btn-info">Categorías</a>
        <a href="/admin/brands" class="btn btn-outline-primary">Marcas</a>
        <a href="/admin/coupons" class="btn btn-outline-success">Cupones</a>
        <a href="/admin/banners" class="btn btn-outline-warning">Banners</a>
        <a href="/admin/settings" class="btn btn-outline-secondary">Configuración</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($salesChart['labels'], 15, 512) ?>,
            datasets: [{
                label: 'Ventas ($)',
                data: <?php echo json_encode($salesChart['data'], 15, 512) ?>,
                borderColor: '#2f5d3a',
                backgroundColor: 'rgba(47, 93, 58, 0.1)',
                tension: 0.3,
                fill: true,
            }],
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } },
        },
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.admin", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>