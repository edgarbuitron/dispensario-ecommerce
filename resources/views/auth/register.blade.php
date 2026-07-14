@extends('layouts.client')

@section('title', 'Registrarse - Dispensario Premium')

@section('content')

<div style="max-width: 500px; margin: 4rem auto; padding: 2rem;">
    <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 2rem;">
        
        <h1 style="text-align: center; margin-bottom: 2rem;">Crear Cuenta</h1>

        @if ($errors->any())
            <div style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Formulario de Registro -->
        <form method="POST" action="{{ route('register') }}" style="margin-bottom: 2rem;">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre Completo</label>
                <input type="text" name="name" id="name" 
                       value="{{ old('name') }}"
                       required
                       placeholder="Tu nombre completo"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Correo Electrónico</label>
                <input type="email" name="email" id="email" 
                       value="{{ old('email') }}"
                       required
                       placeholder="tu@email.com"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Teléfono</label>
                <input type="tel" name="phone" id="phone" 
                       value="{{ old('phone') }}"
                       required
                       placeholder="5551234567"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Contraseña</label>
                <input type="password" name="password" id="password" 
                       required
                       placeholder="Mínimo 8 caracteres"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       required
                       placeholder="Repite tu contraseña"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: flex-start; cursor: pointer;">
                    <input type="checkbox" name="agree_terms" required style="margin-top: 0.25rem;">
                    <span style="margin-left: 0.5rem; font-size: 0.9rem;">
                        Acepto los <a href="{{ route('terms') }}" target="_blank" style="color: #000;">términos y condiciones</a>
                    </span>
                </label>
            </div>

            <button type="submit" style="width: 100%; padding: 0.75rem; background: #000; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; transition: background 0.3s;">
                Crear Cuenta
            </button>
        </form>

        <div style="text-align: center; margin-bottom: 2rem; color: #666;">
            ── O ──
        </div>

        <!-- Google OAuth - SOLO PARA CLIENTES -->
        <a href="{{ route('google.redirect') }}" 
           style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; padding: 0.75rem; background: #fff; color: #333; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; cursor: pointer; font-weight: 600; transition: all 0.3s; margin-bottom: 1.5rem;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Registrarse con Google
        </a>

        <div style="text-align: center;">
            <p style="margin-bottom: 1rem;">¿Ya tienes cuenta?</p>
            <a href="{{ route('login') }}" style="color: #000; text-decoration: none; font-weight: 600;">Inicia sesión aquí</a>
        </div>
    </div>
</div>

@endsection
