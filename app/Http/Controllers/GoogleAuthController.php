<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirigir a Google para autenticación
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['email', 'profile'])
            ->redirect();
    }

    /**
     * Manejar callback de Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Buscar usuario existente
            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                // Actualizar datos si existen
                $user->update([
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);
            } else {
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'age_verified' => false, // Debe verificar edad
                    'is_active' => true,
                ]);
            }

            // Iniciar sesión como cliente (guard 'web')
            Auth::guard('web')->login($user, true);

            return redirect()->route('home')
                ->with('success', 'Bienvenido a Dispensario Premium');

        } catch (Exception $e) {
            \Log::error('Google Auth Error: ' . $e->getMessage());
            
            return redirect()->route('login')
                ->with('error', 'No pudimos completar el login con Google. Intenta nuevamente.');
        }
    }

    /**
     * Desconectar usuario de Google
     */
    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect()->route('home')
            ->with('success', 'Sesión cerrada correctamente');
    }
}
