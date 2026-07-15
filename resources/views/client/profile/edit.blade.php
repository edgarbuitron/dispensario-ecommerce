@extends('layouts.client')

@section('title', 'Editar Perfil - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">

    @include('client.profile._sidebar')

    <main>
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem; max-width: 500px;">
            <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">✏️ Editar Perfil</h1>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre Completo</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    @error('name') <div style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    @error('email') <div style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                           style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    @error('phone') <div style="color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">Guardar Cambios</button>
                <a href="{{ route('profile.index') }}" class="btn btn-secondary" style="padding: 0.75rem 2rem;">Cancelar</a>
            </form>
        </div>
    </main>
</div>

@endsection
