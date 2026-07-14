<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAgeGate
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si es usuario autenticado y verificó edad
        if (auth()->check() && auth()->user()->age_verified) {
            return $next($request);
        }

        // Si es usuario no autenticado pero confirmó edad en esta sesión
        if (session('age_verified')) {
            return $next($request);
        }

        // Redirigir a modal de verificación de edad
        return redirect()->route('age-gate.show');
    }
}
