<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si está autenticado como cliente
        if (!auth('web')->check()) {
            return redirect()->route('login')
                ->with('message', 'Por favor inicia sesión para continuar');
        }

        // Verificar que el cliente está activo
        if (!auth('web')->user()->is_active) {
            auth('web')->logout();
            return redirect()->route('login')
                ->with('error', 'Tu cuenta ha sido desactivada');
        }

        return $next($request);
    }
}
