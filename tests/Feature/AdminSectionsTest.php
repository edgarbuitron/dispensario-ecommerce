<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Cubre las secciones del admin que antes tiraban 500 por falta de vistas
 * (marcas, banners, configuración) o por usar campos inexistentes
 * (categorías, cupones). Evita que vuelvan a romperse silenciosamente.
 */
class AdminSectionsTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsAdmin(): AdminUser
    {
        $admin = AdminUser::create([
            'username' => 'admin',
            'email' => 'admin@test.com',
            'name' => 'Admin',
            'password' => 'secret123',
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $this->actingAs($admin, 'admin');

        return $admin;
    }

    public static function adminPagesProvider(): array
    {
        return [
            'dashboard' => ['admin.dashboard'],
            'products index' => ['admin.products.index'],
            'products create' => ['admin.products.create'],
            'categories index' => ['admin.categories.index'],
            'categories create' => ['admin.categories.create'],
            'brands index' => ['admin.brands.index'],
            'brands create' => ['admin.brands.create'],
            'coupons index' => ['admin.coupons.index'],
            'coupons create' => ['admin.coupons.create'],
            'banners index' => ['admin.banners.index'],
            'banners create' => ['admin.banners.create'],
            'settings index' => ['admin.settings.index'],
            'settings bank accounts' => ['admin.settings.bank-accounts'],
            'orders index' => ['admin.orders.index'],
            'proofs index' => ['admin.proofs.index'],
        ];
    }

    /** @dataProvider adminPagesProvider */
    public function test_admin_page_loads_successfully(string $routeName): void
    {
        $this->actingAsAdmin();

        $this->get(route($routeName))->assertOk();
    }

    public function test_guest_cannot_access_any_admin_section(): void
    {
        $this->get(route('admin.brands.index'))->assertRedirect(route('admin.login'));
    }
}
