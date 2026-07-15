@extends('layouts.client')

@section('title', 'Catálogo - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">
    
    <!-- Sidebar - Filtros -->
    <aside>
        <div style="background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h3 style="font-weight: 600; margin-bottom: 1.5rem; font-size: 1.1rem;">Filtros</h3>
            
            <form method="GET" action="{{ route('catalog.index') }}" style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Búsqueda -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Buscar</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                           placeholder="Nombre del producto..."
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                
                <!-- Categoría -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Categoría</label>
                    <select name="category" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ $filters['category'] === $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Marca -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Marca</label>
                    <select name="brand" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Todas las marcas</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->slug }}" {{ $filters['brand'] === $brand->slug ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Precio -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Precio Mínimo</label>
                    <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}"
                           placeholder="$0"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Precio Máximo</label>
                    <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}"
                           placeholder="$5000"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <!-- Ordenar por -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Ordenar por</label>
                    <select name="sort" onchange="this.form.submit()"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="newest" {{ $filters['sort'] === 'newest' ? 'selected' : '' }}>Más nuevo</option>
                        <option value="oldest" {{ $filters['sort'] === 'oldest' ? 'selected' : '' }}>Más viejo</option>
                        <option value="rating" {{ $filters['sort'] === 'rating' ? 'selected' : '' }}>Mejor calificados (estrellas)</option>
                        <option value="price-asc" {{ $filters['sort'] === 'price-asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                        <option value="price-desc" {{ $filters['sort'] === 'price-desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                        <option value="name-asc" {{ $filters['sort'] === 'name-asc' ? 'selected' : '' }}>Nombre: A a la Z</option>
                        <option value="name-desc" {{ $filters['sort'] === 'name-desc' ? 'selected' : '' }}>Nombre: Z a la A</option>
                    </select>
                </div>

                <!-- Descuento -->
                <div>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="on_sale" value="1" {{ !empty($filters['on_sale']) ? 'checked' : '' }}
                               onchange="this.form.submit()">
                        Solo con descuento
                    </label>
                </div>

                <!-- Botones -->
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Filtrar</button>
                    <a href="{{ route('catalog.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">Limpiar</a>
                </div>
            </form>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main>
        <!-- Header del Catálogo -->
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Catálogo de Productos</h1>
            <p style="color: #666;">{{ $products->total() }} productos encontrados</p>
        </div>

        <!-- Grid de Productos -->
        @if($products->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                @foreach($products as $product)
                    <div style="background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s; border: 1px solid #e9ecef; hover:box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                        
                        <div style="position: relative; width: 100%; height: 250px; background: #f8f9fa; overflow: hidden;">
                            @if($product->getPrimaryImage())
                                <img src="{{ asset('storage/products/' . $product->getPrimaryImage()->image_path) }}" 
                                     style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $product->name }}">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #e9ecef; font-size: 3rem;">📦</div>
                            @endif
                            
                            @if($product->stock_status === 'out_of_stock')
                                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600;">
                                    AGOTADO
                                </div>
                            @endif

                            @if($product->hasDiscount())
                                <span style="position: absolute; top: 10px; left: 10px; background: #dc3545; color: #fff; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                                    -{{ rtrim(rtrim(number_format($product->discount_percentage, 1), '0'), '.') }}%
                                </span>
                            @endif

                            @auth
                                <form method="POST" action="{{ route('wishlist.toggle', $product) }}" style="position: absolute; top: 10px; right: 10px;">
                                    @csrf
                                    <button type="submit" title="{{ in_array($product->id, $wishlistedIds ?? []) ? 'Quitar de favoritos' : 'Agregar a favoritos' }}"
                                            style="width: 34px; height: 34px; border-radius: 50%; border: none; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.2); font-size: 1rem; cursor: pointer; opacity: {{ in_array($product->id, $wishlistedIds ?? []) ? '1' : '0.6' }};">
                                        {{ in_array($product->id, $wishlistedIds ?? []) ? '❤️' : '🤍' }}
                                    </button>
                                </form>
                            @endauth
                        </div>

                        <div style="padding: 1.5rem;">
                            <h3 style="font-weight: 600; margin-bottom: 0.5rem;">
                                <a href="{{ route('product.show', $product->slug) }}" style="color: inherit; text-decoration: none;">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            @if($product->brand)
                                <p style="color: #999; font-size: 0.85rem; margin-bottom: 0.5rem;">{{ $product->brand->name }}</p>
                            @endif

                            <p style="color: #f5a623; font-size: 0.85rem; margin-bottom: 0.5rem;">
                                {{ str_repeat('★', round($product->rating)) }}{{ str_repeat('☆', 5 - round($product->rating)) }}
                                <span style="color: #999;">({{ $product->reviews_count }})</span>
                            </p>

                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem; height: 40px; overflow: hidden;">
                                {{ $product->short_description }}
                            </p>

                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <span>
                                    @if($product->hasDiscount())
                                        <span style="display: block; text-decoration: line-through; color: #999; font-size: 0.9rem;">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                        <span style="font-size: 1.5rem; font-weight: 700; color: #dc3545;">
                                            {{ $product->getFormattedFinalPrice() }}
                                        </span>
                                    @else
                                        <span style="font-size: 1.5rem; font-weight: 700; color: #000;">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    @endif
                                </span>
                                <span style="background: {{ $product->stock_status === 'out_of_stock' ? '#dc3545' : ($product->stock_status === 'low' ? '#ffc107' : '#28a745') }}; color: #fff; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem;">
                                    {{ $product->stock_status === 'out_of_stock' ? 'Agotado' : ($product->stock_status === 'low' ? 'Pocas' : 'Disponible') }}
                                </span>
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
            
            <!-- Paginación -->
            @if($products->hasPages())
                <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 3rem;">
                    @if($products->onFirstPage())
                        <span style="padding: 0.75rem 1rem; background: #e9ecef; border-radius: 4px; color: #999;">← Anterior</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="btn btn-secondary">← Anterior</a>
                    @endif
                    
                    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if($page == $products->currentPage())
                            <span style="padding: 0.75rem 1rem; background: #000; color: #fff; border-radius: 4px; font-weight: 600;">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" style="padding: 0.75rem 1rem; background: #e9ecef; border-radius: 4px; text-decoration: none; color: #333;">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="btn btn-secondary">Siguiente →</a>
                    @else
                        <span style="padding: 0.75rem 1rem; background: #e9ecef; border-radius: 4px; color: #999;">Siguiente →</span>
                    @endif
                </div>
            @endif
            
        @else
            <div style="text-align: center; padding: 4rem 2rem; background: #f8f9fa; border-radius: 8px;">
                <p style="font-size: 1.1rem; color: #666; margin-bottom: 1rem;">No hay productos que coincidan con tu búsqueda</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary">Ver todos los productos</a>
            </div>
        @endif
    </main>
</div>

@endsection
