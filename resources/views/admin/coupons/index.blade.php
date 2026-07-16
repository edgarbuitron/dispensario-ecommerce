@extends('layouts.admin')

@section('title', 'Cupones - Administración')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">🎟️ Cupones</h1>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">➕ Nuevo Cupón</a>
</div>

@if($coupons->count() > 0)
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="text-align: left; padding: 1rem; font-weight: 600;">Código</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Descuento</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Usos</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Válido Hasta</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Estado</th>
                        <th style="text-align: center; padding: 1rem; font-weight: 600;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 1rem;">
                                <code style="background: #f8f9fa; padding: 0.5rem 1rem; border-radius: 4px;">{{ $coupon->code }}</code>
                            </td>
                            <td style="text-align: center; padding: 1rem; font-weight: 600;">
                                {{ $coupon->type === 'percentage' ? $coupon->discount_value . '%' : '$' . number_format($coupon->discount_value, 2) }}
                            </td>
                            <td style="text-align: center; padding: 1rem;">{{ $coupon->times_used }}/{{ $coupon->max_uses ?? '∞' }}</td>
                            <td style="text-align: center; padding: 1rem;">{{ $coupon->valid_until?->format('d/m/Y') ?? 'Sin vencimiento' }}</td>
                            <td style="text-align: center; padding: 1rem;">
                                <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; background: {{ $coupon->is_active ? '#d4edda' : '#f8d7da' }}; color: {{ $coupon->is_active ? '#155724' : '#721c24' }};">
                                    {{ $coupon->is_active ? '✓ Activo' : '✕ Inactivo' }}
                                </span>
                            </td>
                            <td style="text-align: center; padding: 1rem;">
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">✏️</a>
                                @if(auth('admin')->user()->isSuperAdmin())
                                    <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}" onsubmit="return confirm('¿Eliminar?');" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;">🗑️</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div style="text-align: center; padding: 4rem; background: #f8f9fa; border-radius: 8px;">
        <p style="color: #666; margin-bottom: 1.5rem;">No hay cupones registrados</p>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">Crear Primer Cupón</a>
    </div>
@endif

@endsection
