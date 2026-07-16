@extends('layouts.client')

@section('title', $product->meta_title ?: $product->name . ' - Dispensario Premium')
@section('meta_description', $product->meta_description ?: Str::limit(strip_tags($product->description ?: $product->short_description), 160))
@section('meta_keywords', $product->meta_keywords ?: $product->name . ', ' . ($product->category->name ?? '') . ', ' . ($product->brand->name ?? ''))
@section('og_title', $product->name)
@section('og_description', Str::limit(strip_tags($product->description ?: $product->short_description), 160))
@section('og_image', $product->getPrimaryImage() ? asset('storage/products/' . $product->getPrimaryImage()->image_path) : '')

@php
    $productSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'description' => strip_tags($product->description ?: $product->short_description),
        'sku' => $product->sku,
        'offers' => [
            '@type' => 'Offer',
            'url' => url()->current(),
            'priceCurrency' => 'MXN',
            'price' => $product->hasDiscount() ? $product->getFinalPrice() : $product->price,
            'availability' => $product->stock_status === 'out_of_stock' ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock',
        ],
    ];

    if ($product->brand) {
        $productSchema['brand'] = ['@type' => 'Brand', 'name' => $product->brand->name];
    }

    if ($product->getPrimaryImage()) {
        $productSchema['image'] = asset('storage/products/' . $product->getPrimaryImage()->image_path);
    }

    if ($product->reviews_count > 0) {
        $productSchema['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => $product->rating,
            'reviewCount' => $product->reviews_count,
        ];
    }
@endphp

@push('css')
<script type="application/ld+json">{!! json_encode($productSchema) !!}</script>
@endpush

@section('content')

