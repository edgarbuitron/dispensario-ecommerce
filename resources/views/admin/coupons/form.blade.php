@extends('layouts.admin')

@php $coupon = $coupon ?? null; @endphp

@section('title', isset($coupon) ? 'Editar Cupón' : 'Nuevo Cupón')

@section('content')

<h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">{{ isset($coupon) ? '✏️ Editar Cupón' : '➕ Nuevo Cupón' }}</h1>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($coupon) ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store') }}">
            @csrf
            @if(isset($coupon)) @method('PUT') @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Código</label>
                    <input type="text" name="code" class="form-control text-uppercase" value="{{ old('code', $coupon->code ?? '') }}" placeholder="VERANO20" required>
                    @error('code') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipo de descuento</label>
                    @php $type = old('type', $coupon->type ?? 'percentage'); @endphp
                    <select name="type" class="form-select" required>
                        <option value="percentage" {{ $type === 'percentage' ? 'selected' : '' }}>Porcentaje (%)</option>
                        <option value="fixed" {{ $type === 'fixed' ? 'selected' : '' }}>Monto fijo ($)</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description', $coupon->description ?? '') }}</textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Valor del descuento</label>
                    <input type="number" step="0.01" min="0" name="discount_value" class="form-control" value="{{ old('discount_value', $coupon->discount_value ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Compra mínima ($)</label>
                    <input type="number" step="0.01" min="0" name="minimum_purchase" class="form-control" value="{{ old('minimum_purchase', $coupon->minimum_purchase ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Máx. usos por cliente</label>
                    <input type="number" min="1" name="max_per_customer" class="form-control" value="{{ old('max_per_customer', $coupon->max_per_customer ?? 1) }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Máx. usos totales (opcional)</label>
                    <input type="number" min="1" name="max_uses" class="form-control" value="{{ old('max_uses', $coupon->max_uses ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Válido desde</label>
                    <input type="date" name="valid_from" class="form-control" value="{{ old('valid_from', isset($coupon) ? $coupon->valid_from->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Válido hasta (opcional)</label>
                    <input type="date" name="valid_until" class="form-control" value="{{ old('valid_until', $coupon?->valid_until?->format('Y-m-d') ?? '') }}">
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label">Activo</label>
            </div>

            <button type="submit" class="btn btn-success btn-lg">✅ Guardar</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
        </form>
    </div>
</div>

@endsection
