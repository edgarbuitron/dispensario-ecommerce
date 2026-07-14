@extends("layouts.admin")

@section("title", "Editar Producto")

@section("content")
<div class="row mb-4">
    <div class="col-md-8">
        <h2>Editar Producto: {{ $product->name }}</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route("admin.products.update", $product->id) }}">
                    @csrf
                    @method("PUT")

                    <div class="mb-3">
                        <label class="form-label">Nombre del Producto</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Precio ($)</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $product->is_active ? "checked" : "" }}>
                        <label class="form-check-label">Producto Activo</label>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg">✅ Guardar Cambios</button>
                    <a href="/admin/products" class="btn btn-secondary btn-lg">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
