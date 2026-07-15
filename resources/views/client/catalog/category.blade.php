@extends("layouts.client")

@section("title", "Catálogo - " . $category->name)

@section("content")
<div class="container py-5">
    <h1>{{ $category->name }}</h1>
    <p class="text-muted">{{ $category->description }}</p>

    <div class="row">
        <div class="col-md-3">
            <h5>Filtros</h5>
            <form method="GET" class="mb-4">
                <div class="mb-3">
                    <label>Marca</label>
                    @foreach($brands as $brand)
                        <div class="form-check">
                            <input type="checkbox" name="brand" value="{{ $brand->slug }}" class="form-check-input">
                            <label class="form-check-label">{{ $brand->name }}</label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-dark w-100">Filtrar</button>
            </form>
        </div>

        <div class="col-md-9">
            @if($products->count())
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ asset($product->images->first()?->image_path ?? 'placeholder.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">${{ $product->price }}</p>
                                    <a href="/product/{{ $product->slug }}" class="btn btn-primary">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @else
                <p class="alert alert-info">No hay productos en esta categoría</p>
            @endif
        </div>
    </div>
</div>
@endsection
