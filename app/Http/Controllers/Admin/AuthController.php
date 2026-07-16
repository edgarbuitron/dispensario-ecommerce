<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
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

        $admin = AdminUser::where('username', $validated['username'])->first();

        if (!$admin || !$admin->is_active || !Auth::guard('admin')->validate($validated)) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Las credenciales no son válidas');
        }

        if ($admin->hasTwoFactorEnabled()) {
            $request->session()->put('admin_2fa_user_id', $admin->id);
            $request->session()->put('admin_2fa_remember', (bool) $request->get('remember'));

            return redirect()->route('admin.two-factor.show');
        }

        Auth::guard('admin')->login($admin, (bool) $request->get('remember'));
        $request->session()->regenerate();
        $admin->updateLastLogin($request->ip());

        return redirect()->route('admin.dashboard')
            ->with('success', 'Bienvenido al panel administrativo');
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
