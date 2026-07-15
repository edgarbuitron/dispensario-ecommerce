@extends("layouts.admin")

@section("title", "Nuevo Producto")

@section("content")
<div class="row mb-4">
    <div class="col-md-8">
        <h2>Nuevo Producto</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf

                    @include('admin.products._form', ['product' => null])

                    <button type="submit" class="btn btn-success btn-lg">✅ Crear Producto</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
