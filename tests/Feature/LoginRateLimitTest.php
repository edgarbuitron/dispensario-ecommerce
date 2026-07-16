<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginRateLimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_login_is_rate_limited_after_5_failed_attempts(): void
    {
        User::factory()->create(['email' => 'cliente@test.com']);

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login'), ['email' => 'cliente@test.com', 'password' => 'wrong'])
                ->assertStatus(302);
        }

        $this->post(route('login'), ['email' => 'cliente@test.com', 'password' => 'wrong'])
            ->assertStatus(429);
    }

    public function test_admin_login_is_rate_limited_after_5_failed_attempts(): void
    {
        AdminUser::create([
            'username' => 'admin', 'email' => 'admin@test.com', 'name' => 'Admin',
            'password' => 'secret123', 'role' => 'super_admin', 'is_active' => true,
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('admin.login.submit'), ['username' => 'admin', 'password' => 'wrong'])
                ->assertStatus(302);
        }

        $this->post(route('admin.login.submit'), ['username' => 'admin', 'password' => 'wrong'])
            ->assertStatus(429);
    }
}
