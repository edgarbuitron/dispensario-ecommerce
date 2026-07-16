<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TotpService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TwoFactorSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function show(Request $request, TotpService $totp): View
    {
        $admin = auth('admin')->user();

        if ($admin->hasTwoFactorEnabled()) {
            return view('admin.security.index', ['admin' => $admin, 'enabled' => true]);
        }

        $secret = $request->session()->get('pending_2fa_secret');

        if (!$secret) {
            $secret = $totp->generateSecret();
            $request->session()->put('pending_2fa_secret', $secret);
        }

        $qrUrl = $totp->getOtpAuthUrl($secret, $admin->email);

        return view('admin.security.index', [
            'admin' => $admin,
            'enabled' => false,
            'secret' => $secret,
            'qrUrl' => $qrUrl,
        ]);
    }

    public function enable(Request $request, TotpService $totp)
    {
        $request->validate(['code' => 'required|string']);

        $secret = $request->session()->get('pending_2fa_secret');
        abort_unless($secret, 400, 'No hay una configuración de 2FA pendiente.');

        if (!$totp->verify($secret, $request->code)) {
            return back()->with('error', 'Código incorrecto. Verifica la hora de tu dispositivo e intenta de nuevo.');
        }

        auth('admin')->user()->update([
            'two_factor_secret' => $secret,
            'two_factor_confirmed_at' => now(),
        ]);

        $request->session()->forget('pending_2fa_secret');

        \App\Models\AuditLog::log('enable_2fa', auth('admin')->user());

        return redirect()->route('admin.security.index')->with('success', '✅ Verificación en dos pasos activada correctamente');
    }

    public function disable(Request $request)
    {
        $request->validate(['password' => 'required|string']);

        $admin = auth('admin')->user();

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Contraseña incorrecta');
        }

        $admin->update(['two_factor_secret' => null, 'two_factor_confirmed_at' => null]);

        \App\Models\AuditLog::log('disable_2fa', $admin);

        return redirect()->route('admin.security.index')->with('success', 'Verificación en dos pasos desactivada');
    }
}
