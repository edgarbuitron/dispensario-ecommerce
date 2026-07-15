@extends('layouts.admin')

@php $brand = $brand ?? null; @endphp

@section('title', isset($brand) ? 'Editar Marca' : 'Nueva Marca')

@section('content')

<h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">{{ isset($brand) ? '✏️ Editar Marca' : '➕ Nueva Marca' }}</h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($brand) ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($brand)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $brand->name ?? '') }}" required>
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $brand->description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Sitio web</label>
                <input type="url" name="website" class="form-control" placeholder="https://..." value="{{ old('website', $brand->website ?? '') }}">
            </div>

            @if(isset($brand) && $brand->logo)
                <div class="mb-3">
                    <label class="form-label d-block">Logo actual</label>
                    <img src="{{ asset('storage/brands/' . $brand->logo) }}" style="width: 100px; height: 100px; object-fit: contain; border-radius: 4px; border: 1px solid #ddd;">
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">{{ isset($brand) ? 'Reemplazar logo' : 'Logo' }}</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Orden</label>
                <input type="number" name="sort_order" class="form-control" style="max-width: 150px;" value="{{ old('sort_order', $brand->sort_order ?? 0) }}">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $brand->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label">Activa</label>
            </div>

            <button type="submit" class="btn btn-success btn-lg">✅ Guardar</button>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
        </form>
    </div>
</div>

@endsection
