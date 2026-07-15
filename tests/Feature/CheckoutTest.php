<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_checkout_flow_creates_order_tracking_and_notifications(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Flor Gelato',
            'slug' => 'flor-gelato',
            'price' => 40,
            'stock_status' => 'available',
            'sku' => 'SKU-CHK-001',
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

        $this->actingAs($user);

        $this->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 1])
            ->assertStatus(302);

        $response = $this->post(route('checkout.process'), [
            'address_id' => $address->id,
            'payment_method' => 'bank_transfer',
            'shipping' => 0,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $order = Order::first();
        $this->assertNotNull($order, 'Se esperaba que el checkout creara una orden.');
        $this->assertEquals('pending_payment', $order->status);
        $this->assertEquals(1, OrderTracking::where('order_id', $order->id)->count());
        $this->assertEquals(2, Notification::where('order_id', $order->id)->count());
        $this->assertEquals(0, $user->cart->items()->count());
    }

    /**
     * OrderController::checkout() estaba declarado con retorno ": View" pero
     * devolvía un redirect cuando el usuario no tenía direcciones guardadas,
     * lo que provocaba un TypeError 500 en vez de redirigir.
     */
    public function test_checkout_redirects_to_add_address_when_user_has_none(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Flor Gelato',
            'slug' => 'flor-gelato-2',
            'price' => 40,
            'stock_status' => 'available',
            'sku' => 'SKU-CHK-002',
            'is_active' => true,
        ]);

        $this->actingAs($user);
        $this->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 1]);

        $response = $this->get(route('checkout'));

        $response->assertRedirect(route('profile.addresses.create'));
    }
}
