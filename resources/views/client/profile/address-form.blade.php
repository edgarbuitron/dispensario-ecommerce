@extends('layouts.client')

@php $address = $address ?? null; @endphp

@section('title', $address ? 'Editar Dirección' : 'Nueva Dirección')

@section('content')

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">

    @include('client.profile._sidebar')

    <main>
        <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 2rem; max-width: 600px;">
            <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">
                {{ $address ? '✏️ Editar Dirección' : '➕ Nueva Dirección' }}
            </h1>

            <form method="POST" action="{{ $address ? route('profile.addresses.update', $address) : route('profile.addresses.store') }}">
                @csrf
                @if($address) @method('POST') @endif

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre de la dirección (opcional)</label>
                    <input type="text" name="label" placeholder="Casa, Oficina..." value="{{ old('label', $address->label ?? '') }}"
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre de quien recibe</label>
                    <input type="text" name="recipient_name" value="{{ old('recipient_name', $address->recipient_name ?? '') }}" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone', $address->phone ?? '') }}" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Calle y número</label>
                    <input type="text" name="street_address" value="{{ old('street_address', $address->street_address ?? '') }}" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Referencia (opcional)</label>
                    <input type="text" name="reference" placeholder="Entre calles, color de fachada..." value="{{ old('reference', $address->reference ?? '') }}"
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Ciudad</label>
                        <input type="text" name="city" value="{{ old('city', $address->city ?? '') }}" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Estado</label>
                        <input type="text" name="state" value="{{ old('state', $address->state ?? '') }}" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem; max-width: 200px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Código Postal</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm);">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_default" value="1" {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }}>
                        Usar como dirección predeterminada
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">Guardar Dirección</button>
                <a href="{{ route('profile.addresses') }}" class="btn btn-secondary" style="padding: 0.75rem 2rem;">Cancelar</a>
            </form>
        </div>
    </main>
</div>

@endsection
