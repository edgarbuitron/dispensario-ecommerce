@php $product = $product ?? null; @endphp

<div class="row mb-3">
    <div class="col-md-8">
        <label class="form-label">Nombre del Producto</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Tipo</label>
        <input type="text" name="type" class="form-control" placeholder="Vape, Flor, Aceite..." value="{{ old('type', $product->type ?? '') }}">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label">Categoría</label>
        <select name="category_id" class="form-select" required>
            <option value="">Selecciona una categoría</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Marca</label>
        <select name="brand_id" class="form-select">
            <option value="">Sin marca</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Presentación</label>
        <input type="text" name="presentation" class="form-control" placeholder="1g, 30ml, 10 piezas..." value="{{ old('presentation', $product->presentation ?? '') }}">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-3">
        <label class="form-label">Precio ($)</label>
        <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Descuento (%)</label>
        <input type="number" step="0.01" min="0" max="90" name="discount_percentage" class="form-control" placeholder="0"
               value="{{ old('discount_percentage', $product->discount_percentage ?? '') }}">
        <div class="form-text">Déjalo vacío si no tiene descuento.</div>
    </div>
    <div class="col-md-3">
        <label class="form-label">Costo ($)</label>
        <input type="number" step="0.01" min="0" name="cost_price" class="form-control" placeholder="Automático (40% del precio)"
               value="{{ old('cost_price', $product->cost_price ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Sabor</label>
        <input type="text" name="flavor" class="form-control" value="{{ old('flavor', $product->flavor ?? '') }}">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label">Cantidad en Stock</label>
        <input type="number" name="stock_quantity" class="form-control" min="0" step="1"
               value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}">
        <div class="form-text">El estado (Disponible/Pocas/Agotado) se calcula solo según esta cantidad.</div>
    </div>
    <div class="col-md-4">
        <label class="form-label">Estado de Stock</label>
        <select name="stock_status" class="form-select" required>
            @php $stock = old('stock_status', $product->stock_status ?? 'available'); @endphp
            <option value="available" {{ $stock === 'available' ? 'selected' : '' }}>✅ Disponible</option>
            <option value="low" {{ $stock === 'low' ? 'selected' : '' }}>⚠️ Pocas unidades</option>
            <option value="out_of_stock" {{ $stock === 'out_of_stock' ? 'selected' : '' }}>❌ Agotado</option>
            <option value="hidden" {{ $stock === 'hidden' ? 'selected' : '' }}>🚫 Oculto (no visible)</option>
        </select>
        <div class="form-text">Usa "Oculto" para retirarlo de la tienda sin borrarlo.</div>
    </div>
    <div class="col-md-4 d-flex align-items-end gap-4">
        <div class="form-check">
            <input type="checkbox" name="is_featured" class="form-check-input" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
            <label class="form-check-label">Destacado</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="is_new" class="form-check-input" value="1" {{ old('is_new', $product->is_new ?? false) ? 'checked' : '' }}>
            <label class="form-check-label">Nuevo</label>
        </div>
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Activo (visible en la tienda)</label>
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Descripción corta</label>
    <input type="text" name="short_description" class="form-control" maxlength="255" value="{{ old('short_description', $product->short_description ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
</div>

@if($product && $product->images->count() > 0)
    <div class="mb-3">
        <label class="form-label d-block">Imágenes actuales</label>
        <div class="d-flex flex-wrap gap-3">
            @foreach($product->images as $image)
                <div class="text-center">
                    <img src="{{ asset('storage/products/' . $image->image_path) }}"
                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px; border: {{ $image->is_primary ? '2px solid #198754' : '1px solid #ddd' }};">
                    <form method="POST" action="{{ route('admin.products.deleteImage', $image) }}" class="mt-1" onsubmit="return confirm('¿Eliminar esta imagen?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">{{ $product ? 'Agregar más imágenes' : 'Imágenes' }}</label>
    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
    <div class="form-text">Puedes seleccionar varias imágenes (JPG, PNG o WEBP, máx. 2MB cada una). La primera imagen se usa como principal.</div>
</div>
