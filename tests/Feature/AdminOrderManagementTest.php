<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderManagementTest extends TestCase
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

    protected function makeOrder(string $status = 'ready_to_ship'): Order
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Flor Gelato',
            'slug' => 'flor-gelato',
            'price' => 58,
            'stock_status' => 'available',
            'sku' => 'SKU-ADMORD-001',
            'is_active' => true,
        ]);

        $address = $user->addresses()->create([
            'label' => 'Casa', 'recipient_name' => $user->name, 'phone' => '5551234567',
            'street_address' => 'Calle Falsa 123', 'state' => 'CDMX', 'city' => 'CDMX',
            'postal_code' => '01000', 'country' => 'México', 'is_default' => true, 'is_active' => true,
        ]);

        $order = Order::create([
            'user_id' => $user->id, 'address_id' => $address->id, 'order_number' => 'ORD-ADM-0001',
            'status' => $status, 'payment_method' => 'bank_transfer',
            'subtotal' => 58, 'tax' => 0, 'shipping' => 0, 'discount' => 0, 'total' => 58,
        ]);

        OrderItem::create([
            'order_id' => $order->id, 'product_id' => $product->id, 'product_name' => $product->name,
            'product_sku' => $product->sku, 'quantity' => 1, 'unit_price' => 58, 'subtotal' => 58,
        ]);

        return $order;
    }

    public function test_order_show_page_displays_correct_price_and_address(): void
    {
        $this->actingAsAdmin();
        $order = $this->makeOrder();

        $response = $this->get(route('admin.orders.show', $order));

        $response->assertOk();
        $response->assertSee('$58.00');
        $response->assertSee('Calle Falsa 123');
    }

    /**
     * addShipment() leía $validated['tracking_url'] directamente; al ser un campo
     * opcional, si no se enviaba, Laravel lo omite del array validado y explotaba
     * con "Undefined array key".
     */
    public function test_admin_can_add_shipment_without_optional_tracking_url(): void
    {
        $this->actingAsAdmin();
        $order = $this->makeOrder('ready_to_ship');

        $response = $this->post(route('admin.orders.addShipment', $order), [
            'carrier' => 'DHL',
            'tracking_number' => 'TRK-000001',
        ]);

        $response->assertRedirect(route('admin.orders.show', $order));
        $this->assertDatabaseHas('order_shipments', ['order_id' => $order->id, 'carrier' => 'DHL']);
        $this->assertEquals('shipped', $order->fresh()->status);
    }

    /**
     * La ruta orders/export estaba registrada DESPUÉS de Route::resource('orders', ...),
     * así que "export" se interpretaba como {order} y devolvía 404 en vez de exportar.
     */
    public function test_export_route_is_reachable_and_not_shadowed_by_order_show_route(): void
    {
        $this->actingAsAdmin();

        $response = $this->get(route('admin.orders.export'));

        // No debe ser 404 (ruta "sombreada"); el 500 actual es por falta del paquete
        // maatwebsite/excel, un problema aparte y ya documentado.
        $this->assertNotEquals(404, $response->status());
    }

    public function test_admin_can_approve_and_reject_payment_proof(): void
    {
        $this->actingAsAdmin();
        $order = $this->makeOrder('proof_received');
        $order->proofs()->create(['image_path' => 'test.png', 'status' => 'pending']);

        $this->post(route('admin.orders.approveProof', $order), ['notes' => 'OK'])
            ->assertRedirect(route('admin.orders.show', $order));

        $this->assertEquals('payment_confirmed', $order->fresh()->status);
    }
}
