@extends('layouts.admin')

@php $category = $category ?? null; @endphp

@section('title', isset($category) ? 'Editar Categoría' : 'Nueva Categoría')

@section('content')

<h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">{{ isset($category) ? '✏️ Editar Categoría' : '➕ Nueva Categoría' }}</h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($category)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
            </div>

            @if(isset($category) && $category->image)
                <div class="mb-3">
                    <label class="form-label d-block">Imagen actual</label>
                    <img src="{{ asset('storage/categories/' . $category->image) }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 1px solid #ddd;">
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">{{ isset($category) ? 'Reemplazar imagen' : 'Imagen' }}</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Orden</label>
                <input type="number" name="sort_order" class="form-control" style="max-width: 150px;" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label">Activa</label>
            </div>

            <button type="submit" class="btn btn-success btn-lg">✅ Guardar</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
        </form>
    </div>
</div>

@endsection
