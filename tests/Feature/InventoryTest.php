<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    protected function makeProduct(int $quantity): Product
    {
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Flor Gelato',
            'slug' => 'flor-gelato',
            'price' => 58,
            'stock_status' => 'available',
            'stock_quantity' => $quantity,
            'sku' => 'SKU-INV-001',
            'is_active' => true,
        ]);
    }

    public function test_stock_status_is_derived_from_quantity(): void
    {
        $product = $this->makeProduct(20);
        $this->assertEquals('available', $product->stock_status);

        $product->update(['stock_quantity' => 3]);
        $this->assertEquals('low', $product->fresh()->stock_status);

        $product->update(['stock_quantity' => 0]);
        $this->assertEquals('out_of_stock', $product->fresh()->stock_status);
    }

    public function test_manually_hidden_product_ignores_quantity_changes(): void
    {
        $product = $this->makeProduct(20);
        $product->update(['stock_status' => 'hidden']);

        $product->update(['stock_quantity' => 15]);

        $this->assertEquals('hidden', $product->fresh()->stock_status);
    }

    public function test_cannot_add_more_to_cart_than_available_stock(): void
    {
        $user = User::factory()->create();
        $product = $this->makeProduct(3);

        $response = $this->actingAs($user)->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(0, $user->cart?->items()->count() ?? 0);
    }

    public function test_completing_checkout_decrements_stock(): void
    {
        $user = User::factory()->create();
        $product = $this->makeProduct(10);

        $user->addresses()->create([
            'label' => 'Casa', 'recipient_name' => $user->name, 'phone' => '5551234567',
            'street_address' => 'Calle Falsa 123', 'state' => 'CDMX', 'city' => 'CDMX',
            'postal_code' => '01000', 'country' => 'México', 'is_default' => true, 'is_active' => true,
        ]);

        $this->actingAs($user);
        $this->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 3]);
        $this->post(route('checkout.process'), [
            'address_id' => $user->addresses()->first()->id,
            'payment_method' => 'bank_transfer',
            'shipping' => 0,
        ]);

        $this->assertEquals(7, $product->fresh()->stock_quantity);
    }

    public function test_cancelling_an_order_restores_stock(): void
    {
        $admin = AdminUser::create([
            'username' => 'admin', 'email' => 'admin@test.com', 'name' => 'Admin',
            'password' => 'secret123', 'role' => 'super_admin', 'is_active' => true,
        ]);

        $user = User::factory()->create();
        $product = $this->makeProduct(10);

        $user->addresses()->create([
            'label' => 'Casa', 'recipient_name' => $user->name, 'phone' => '5551234567',
            'street_address' => 'Calle Falsa 123', 'state' => 'CDMX', 'city' => 'CDMX',
            'postal_code' => '01000', 'country' => 'México', 'is_default' => true, 'is_active' => true,
        ]);

        $this->actingAs($user);
        $this->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 3]);
        $this->post(route('checkout.process'), [
            'address_id' => $user->addresses()->first()->id,
            'payment_method' => 'bank_transfer',
            'shipping' => 0,
        ]);

        $this->assertEquals(7, $product->fresh()->stock_quantity);

        $order = \App\Models\Order::first();

        $this->actingAs($admin, 'admin')->post(route('admin.orders.updateStatus', $order), [
            'status' => 'cancelled',
        ]);

        $this->assertEquals(10, $product->fresh()->stock_quantity);
    }
}
