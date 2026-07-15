@extends("layouts.admin")

@section("title", "Productos Admin")

@section("content")
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h1>Gestión de Productos</h1>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">➕ Nuevo Producto</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Stock</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ $product->brand->name ?? '-' }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        @if($product->hasDiscount())
                            <span class="badge bg-danger">-{{ rtrim(rtrim(number_format($product->discount_percentage, 1), '0'), '.') }}%</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @php
                            $stockLabels = ['available' => ['✅ Disponible', 'success'], 'low' => ['⚠️ Pocas', 'warning'], 'out_of_stock' => ['❌ Agotado', 'danger'], 'hidden' => ['🚫 Oculto', 'secondary']];
                            [$label, $color] = $stockLabels[$product->stock_status] ?? ['-', 'secondary'];
                        @endphp
                        <span class="badge bg-{{ $color }}">{{ $label }}</span>
                    </td>
                    <td>{{ $product->is_active ? 'Sí' : 'No' }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">No hay productos</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $products->links() }}

<a href="/admin" class="btn btn-secondary mt-3">Volver al Admin</a>
@endsection
