@extends("layouts.admin")

@section("title", "Editar Producto")

@section("content")
<div class="row mb-4">
    <div class="col-md-8">
        <h2>Editar Producto: {{ $product->name }}</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")

                    @include('admin.products._form', ['product' => $product])

                    <button type="submit" class="btn btn-success btn-lg">✅ Guardar Cambios</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
