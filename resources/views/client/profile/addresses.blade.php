@extends('layouts.client')

@section('title', 'Mis Direcciones - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">

    @include('client.profile._sidebar')

    <main>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; font-weight: 700;">📍 Mis Direcciones</h1>
            <a href="{{ route('profile.addresses.create') }}" class="btn btn-primary">➕ Nueva Dirección</a>
        </div>

        @if($addresses->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                @foreach($addresses as $address)
                    <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 1.5rem; {{ $address->is_default ? 'border: 2px solid #000;' : '' }}">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <strong>{{ $address->label ?: 'Dirección' }}</strong>
                            @if($address->is_default)
                                <span style="background: #000; color: #fff; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem;">Predeterminada</span>
                            @endif
                        </div>
                        <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.25rem;">{{ $address->recipient_name }}</p>
                        <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 0.25rem;">{{ $address->getFullAddress() }}</p>
                        <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-bottom: 1rem;">📞 {{ $address->phone }}</p>

                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('profile.addresses.edit', $address) }}" class="btn btn-secondary" style="flex: 1; text-align: center; padding: 0.5rem;">✏️ Editar</a>
                            <form method="POST" action="{{ route('profile.addresses.delete', $address) }}" style="flex: 1;" onsubmit="return confirm('¿Eliminar esta dirección?');">
                                @csrf @method('POST')
                                <button type="submit" class="btn btn-danger" style="width: 100%; padding: 0.5rem;">🗑️ Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 4rem 2rem; background: var(--color-surface-alt); border-radius: var(--radius-lg);">
                <p style="color: var(--color-text-muted); margin-bottom: 1.5rem;">No tienes direcciones guardadas todavía</p>
                <a href="{{ route('profile.addresses.create') }}" class="btn btn-primary">Agregar mi primera dirección</a>
            </div>
        @endif
    </main>
</div>

@endsection
