<?php

namespace Tests\Feature;

use App\Mail\AbandonedCartMail;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AbandonedCartReminderTest extends TestCase
{
    use RefreshDatabase;

    protected function makeAbandonedCart(User $user, int $hoursAgo = 5): Cart
    {
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id, 'name' => 'Flor Gelato', 'slug' => 'flor-gelato',
            'price' => 58, 'stock_status' => 'available', 'stock_quantity' => 20,
            'sku' => 'SKU-CART-001', 'is_active' => true,
        ]);

        $cart = Cart::create(['user_id' => $user->id]);
        $cart->items()->create(['product_id' => $product->id, 'quantity' => 2, 'price' => 58, 'subtotal' => 116]);
        $cart->recalculate();
        Cart::where('id', $cart->id)->update(['updated_at' => now()->subHours($hoursAgo)]);

        return $cart->fresh();
    }

    public function test_sends_reminder_for_cart_abandoned_more_than_default_hours(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $cart = $this->makeAbandonedCart($user, 5);

        $this->artisan('app:remind-abandoned-carts')->assertSuccessful();

        Mail::assertSent(AbandonedCartMail::class, fn ($mail) => $mail->cart->id === $cart->id);
        $this->assertNotNull($cart->fresh()->reminder_sent_at);
    }

    public function test_does_not_remind_recently_updated_carts(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->makeAbandonedCart($user, 1); // solo 1 hora, por debajo del umbral de 3

        $this->artisan('app:remind-abandoned-carts')->assertSuccessful();

        Mail::assertNothingSent();
    }

    public function test_does_not_remind_the_same_cart_twice(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->makeAbandonedCart($user, 5);

        $this->artisan('app:remind-abandoned-carts');
        $this->artisan('app:remind-abandoned-carts');

        Mail::assertSent(AbandonedCartMail::class, 1);
    }

    public function test_adding_a_new_item_resets_the_reminder_flag(): void
    {
        $user = User::factory()->create();
        $cart = $this->makeAbandonedCart($user, 5);
        $cart->update(['reminder_sent_at' => now()]);

        $cart->recalculate();

        $this->assertNull($cart->fresh()->reminder_sent_at);
    }
}
