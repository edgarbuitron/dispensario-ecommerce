<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected function makeAdmin(string $role): AdminUser
    {
        return AdminUser::create([
            'username' => $role,
            'email' => $role . '@test.com',
            'name' => ucfirst($role),
            'password' => 'secret123',
            'role' => $role,
            'is_active' => true,
        ]);
    }

    public function test_manager_cannot_delete_a_product(): void
    {
        $manager = $this->makeAdmin('manager');
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id, 'name' => 'Producto', 'slug' => 'producto',
            'price' => 10, 'stock_status' => 'available', 'stock_quantity' => 20, 'sku' => 'SKU-PERM-001', 'is_active' => true,
        ]);

        $this->actingAs($manager, 'admin');

        $this->delete(route('admin.products.destroy', $product))->assertForbidden();
        $this->assertNotSoftDeleted($product);
    }

    public function test_super_admin_can_delete_a_product_and_it_gets_audited(): void
    {
        $superAdmin = $this->makeAdmin('super_admin');
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id, 'name' => 'Producto', 'slug' => 'producto',
            'price' => 10, 'stock_status' => 'available', 'stock_quantity' => 20, 'sku' => 'SKU-PERM-002', 'is_active' => true,
        ]);

        $this->actingAs($superAdmin, 'admin');

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertSoftDeleted($product);
        $this->assertDatabaseHas('audit_logs', [
            'admin_user_id' => $superAdmin->id,
            'action' => 'delete',
            'model_type' => Product::class,
            'model_id' => $product->id,
        ]);
    }

    public function test_manager_cannot_access_settings(): void
    {
        $manager = $this->makeAdmin('manager');

        $this->actingAs($manager, 'admin')
            ->get(route('admin.settings.index'))
            ->assertForbidden();
    }

    public function test_manager_cannot_view_audit_log(): void
    {
        $manager = $this->makeAdmin('manager');

        $this->actingAs($manager, 'admin')
            ->get(route('admin.audit-logs.index'))
            ->assertForbidden();
    }

    public function test_super_admin_can_view_audit_log(): void
    {
        $superAdmin = $this->makeAdmin('super_admin');
        AuditLog::create([
            'admin_user_id' => $superAdmin->id,
            'action' => 'delete',
            'model_type' => Product::class,
            'model_id' => 1,
        ]);

        $response = $this->actingAs($superAdmin, 'admin')->get(route('admin.audit-logs.index'));

        $response->assertOk();
        $response->assertSee('delete');
    }
}
