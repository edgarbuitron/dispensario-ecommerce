@extends('layouts.admin')

@section('title', 'Banners - Administración')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">🖼️ Banners</h1>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">➕ Nuevo Banner</a>
</div>

@if($banners->count() > 0)
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Imagen</th>
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Título</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Posición</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Vigencia</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Estado</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 1rem;">
                                <img src="{{ asset('storage/banners/' . $banner->image) }}" style="width: 80px; height: 45px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td style="padding: 1rem;">{{ $banner->title }}</td>
                            <td style="text-align: center; padding: 1rem;">
                                <span style="text-transform: capitalize;">{{ $banner->position }}</span>
                            </td>
                            <td style="text-align: center; padding: 1rem; font-size: 0.85rem;">
                                {{ $banner->start_date->format('d/m/Y') }} - {{ $banner->end_date?->format('d/m/Y') ?? 'Indefinido' }}
                            </td>
                            <td style="text-align: center; padding: 1rem;">
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; background: {{ $banner->is_active ? '#d4edda' : '#f8d7da' }}; color: {{ $banner->is_active ? '#155724' : '#721c24' }};">
                                    {{ $banner->is_active ? '✓ Activo' : '✕ Inactivo' }}
                                </span>
                            </td>
                            <td style="text-align: center; padding: 1rem;">
                                <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">✏️</a>
                                <form method="POST" action="{{ route('admin.banners.destroy', $banner->id) }}" onsubmit="return confirm('¿Eliminar?');" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $banners->links() }}</div>
@else
    <div style="text-align: center; padding: 4rem; background: #f8f9fa; border-radius: 8px;">
        <p style="color: #666; margin-bottom: 1.5rem;">No hay banners registrados</p>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Crear Primer Banner</a>
    </div>
@endif

@endsection
