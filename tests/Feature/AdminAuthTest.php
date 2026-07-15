<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_log_in_with_correct_credentials(): void
    {
        AdminUser::create([
            'username' => 'admin',
            'email' => 'admin@test.com',
            'name' => 'Admin',
            'password' => 'secret123',
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'username' => 'admin',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated('admin');
    }

    public function test_admin_login_fails_with_wrong_password(): void
    {
        AdminUser::create([
            'username' => 'admin',
            'email' => 'admin@test.com',
            'name' => 'Admin',
            'password' => 'secret123',
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'username' => 'admin',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHas('error');
        $this->assertGuest('admin');
    }

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    }
}
