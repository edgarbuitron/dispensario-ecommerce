<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    protected function makeProduct(): Product
    {
        $category = Category::create(['name' => 'Flores', 'slug' => 'flores', 'is_active' => true]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Flor Gelato',
            'slug' => 'flor-gelato',
            'price' => 40,
            'stock_status' => 'available',
            'sku' => 'SKU-WISH-001',
            'is_active' => true,
        ]);
    }

    public function test_guest_cannot_toggle_wishlist(): void
    {
        $product = $this->makeProduct();

        $this->post(route('wishlist.toggle', $product))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_add_and_remove_from_wishlist(): void
    {
        $user = User::factory()->create();
        $product = $this->makeProduct();

        $this->actingAs($user)->post(route('wishlist.toggle', $product));
        $this->assertDatabaseHas('wishlists', ['user_id' => $user->id, 'product_id' => $product->id]);

        $this->actingAs($user)->post(route('wishlist.toggle', $product));
        $this->assertDatabaseMissing('wishlists', ['user_id' => $user->id, 'product_id' => $product->id]);
    }

    public function test_wishlist_index_shows_favorited_products(): void
    {
        $user = User::factory()->create();
        $product = $this->makeProduct();
        Wishlist::create(['user_id' => $user->id, 'product_id' => $product->id]);

        $response = $this->actingAs($user)->get(route('wishlist.index'));

        $response->assertOk();
        $response->assertSee('Flor Gelato');
    }
}
