@extends('layouts.client')

@section('title', 'Mis Favoritos - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto;">
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">❤️ Mis Favoritos</h1>

    @if($products->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem;">
            @foreach($products as $product)
                <div style="background: #fff; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm); border: 1px solid var(--color-border);">
                    <div style="position: relative; width: 100%; height: 220px; background: var(--color-surface-alt);">
                        @if($product->getPrimaryImage())
                            <img src="{{ asset('storage/products/' . $product->getPrimaryImage()->image_path) }}"
                                 style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $product->name }}">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
                        @endif

                        <form method="POST" action="{{ route('wishlist.toggle', $product) }}" style="position: absolute; top: 10px; right: 10px;">
                            @csrf
                            <button type="submit" title="Quitar de favoritos"
                                    style="width: 36px; height: 36px; border-radius: 50%; border: none; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.2); font-size: 1.1rem; cursor: pointer;">
                                ❤️
                            </button>
                        </form>
                    </div>

                    <div style="padding: 1.5rem;">
                        <h3 style="font-weight: 600; margin-bottom: 0.5rem;">
                            <a href="{{ route('product.show', $product->slug) }}" style="color: inherit; text-decoration: none;">
                                {{ $product->name }}
                            </a>
                        </h3>

                        @if($product->brand)
                            <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-bottom: 1rem;">{{ $product->brand->name }}</p>
                        @endif

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            @if($product->hasDiscount())
                                <span>
                                    <span style="text-decoration: line-through; color: var(--color-text-muted); font-size: 0.85rem; margin-right: 0.5rem;">${{ number_format($product->price, 2) }}</span>
                                    <strong style="font-size: 1.3rem; color: var(--color-danger);">{{ $product->getFormattedFinalPrice() }}</strong>
                                </span>
                            @else
                                <strong style="font-size: 1.3rem;">${{ number_format($product->price, 2) }}</strong>
                            @endif
                        </div>

                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.75rem;">Ver</a>
                            @if($product->stock_status !== 'out_of_stock')
                                <form method="POST" action="{{ route('cart.add') }}" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">🛒</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem; background: var(--color-surface-alt); border-radius: var(--radius-lg);">
            <p style="font-size: 1.1rem; color: var(--color-text-muted); margin-bottom: 1rem;">Todavía no tienes productos favoritos</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">Explorar Catálogo</a>
        </div>
    @endif
</div>

@endsection
