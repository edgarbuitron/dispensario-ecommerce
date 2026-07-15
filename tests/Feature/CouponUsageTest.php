<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Los cupones nunca incrementaban "times_used", así que un cupón de
 * "un solo uso" (max_uses / max_per_customer) se podía usar sin límite.
 */
class CouponUsageTest extends TestCase
{
    use RefreshDatabase;

    protected function makeProductAndAddress(User $user): Product
    {
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Flor Gelato',
            'slug' => 'flor-gelato',
            'price' => 100,
            'stock_status' => 'available',
            'sku' => 'SKU-CPN-001',
            'is_active' => true,
        ]);

        $user->addresses()->create([
            'label' => 'Casa', 'recipient_name' => $user->name, 'phone' => '5551234567',
            'street_address' => 'Calle Falsa 123', 'state' => 'CDMX', 'city' => 'CDMX',
            'postal_code' => '01000', 'country' => 'México', 'is_default' => true, 'is_active' => true,
        ]);

        return $product;
    }

    protected function checkout(User $user): void
    {
        $address = $user->addresses()->first();

        $this->post(route('checkout.process'), [
            'address_id' => $address->id,
            'payment_method' => 'bank_transfer',
            'shipping' => 0,
        ]);
    }

    public function test_completing_an_order_increments_coupon_times_used(): void
    {
        $user = User::factory()->create();
        $product = $this->makeProductAndAddress($user);
        $coupon = Coupon::create([
            'code' => 'DESC10', 'type' => 'percentage', 'discount_value' => 10,
            'max_per_customer' => 5, 'valid_from' => now()->subDay(), 'is_active' => true,
        ]);

        $this->actingAs($user);
        $this->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 1]);
        $this->post(route('cart.coupon'), ['coupon_code' => 'DESC10']);
        $this->checkout($user);

        $this->assertEquals(1, $coupon->fresh()->times_used);
    }

    public function test_coupon_cannot_be_applied_once_max_uses_is_reached(): void
    {
        $coupon = Coupon::create([
            'code' => 'UNICO', 'type' => 'fixed', 'discount_value' => 10,
            'max_uses' => 1, 'times_used' => 1, 'max_per_customer' => 5,
            'valid_from' => now()->subDay(), 'is_active' => true,
        ]);

        $user = User::factory()->create();
        $product = $this->makeProductAndAddress($user);

        $this->actingAs($user);
        $this->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 1]);

        $response = $this->post(route('cart.coupon'), ['coupon_code' => 'UNICO']);

        $response->assertSessionHas('error');

        $cart = app(CartService::class)->getCart();
        $this->assertNull($cart->coupon_code);
    }

    public function test_coupon_cannot_be_applied_again_once_customer_reaches_max_per_customer(): void
    {
        $user = User::factory()->create();
        $product = $this->makeProductAndAddress($user);
        $coupon = Coupon::create([
            'code' => 'SOLOUNAVEZ', 'type' => 'fixed', 'discount_value' => 10,
            'max_per_customer' => 1, 'valid_from' => now()->subDay(), 'is_active' => true,
        ]);

        // Simula que este cliente ya usó el cupón en una orden anterior.
        Order::create([
            'user_id' => $user->id,
            'address_id' => $user->addresses()->first()->id,
            'order_number' => 'ORD-PREVIA',
            'status' => 'delivered',
            'payment_method' => 'bank_transfer',
            'subtotal' => 100, 'tax' => 0, 'shipping' => 0, 'discount' => 10, 'total' => 90,
            'coupon_code' => 'SOLOUNAVEZ',
        ]);

        $this->actingAs($user);
        $this->post(route('cart.add'), ['product_id' => $product->id, 'quantity' => 1]);

        $response = $this->post(route('cart.coupon'), ['coupon_code' => 'SOLOUNAVEZ']);

        $response->assertSessionHas('error');
    }
}
