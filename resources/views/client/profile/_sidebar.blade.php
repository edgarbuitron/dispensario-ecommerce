<aside style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 1.5rem; height: fit-content;">
    <h2 style="font-weight: 700; margin-bottom: 1.5rem;">Mi Cuenta</h2>

    <nav style="display: flex; flex-direction: column; gap: 0.75rem;">
        <a href="{{ route('profile.index') }}" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; {{ request()->routeIs('profile.index') ? 'background: #000; color: #fff;' : '' }}">👤 Mi Perfil</a>
        <a href="{{ route('profile.addresses') }}" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; {{ request()->routeIs('profile.addresses*') ? 'background: #000; color: #fff;' : '' }}">📍 Direcciones</a>
        <a href="{{ route('profile.orders') }}" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; {{ request()->routeIs('profile.orders*') ? 'background: #000; color: #fff;' : '' }}">📦 Mis Órdenes</a>
        <a href="{{ route('profile.history') }}" style="padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; color: #666; {{ request()->routeIs('profile.history') ? 'background: #000; color: #fff;' : '' }}">🕓 Historial</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top: auto;">
            @csrf
            <button type="submit" style="width: 100%; padding: 0.75rem 1rem; border-radius: 4px; text-decoration: none; background: #f8f9fa; color: #666; border: none; cursor: pointer; text-align: left;">🚪 Cerrar Sesión</button>
        </form>
    </nav>
</aside>
