<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Cubre las páginas del cliente que antes tiraban 500 por falta de vista
 * (pago, seguimiento, factura, perfil) y el bug del BOM que corrompía
 * la descarga de la factura en PDF.
 */
class OrderPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function makeOrderWithItem(User $user): Order
    {
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Flor Gelato',
            'slug' => 'flor-gelato',
            'price' => 58,
            'stock_status' => 'available', 'stock_quantity' => 20,
            'sku' => 'SKU-ORD-001',
            'is_active' => true,
        ]);

        $address = $user->addresses()->create([
            'label' => 'Casa',
            'recipient_name' => $user->name,
            'phone' => '5551234567',
            'street_address' => 'Calle Falsa 123',
            'state' => 'CDMX',
            'city' => 'CDMX',
            'postal_code' => '01000',
            'country' => 'México',
            'is_default' => true,
            'is_active' => true,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'order_number' => 'ORD-TEST-0001',
            'status' => 'pending_payment',
            'payment_method' => 'bank_transfer',
            'subtotal' => 58,
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'total' => 58,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'quantity' => 1,
            'unit_price' => 58,
            'subtotal' => 58,
        ]);

        $order->tracking()->create([
            'status' => 'pending_payment',
            'message' => 'Pedido realizado.',
        ]);

        return $order;
    }

    public function test_payment_page_shows_correct_total_and_upload_link(): void
    {
        $user = User::factory()->create();
        $order = $this->makeOrderWithItem($user);

        $response = $this->actingAs($user)->get(route('order.payment', $order));

        $response->assertOk();
        $response->assertSee('$58.00');
        $response->assertSee(route('order.upload-proof.form', $order), false);
    }

    public function test_tracking_page_shows_status_history(): void
    {
        $user = User::factory()->create();
        $order = $this->makeOrderWithItem($user);

        $response = $this->actingAs($user)->get(route('order.tracking', $order));

        $response->assertOk();
        $response->assertSee('Pendiente de pago');
    }

    public function test_invoice_downloads_as_a_valid_uncorrupted_pdf(): void
    {
        $user = User::factory()->create();
        $order = $this->makeOrderWithItem($user);

        $response = $this->actingAs($user)->get(route('order.invoice', $order));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');

        // El bug del BOM prependía bytes antes de "%PDF-", corrompiendo el archivo.
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    public function test_order_show_page_displays_correct_item_price_and_shipping(): void
    {
        $user = User::factory()->create();
        $order = $this->makeOrderWithItem($user);

        $response = $this->actingAs($user)->get(route('order.show', $order));

        $response->assertOk();
        $response->assertSee('$58.00');
    }

    public function test_profile_edit_addresses_and_history_pages_load(): void
    {
        $user = User::factory()->create();
        $this->makeOrderWithItem($user);

        $this->actingAs($user)->get(route('profile.edit'))->assertOk();
        $this->actingAs($user)->get(route('profile.addresses'))->assertOk();
        $this->actingAs($user)->get(route('profile.addresses.create'))->assertOk();
        $this->actingAs($user)->get(route('profile.history'))->assertOk()->assertSee('ORD-TEST-0001');
    }

    public function test_user_can_update_profile_and_add_an_address(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('profile.update'), [
            'name' => 'Nombre Actualizado',
            'email' => $user->email,
            'phone' => '5559998888',
        ])->assertRedirect(route('profile.index'));

        $this->assertEquals('Nombre Actualizado', $user->fresh()->name);

        $this->actingAs($user)->post(route('profile.addresses.store'), [
            'recipient_name' => 'Cesar',
            'phone' => '5551234567',
            'street_address' => 'Av. Siempre Viva 742',
            'state' => 'CDMX',
            'city' => 'CDMX',
            'postal_code' => '01000',
        ])->assertRedirect(route('profile.addresses'));

        $this->assertDatabaseHas('addresses', ['user_id' => $user->id, 'street_address' => 'Av. Siempre Viva 742']);
    }
}