<div class="container" style="margin: 2.5rem auto; display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">

    <!-- Galería de Imágenes -->
    <div>
        @if($product->images && $product->images->count() > 0)
            <div style="position: relative; width: 100%; height: 500px; background: var(--color-surface-alt); border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 1rem;">
                <img id="mainImage" src="{{ asset('storage/products/' . $product->images->first()->image_path) }}"
                     onclick="openLightbox()"
                     style="width: 100%; height: 100%; object-fit: cover; cursor: zoom-in;" alt="{{ $product->name }}">

                @if($product->images->count() > 1)
                    <button type="button" onclick="showImage(currentIndex - 1)"
                            style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; border: none; background: rgba(255,255,255,0.92); box-shadow: var(--shadow-sm); font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        ‹
                    </button>
                    <button type="button" onclick="showImage(currentIndex + 1)"
                            style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; border: none; background: rgba(255,255,255,0.92); box-shadow: var(--shadow-sm); font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        ›
                    </button>
                @endif
            </div>

            <!-- Miniaturas -->
            @if($product->images->count() > 1)
                <div style="display: flex; gap: 0.85rem; overflow-x: auto;">
                    @foreach($product->images as $index => $image)
                        <img src="{{ asset('storage/products/' . $image->image_path) }}"
                             data-thumb="{{ $index }}"
                             onclick="showImage({{ $index }})"
                             class="product-thumb"
                             style="width: 76px; height: 76px; object-fit: cover; border-radius: var(--radius-sm); cursor: pointer; border: 2px solid {{ $index === 0 ? 'var(--color-accent)' : 'transparent' }}; transition: border var(--transition); flex-shrink: 0;"
                             alt="{{ $product->name }}">
                    @endforeach
                </div>
            @endif
        @else
            <div style="width: 100%; height: 500px; background: var(--color-surface-alt); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: 4rem;">📦</div>
        @endif
    </div>

    <!-- Lightbox -->
    @if($product->images && $product->images->count() > 0)
        <div id="lightbox" onclick="if(event.target === this) closeLightbox()"
             style="display: none; position: fixed; inset: 0; background: rgba(10,10,10,0.94); z-index: 1000; flex-direction: column; align-items: center; justify-content: center; padding: 2rem;">
            <button type="button" onclick="closeLightbox()"
                    style="position: absolute; top: 20px; right: 30px; background: none; border: none; color: #fff; font-size: 2.5rem; cursor: pointer; line-height: 1;">
                &times;
            </button>

            <div style="position: relative; width: 100%; max-width: 900px; display: flex; align-items: center; justify-content: center;">
                @if($product->images->count() > 1)
                    <button type="button" onclick="showImage(currentIndex - 1)"
                            style="position: absolute; left: -10px; width: 50px; height: 50px; border-radius: 50%; border: none; background: rgba(255,255,255,0.9); font-size: 1.5rem; cursor: pointer;">
                        ‹
                    </button>
                @endif

                <img id="lightboxImage" src="{{ asset('storage/products/' . $product->images->first()->image_path) }}"
                     style="max-width: 100%; max-height: 78vh; object-fit: contain; border-radius: var(--radius-sm);" alt="{{ $product->name }}">

                @if($product->images->count() > 1)
                    <button type="button" onclick="showImage(currentIndex + 1)"
                            style="position: absolute; right: -10px; width: 50px; height: 50px; border-radius: 50%; border: none; background: rgba(255,255,255,0.9); font-size: 1.5rem; cursor: pointer;">
                        ›
                    </button>
                @endif
            </div>

            @if($product->images->count() > 1)
                <div style="display: flex; gap: 0.75rem; overflow-x: auto; margin-top: 1.5rem; max-width: 900px; padding: 0.5rem;">
                    @foreach($product->images as $index => $image)
                        <img src="{{ asset('storage/products/' . $image->image_path) }}"
                             data-lightbox-thumb="{{ $index }}"
                             onclick="showImage({{ $index }})"
                             class="lightbox-thumb"
                             style="width: 70px; height: 70px; object-fit: cover; border-radius: var(--radius-sm); cursor: pointer; border: 2px solid {{ $index === 0 ? '#fff' : 'transparent' }}; opacity: {{ $index === 0 ? '1' : '0.6' }}; flex-shrink: 0;"
                             alt="{{ $product->name }}">
                    @endforeach
                </div>
            @endif
        </div>

        <script>
            const productImages = @json($product->images->map(fn($img) => asset('storage/products/' . $img->image_path)));
            let currentIndex = 0;

            function showImage(index) {
                currentIndex = (index + productImages.length) % productImages.length;
                const url = productImages[currentIndex];

                const mainImage = document.getElementById('mainImage');
                if (mainImage) mainImage.src = url;

                const lightboxImage = document.getElementById('lightboxImage');
                if (lightboxImage) lightboxImage.src = url;

                document.querySelectorAll('.product-thumb').forEach((thumb) => {
                    thumb.style.border = Number(thumb.dataset.thumb) === currentIndex ? '2px solid #2f5d3a' : '2px solid transparent';
                });

                document.querySelectorAll('.lightbox-thumb').forEach((thumb) => {
                    const active = Number(thumb.dataset.lightboxThumb) === currentIndex;
                    thumb.style.border = active ? '2px solid #fff' : '2px solid transparent';
                    thumb.style.opacity = active ? '1' : '0.6';
                });
            }

            function openLightbox() {
                document.getElementById('lightbox').style.display = 'flex';
                document.body.style.overflow = 'hidden';
                showImage(currentIndex);
            }

            function closeLightbox() {
                document.getElementById('lightbox').style.display = 'none';
                document.body.style.overflow = '';
            }

            document.addEventListener('keydown', function (e) {
                const lightbox = document.getElementById('lightbox');
                if (!lightbox || lightbox.style.display !== 'flex') return;

                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
                if (e.key === 'ArrowRight') showImage(currentIndex + 1);
            });
        </script>
    @endif

    <!-- Información del Producto -->
    <div>
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; flex-wrap: wrap;">
                @if($product->brand)
                    <span class="badge-pill badge-muted" style="font-size: 0.85rem;">
                        {{ $product->brand->name }}
                    </span>
                @endif
                @php
                    $stockClass = $product->stock_status === 'out_of_stock' ? 'badge-danger' : ($product->stock_status === 'low' ? 'badge-warning' : 'badge-success');
                @endphp
                <span class="badge-pill {{ $stockClass }}" style="font-size: 0.85rem;">
                    {{ $product->stock_status === 'out_of_stock' ? '❌ Agotado' : ($product->stock_status === 'low' ? '⚠️ ¡Solo quedan ' . $product->stock_quantity . ' unidades!' : '✅ Disponible') }}
                </span>

                @auth
                    <form method="POST" action="{{ route('wishlist.toggle', $product) }}">
                        @csrf
                        @php $isWishlisted = in_array($product->id, $wishlistedIds ?? []); @endphp
                        <button type="submit" style="background: none; border: 1px solid var(--color-border); padding: 0.4rem 0.9rem; border-radius: var(--radius-full); cursor: pointer; font-weight: 600; font-size: 0.85rem;">
                            {{ $isWishlisted ? '❤️ En favoritos' : '🤍 Agregar a favoritos' }}
                        </button>
                    </form>
                @endauth
            </div>

            <h1 style="font-size: 2.25rem; margin-bottom: 0.5rem;">{{ $product->name }}</h1>

            @if($product->category)
                <p class="text-muted" style="margin-bottom: 1rem;">
                    <a href="{{ route('category.show', $product->category->slug) }}" style="color: var(--color-text-muted); text-decoration: none;">
                        {{ $product->category->name }}
                    </a>
                </p>
            @endif

            <p class="text-muted" style="line-height: 1.6; margin-bottom: 2rem;">
                {{ $product->description }}
            </p>
        </div>

        <!-- Precio -->
        <div class="card" style="padding: 1.75rem; margin-bottom: 2rem; background: var(--color-surface-alt); border: none;">
            @if($product->hasDiscount())
                <div style="display: flex; align-items: baseline; gap: 1rem; flex-wrap: wrap;">
                    <span style="font-size: 2.75rem; font-weight: 800; color: var(--color-danger); letter-spacing: -0.02em;">{{ $product->getFormattedFinalPrice() }}</span>
                    <span style="font-size: 1.25rem; color: var(--color-text-muted); text-decoration: line-through;">${{ number_format($product->price, 2) }}</span>
                    <span class="badge-pill badge-danger" style="font-weight: 700;">
                        -{{ rtrim(rtrim(number_format($product->discount_percentage, 1), '0'), '.') }}%
                    </span>
                </div>
            @else
                <div style="font-size: 2.75rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.5rem;">
                    ${{ number_format($product->price, 2) }}
                </div>
            @endif
            <p class="text-muted" style="font-size: 0.88rem; margin-top: 0.5rem;">IVA incluido</p>
        </div>

        <!-- Calificación -->
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem;">
            <span style="color: #f5a623; font-size: 1.2rem;">
                {{ str_repeat('★', round($product->rating)) }}{{ str_repeat('☆', 5 - round($product->rating)) }}
            </span>
            <span class="text-muted">{{ number_format($product->rating, 1) }} · {{ $product->reviews_count }} reseñas</span>
        </div>

        <!-- Atributos -->
        @if($product->attributes && $product->attributes->count() > 0)
            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem;">Características:</h3>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
                    @foreach($product->attributes as $attr)
                        <li style="display: flex; gap: 0.5rem;">
                            <span class="text-muted">{{ $attr->attribute_name }}:</span>
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

                <div style="display: flex; gap: 1rem; align-items: flex-end; margin-bottom: 2rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Cantidad:</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ min(10, $product->stock_quantity ?: 10) }}"
                               style="width: 80px; padding: 0.7rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-size: 1rem;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem;">
                        🛒 Agregar al Carrito
                    </button>
                </div>
            </form>
        @else
            <div class="alert alert-error" style="font-weight: 600;">
                ❌ Este producto está actualmente agotado
            </div>
        @endif

        <!-- Información de Envío -->
        <div style="background: var(--color-accent-light); color: var(--color-accent-dark); padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
            <h4 style="color: var(--color-accent-dark); font-size: 1rem; margin-bottom: 0.5rem;">📦 Información de Envío</h4>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.4rem; font-size: 0.9rem;">
                <li>✓ Envío a CDMX: 3-5 días hábiles</li>
                <li>✓ Envío a otros estados: 5-10 días hábiles</li>
                <li>✓ Envío gratis en compras mayores a $500</li>
            </ul>
        </div>

        <!-- Compartir -->
        <div style="border-top: 1px solid var(--color-border); padding-top: 2rem;">
            <p style="font-weight: 600; margin-bottom: 1rem; font-size: 0.9rem;">Compartir:</p>
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
    <div style="margin-top: 4rem; padding-top: 2.5rem; border-top: 1px solid var(--color-border);">
        <div class="container">
            <h2 style="font-size: 1.75rem; margin-bottom: 2rem;">Productos Relacionados</h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.75rem;">
                @foreach($relatedProducts as $related)
                    <div class="card" style="overflow: hidden;">
                        <div style="position: relative; width: 100%; height: 220px; background: var(--color-surface-alt);">
                            @if($related->getPrimaryImage())
                                <img src="{{ asset('storage/products/' . $related->getPrimaryImage()->image_path) }}"
                                     style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $related->name }}">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
                            @endif
                        </div>

                        <div style="padding: 1.25rem;">
                            <h3 style="font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">
                                <a href="{{ route('product.show', $related->slug) }}" style="color: inherit; text-decoration: none;">
                                    {{ $related->name }}
                                </a>
                            </h3>

                            <p class="text-muted" style="font-size: 0.88rem; margin-bottom: 1rem;">{{ $related->short_description }}</p>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <strong style="font-size: 1.3rem;">
                                    ${{ number_format($related->price, 2) }}
                                </strong>
                            </div>

                            <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                                <a href="{{ route('product.show', $related->slug) }}" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.65rem;">Ver</a>
                                <form method="POST" action="{{ route('cart.add') }}" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $related->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.65rem;">🛒</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- Reseñas de Clientes -->
