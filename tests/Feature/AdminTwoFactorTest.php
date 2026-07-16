<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Services\TotpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTwoFactorTest extends TestCase
{
    use RefreshDatabase;

    protected function makeAdmin(): AdminUser
    {
        return AdminUser::create([
            'username' => 'cesar',
            'email' => 'cesar@test.com',
            'name' => 'Cesar',
            'password' => 'secret123',
            'role' => 'super_admin',
            'is_active' => true,
        ]);
    }

    public function test_admin_without_2fa_logs_in_directly(): void
    {
        $this->makeAdmin();

        $response = $this->post(route('admin.login.submit'), [
            'username' => 'cesar',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated('admin');
    }

    public function test_admin_can_enable_two_factor_with_a_valid_code(): void
    {
        $admin = $this->makeAdmin();
        $totp = new TotpService();

        $this->actingAs($admin, 'admin');

        // Visitar la página genera y guarda un secreto pendiente en sesión.
        $this->get(route('admin.security.index'));
        $secret = session('pending_2fa_secret');
        $this->assertNotNull($secret);

        $code = $totp->generateCode($secret, intdiv(time(), 30));

        $response = $this->post(route('admin.security.enable'), ['code' => $code]);

        $response->assertRedirect(route('admin.security.index'));
        $this->assertTrue($admin->fresh()->hasTwoFactorEnabled());
    }

    public function test_login_requires_two_factor_code_once_enabled(): void
    {
        $admin = $this->makeAdmin();
        $totp = new TotpService();
        $secret = $totp->generateSecret();
        $admin->update(['two_factor_secret' => $secret, 'two_factor_confirmed_at' => now()]);

        // Paso 1: usuario y contraseña correctos, pero no debe quedar autenticado todavía.
        $response = $this->post(route('admin.login.submit'), [
            'username' => 'cesar',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.two-factor.show'));
        $this->assertGuest('admin');

        // Paso 2: código TOTP incorrecto no completa el login.
        $this->post(route('admin.two-factor.verify'), ['code' => '000000'])
            ->assertSessionHas('error');
        $this->assertGuest('admin');

        // Paso 2 (correcto): completa el login.
        $code = $totp->generateCode($secret, intdiv(time(), 30));
        $this->post(route('admin.two-factor.verify'), ['code' => $code])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated('admin');
    }

    public function test_admin_can_disable_two_factor_with_correct_password(): void
    {
        $admin = $this->makeAdmin();
        $totp = new TotpService();
        $secret = $totp->generateSecret();
        $admin->update(['two_factor_secret' => $secret, 'two_factor_confirmed_at' => now()]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.security.disable'), ['password' => 'secret123'])
            ->assertRedirect(route('admin.security.index'));

        $this->assertFalse($admin->fresh()->hasTwoFactorEnabled());
    }

    public function test_cannot_disable_two_factor_with_wrong_password(): void
    {
        $admin = $this->makeAdmin();
        $totp = new TotpService();
        $secret = $totp->generateSecret();
        $admin->update(['two_factor_secret' => $secret, 'two_factor_confirmed_at' => now()]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.security.disable'), ['password' => 'wrong-password'])
            ->assertSessionHas('error');

        $this->assertTrue($admin->fresh()->hasTwoFactorEnabled());
    }
}
