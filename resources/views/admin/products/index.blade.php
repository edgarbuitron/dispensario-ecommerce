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

<p class="text-muted small mb-2"><span id="visible-count">{{ $products->count() }}</span> de {{ $products->count() }} productos</p>

<div class="table-responsive">
    <table class="table table-striped align-middle" id="products-table">
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
            <tr class="table-light">
                <th></th>
                <th>
                    <input type="text" id="filter-name" class="form-control form-control-sm" placeholder="Filtrar...">
                </th>
                <th>
                    <select id="filter-category" class="form-select form-select-sm">
                        <option value="">Todas</option>
                        @foreach($categories as $category)
                            <option value="{{ strtolower($category->name) }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <select id="filter-brand" class="form-select form-select-sm">
                        <option value="">Todas</option>
                        @foreach($brands as $brand)
                            <option value="{{ strtolower($brand->name) }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <input type="text" id="filter-price" class="form-control form-control-sm" placeholder="Filtrar...">
                </th>
                <th>
                    <input type="text" id="filter-discount" class="form-control form-control-sm" placeholder="Filtrar...">
                </th>
                <th>
                    <select id="filter-stock" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="available">Disponible</option>
                        <option value="low">Pocas</option>
                        <option value="out_of_stock">Agotado</option>
                        <option value="hidden">Oculto</option>
                    </select>
                </th>
                <th>
                    <select id="filter-active" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr
                    data-name="{{ strtolower($product->name) }}"
                    data-category="{{ strtolower($product->category->name ?? '') }}"
                    data-brand="{{ strtolower($product->brand->name ?? '') }}"
                    data-price="{{ number_format($product->price, 2) }}"
                    data-discount="{{ $product->hasDiscount() ? rtrim(rtrim(number_format($product->discount_percentage, 1), '0'), '.') : '' }}"
                    data-stock="{{ $product->stock_status }}"
                    data-active="{{ $product->is_active ? '1' : '0' }}"
                >
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
                        <span class="text-muted small">({{ $product->stock_quantity }})</span>
                    </td>
                    <td>{{ $product->is_active ? 'Sí' : 'No' }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">Editar</a>
                        @if(auth('admin')->user()->isSuperAdmin())
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        @endif
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

<p id="no-results" class="text-muted text-center py-3" style="display: none;">Ningún producto coincide con los filtros.</p>

<a href="/admin" class="btn btn-secondary mt-3">Volver al Admin</a>

<script>
    (function () {
        const totalRows = document.querySelectorAll('#products-table tbody tr[data-name]');
        const visibleCount = document.getElementById('visible-count');
        const noResults = document.getElementById('no-results');

        const filters = {
            name: document.getElementById('filter-name'),
            category: document.getElementById('filter-category'),
            brand: document.getElementById('filter-brand'),
            price: document.getElementById('filter-price'),
            discount: document.getElementById('filter-discount'),
            stock: document.getElementById('filter-stock'),
            active: document.getElementById('filter-active'),
        };

        function applyFilters() {
            const values = {
                name: filters.name.value.trim().toLowerCase(),
                category: filters.category.value,
                brand: filters.brand.value,
                price: filters.price.value.trim().toLowerCase(),
                discount: filters.discount.value.trim().toLowerCase(),
                stock: filters.stock.value,
                active: filters.active.value,
            };

            let visible = 0;

            totalRows.forEach(function (row) {
                const matches =
                    row.dataset.name.includes(values.name) &&
                    (values.category === '' || row.dataset.category === values.category) &&
                    (values.brand === '' || row.dataset.brand === values.brand) &&
                    row.dataset.price.includes(values.price) &&
                    row.dataset.discount.includes(values.discount) &&
                    (values.stock === '' || row.dataset.stock === values.stock) &&
                    (values.active === '' || row.dataset.active === values.active);

                row.style.display = matches ? '' : 'none';
                if (matches) visible++;
            });

            visibleCount.textContent = visible;
            noResults.style.display = visible === 0 ? 'block' : 'none';
        }

        filters.name.addEventListener('input', applyFilters);
        filters.price.addEventListener('input', applyFilters);
        filters.discount.addEventListener('input', applyFilters);
        filters.category.addEventListener('change', applyFilters);
        filters.brand.addEventListener('change', applyFilters);
        filters.stock.addEventListener('change', applyFilters);
        filters.active.addEventListener('change', applyFilters);
    })();
</script>
@endsection