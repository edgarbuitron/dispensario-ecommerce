<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Genera un PNG real de 1x1px sin depender de la extensión GD
     * (no disponible en este entorno).
     */
    protected function fakePng(): UploadedFile
    {
        $bytes = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');

        return UploadedFile::fake()->createWithContent('foto.png', $bytes);
    }

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

    public function test_admin_can_create_a_product_with_discount_and_image(): void
    {
        Storage::fake('public');
        $this->actingAsAdmin();
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);

        $response = $this->post(route('admin.products.store'), [
            'name' => 'Producto Nuevo',
            'category_id' => $category->id,
            'price' => 50,
            'discount_percentage' => 15,
            'stock_status' => 'available', 'stock_quantity' => 20,
            'is_active' => '1',
            'images' => [$this->fakePng()],
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $product = Product::where('name', 'Producto Nuevo')->first();
        $this->assertNotNull($product);
        $this->assertEquals(15, $product->discount_percentage);
        $this->assertEquals(1, $product->images()->count());
    }

    public function test_admin_can_update_product_stock_status(): void
    {
        $this->actingAsAdmin();
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Producto Existente',
            'slug' => 'producto-existente',
            'price' => 30,
            'stock_status' => 'available', 'stock_quantity' => 20,
            'sku' => 'SKU-ADM-001',
            'is_active' => true,
        ]);

        $response = $this->put(route('admin.products.update', $product), [
            'name' => 'Producto Existente',
            'category_id' => $category->id,
            'price' => 30,
            'stock_status' => 'out_of_stock',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertEquals('out_of_stock', $product->fresh()->stock_status);
    }

    public function test_admin_can_delete_a_product(): void
    {
        $this->actingAsAdmin();
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Producto a Borrar',
            'slug' => 'producto-a-borrar',
            'price' => 30,
            'stock_status' => 'available', 'stock_quantity' => 20,
            'sku' => 'SKU-ADM-002',
            'is_active' => true,
        ]);

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertSoftDeleted($product);
    }
}
