@extends('layouts.client')

@section('title', $product->name . ' - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
    
    <!-- Galería de Imágenes -->
    <div>
        <div style="position: relative; width: 100%; height: 500px; background: #f8f9fa; border-radius: 8px; overflow: hidden; margin-bottom: 1rem;">
            @if($product->getPrimaryImage())
                <img id="mainImage" src="{{ asset('storage/products/' . $product->getPrimaryImage()->image_path) }}" 
                     style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $product->name }}">
            @else
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 4rem;">📦</div>
            @endif
        </div>
        
        <!-- Miniaturas -->
        @if($product->images && $product->images->count() > 1)
            <div style="display: flex; gap: 1rem; overflow-x: auto;">
                @foreach($product->images as $image)
                    <img src="{{ asset('storage/products/' . $image->image_path) }}" 
                         onclick="document.getElementById('mainImage').src = this.src"
                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; cursor: pointer; border: 2px solid transparent; transition: border 0.3s;"
                         alt="{{ $product->name }}">
                @endforeach
            </div>
        @endif
    </div>
    
    <!-- Información del Producto -->
    <div>
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                @if($product->brand)
                    <span style="background: #f8f9fa; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                        {{ $product->brand->name }}
                    </span>
                @endif
                <span style="background: {{ $product->stock_status === 'out_of_stock' ? '#dc3545' : ($product->stock_status === 'low' ? '#ffc107' : '#28a745') }}; color: #fff; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                    {{ $product->stock_status === 'out_of_stock' ? '❌ Agotado' : ($product->stock_status === 'low' ? '⚠️ Pocas unidades' : '✅ Disponible') }}
                </span>
            </div>
            
            <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $product->name }}</h1>
            
            @if($product->category)
                <p style="color: #666; margin-bottom: 1rem;">
                    <a href="{{ route('category.show', $product->category->slug) }}" style="color: #666; text-decoration: none;">
                        {{ $product->category->name }}
                    </a>
                </p>
            @endif
            
            <p style="color: #666; line-height: 1.6; margin-bottom: 2rem;">
                {{ $product->description }}
            </p>
        </div>
        
        <!-- Precio -->
        <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="font-size: 3rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">
                ${{ number_format($product->price, 2) }}
            </div>
            <p style="color: #666; font-size: 0.9rem;">IVA incluido</p>
        </div>
        
        <!-- Atributos -->
        @if($product->attributes && $product->attributes->count() > 0)
            <div style="margin-bottom: 2rem;">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Características:</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
                    @foreach($product->attributes as $attr)
                        <li style="display: flex; gap: 0.5rem;">
                            <span style="color: #666;">{{ $attr->attribute_name }}:</span>
                            <strong>{{ $attr->attribute_value }}</strong>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Cantidad y Agregar al Carrito -->
        @if($product->stock_status !== 'out_of_stock')
            <form method="POST" action="{{ route('cart.add') }}" style="margin-bottom: 2rem;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Cantidad:</label>
                        <input type="number" name="quantity" value="1" min="1" max="10"
                               style="width: 80px; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem; margin-top: 1.5rem;">
                        🛒 Agregar al Carrito
                    </button>
                </div>
            </form>
        @else
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; font-weight: 600;">
                ❌ Este producto está actualmente agotado
            </div>
        @endif
        
        <!-- Información de Envío -->
        <div style="background: #d1ecf1; color: #0c5460; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
            <h4 style="font-weight: 600; margin-bottom: 0.5rem;">📦 Información de Envío</h4>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
                <li>✓ Envío a CDMX: 3-5 días hábiles</li>
                <li>✓ Envío a otros estados: 5-10 días hábiles</li>
                <li>✓ Envío gratis en compras mayores a $500</li>
            </ul>
        </div>
        
        <!-- Compartir -->
        <div style="border-top: 1px solid #e9ecef; padding-top: 2rem;">
            <p style="font-weight: 600; margin-bottom: 1rem;">Compartir:</p>
            <div style="display: flex; gap: 1rem;">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                   target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #1877f2; color: #fff; border-radius: 50%; text-decoration: none;">
                    f
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->name) }}" 
                   target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #1da1f2; color: #fff; border-radius: 50%; text-decoration: none;">
                    𝕏
                </a>
                <a href="https://wa.me/?text={{ urlencode($product->name . ' ' . url()->current()) }}" 
                   target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #25d366; color: #fff; border-radius: 50%; text-decoration: none;">
                    W
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Productos Relacionados -->
@if($relatedProducts && $relatedProducts->count() > 0)
    <div style="margin-top: 4rem; padding-top: 2rem; border-top: 2px solid #e9ecef;">
        <div class="container">
            <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">Productos Relacionados</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem;">
                @foreach($relatedProducts as $related)
                    <div style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e9ecef;">
                        <div style="position: relative; width: 100%; height: 250px; background: #f8f9fa;">
                            @if($related->getPrimaryImage())
                                <img src="{{ asset('storage/products/' . $related->getPrimaryImage()->image_path) }}" 
                                     style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $related->name }}">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
                            @endif
                        </div>
                        
                        <div style="padding: 1.5rem;">
                            <h3 style="font-weight: 600; margin-bottom: 0.5rem;">
                                <a href="{{ route('product.show', $related->slug) }}" style="color: inherit; text-decoration: none;">
                                    {{ $related->name }}
                                </a>
                            </h3>
                            
                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">{{ $related->short_description }}</p>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 1.5rem; font-weight: 700;">
                                    ${{ number_format($related->price, 2) }}
                                </span>
                            </div>
                            
                            <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                                <a href="{{ route('product.show', $related->slug) }}" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.75rem;">Ver</a>
                                <form method="POST" action="{{ route('cart.add') }}" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $related->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">🛒</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

@endsection
