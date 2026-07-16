<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Services\TotpService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class TwoFactorChallengeController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('admin_2fa_user_id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.auth.two-factor-challenge');
    }

    public function verify(Request $request, TotpService $totp): RedirectResponse
    {
        $adminId = $request->session()->get('admin_2fa_user_id');

        if (!$adminId) {
            return redirect()->route('admin.login');
        }

        $request->validate(['code' => 'required|string']);

        $admin = AdminUser::findOrFail($adminId);

        if (!$totp->verify($admin->two_factor_secret, $request->code)) {
            return back()->with('error', 'Código incorrecto. Intenta de nuevo.');
        }

        $remember = $request->session()->pull('admin_2fa_remember', false);
        $request->session()->forget('admin_2fa_user_id');

        Auth::guard('admin')->login($admin, $remember);
        $request->session()->regenerate();
        $admin->updateLastLogin($request->ip());

        return redirect()->route('admin.dashboard')
            ->with('success', 'Bienvenido al panel administrativo');
    }
}
