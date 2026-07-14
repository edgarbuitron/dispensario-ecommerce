<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::guard('admin')->attempt($validated, $request->get('remember'))) {
            $request->session()->regenerate();
            
            // Registrar último login
            Auth::guard('admin')->user()->updateLastLogin($request->ip());

            return redirect()->route('admin.dashboard')
                ->with('success', 'Bienvenido al panel administrativo');
        }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Las credenciales no son válidas');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Sesión cerrada correctamente');
    }
}
