<?php $__env->startSection("title", "Admin Dashboard"); ?>

<?php $__env->startSection("content"); ?>
<div class="row mb-4">
    <div class="col-md-12">
        <h1>Panel de Control Admin</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Acciones Rápidas</h5>
            </div>
            <div class="card-body">
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
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.admin", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>