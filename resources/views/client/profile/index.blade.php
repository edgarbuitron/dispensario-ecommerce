@extends('layouts.client')

@section('title', 'Mi Perfil - Dispensario Premium')

@section('content')

<div class="container" style="margin: 2rem auto; display: grid; grid-template-columns: 250px 1fr; gap: 2rem;">
    
    <!-- Sidebar -->
    <aside style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; height: fit-content;">
        <h2 style="font-weight: 700; margin-bottom: 1.5rem;">Mi Cuenta</h2>
        
        <nav style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('profile.index') }}" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; {{ request()->routeIs('profile.index') ? 'background: #000; color: #fff;' : '' }}">👤 Mi Perfil</a>
            <a href="{{ route('profile.addresses') }}" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; {{ request()->routeIs('profile.addresses*') ? 'background: #000; color: #fff;' : '' }}">📍 Direcciones</a>
            <a href="{{ route('profile.orders') }}" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; {{ request()->routeIs('profile.orders*') ? 'background: #000; color: #fff;' : '' }}">📦 Mis Órdenes</a>
            <form method="POST" action="{{ route('logout') }}" style="margin-top: auto;">
                @csrf
                <button type="submit" style="width: 100%; padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; background: #f8f9fa; color: #666; border: none; cursor: pointer; text-align: left;">🚪 Cerrar Sesión</button>
            </form>
        </nav>
    </aside>
    
    <!-- Contenido Principal -->
    <main>
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1 style="font-size: 2rem; font-weight: 700;">👤 Mi Perfil</h1>
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">✏️ Editar</a>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Nombre Completo</p>
                    <p style="font-weight: 600; font-size: 1.1rem;">{{ Auth::user()->name }}</p>
                </div>
                
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Email</p>
                    <p style="font-weight: 600; font-size: 1.1rem;">{{ Auth::user()->email }}</p>
                </div>
                
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Teléfono</p>
                    <p style="font-weight: 600; font-size: 1.1rem;">{{ Auth::user()->phone ?? 'No registrado' }}</p>
                </div>
                
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Miembro desde</p>
                    <p style="font-weight: 600; font-size: 1.1rem;">{{ Auth::user()->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            
            <hr style="border: none; border-top: 1px solid #e9ecef; margin: 2rem 0;">
            
            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px;">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Estado de Verificación</h3>
                
                <div style="display: flex; align-items: center; gap: 1rem;">
                    @if(Auth::user()->email_verified_at)
                        <span style="display: inline-block; background: #d4edda; color: #155724; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">✓ Email Verificado</span>
                    @else
                        <span style="display: inline-block; background: #f8d7da; color: #721c24; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">✕ Email Sin Verificar</span>
                    @endif
                    
                    @if(Auth::user()->age_verified)
                        <span style="display: inline-block; background: #d4edda; color: #155724; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">✓ Mayoría de Edad Verificada</span>
                    @else
                        <span style="display: inline-block; background: #fff3cd; color: #856404; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">⚠️ Verificar Mayoría de Edad</span>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Estadísticas -->
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; margin-top: 2rem;">
            <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; text-align: center;">
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Órdenes Totales</p>
                <p style="font-size: 2rem; font-weight: 700;">{{ Auth::user()->orders->count() }}</p>
            </div>
            
            <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; text-align: center;">
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Gasto Total</p>
                <p style="font-size: 2rem; font-weight: 700; color: #28a745;">${{ number_format(Auth::user()->orders->sum('total'), 2) }}</p>
            </div>
            
            <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; text-align: center;">
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Direcciones Guardadas</p>
                <p style="font-size: 2rem; font-weight: 700;">{{ Auth::user()->addresses->count() }}</p>
            </div>
        </div>
    </main>
</div>

@endsection
