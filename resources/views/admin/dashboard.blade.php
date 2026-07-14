@extends("layouts.admin")

@section("title", "Admin Dashboard")

@section("content")
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
            </div>
        </div>
    </div>
</div>
@endsection
