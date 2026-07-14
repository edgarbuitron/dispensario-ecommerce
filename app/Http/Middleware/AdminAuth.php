<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si está autenticado en la sesión de admin
        if (!auth('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Verificar que el admin está activo
        if (!auth('admin')->user()->is_active) {
            auth('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'Tu cuenta ha sido desactivada');
        }

        return $next($request);
    }
}