<div style="margin-top: 4rem; padding-top: 2.5rem; padding-bottom: 4rem; border-top: 1px solid var(--color-border);">
    <div class="container" style="max-width: 900px;">
        <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">Reseñas de Clientes</h2>

        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <span style="font-size: 2.5rem; font-weight: 800;">{{ number_format($product->rating, 1) }}</span>
            <div>
                <div style="color: #f5a623; font-size: 1.3rem;">
                    {{ str_repeat('★', round($product->rating)) }}{{ str_repeat('☆', 5 - round($product->rating)) }}
                </div>
                <p class="text-muted" style="font-size: 0.9rem;">Basado en {{ $product->reviews_count }} reseñas</p>
            </div>
        </div>

        <div class="card" style="padding: 1.5rem; margin-bottom: 2rem; background: var(--color-surface-alt); border: none;">
            @auth
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem;">
                    {{ $userReview ? 'Editar tu reseña' : 'Deja tu reseña' }}
                </h3>
                <form method="POST" action="{{ route('reviews.store', $product) }}">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Calificación</label>
                        <select name="rating" style="padding: 0.6rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); background: #fff;" required>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('rating', $userReview->rating ?? 5) == $i ? 'selected' : '' }}>
                                    {{ str_repeat('★', $i) }}{{ str_repeat('☆', 5 - $i) }} ({{ $i }})
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">Comentario</label>
                        <textarea name="comment" rows="3" maxlength="1000" required
                                  style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">{{ old('comment', $userReview->comment ?? '') }}</textarea>
                        @error('comment') <div style="color: var(--color-danger); font-size: 0.85rem;">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{ $userReview ? 'Actualizar Reseña' : 'Publicar Reseña' }}</button>
                </form>
            @else
                <p class="text-muted" style="margin: 0;">
                    <a href="{{ route('login') }}">Inicia sesión</a> para dejar tu reseña de este producto.
                </p>
            @endauth
        </div>

        @if($product->reviews && $product->reviews->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                @foreach($product->reviews as $review)
                    <div class="card" style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <strong>{{ $review->customer_name }}</strong>
                            <span class="text-muted" style="font-size: 0.85rem;">{{ $review->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div style="color: #f5a623; margin-bottom: 0.5rem;">
                            {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                        </div>
                        <p style="color: var(--color-text); line-height: 1.5;">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Este producto todavía no tiene reseñas.</p>
        @endif
    </div>
</div>

@endsection
