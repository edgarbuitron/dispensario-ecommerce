@extends('layouts.admin')

@php $banner = $banner ?? null; @endphp

@section('title', isset($banner) ? 'Editar Banner' : 'Nuevo Banner')

@section('content')

<h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">{{ isset($banner) ? '✏️ Editar Banner' : '➕ Nuevo Banner' }}</h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($banner) ? route('admin.banners.update', $banner->id) : route('admin.banners.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($banner)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title ?? '') }}" required>
                @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Subtítulo</label>
                <textarea name="subtitle" class="form-control" rows="2">{{ old('subtitle', $banner->subtitle ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Enlace (opcional)</label>
                <input type="url" name="link" class="form-control" placeholder="https://..." value="{{ old('link', $banner->link ?? '') }}">
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Posición</label>
                    @php $position = old('position', $banner->position ?? 'hero'); @endphp
                    <select name="position" class="form-select" required>
                        <option value="hero" {{ $position === 'hero' ? 'selected' : '' }}>Hero (principal)</option>
                        <option value="secondary" {{ $position === 'secondary' ? 'selected' : '' }}>Secundario</option>
                        <option value="bottom" {{ $position === 'bottom' ? 'selected' : '' }}>Inferior</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha de inicio</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', isset($banner) ? $banner->start_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha de fin (opcional)</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $banner?->end_date?->format('Y-m-d') ?? '') }}">
                </div>
            </div>

            @if(isset($banner) && $banner->image)
                <div class="mb-3">
                    <label class="form-label d-block">Imagen actual</label>
                    <img src="{{ asset('storage/banners/' . $banner->image) }}" style="max-width: 300px; border-radius: 4px; border: 1px solid #ddd;">
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">{{ isset($banner) ? 'Reemplazar imagen' : 'Imagen' }}</label>
                <input type="file" name="image" class="form-control" accept="image/*" {{ isset($banner) ? '' : 'required' }}>
                <div class="form-text">Recomendado: 1600x400px aprox.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Orden</label>
                <input type="number" name="sort_order" class="form-control" style="max-width: 150px;" value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label">Activo</label>
            </div>

            <button type="submit" class="btn btn-success btn-lg">✅ Guardar</button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
        </form>
    </div>
</div>

@endsection
