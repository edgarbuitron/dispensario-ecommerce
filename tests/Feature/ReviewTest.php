<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
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
            'stock_status' => 'available', 'stock_quantity' => 20,
            'sku' => 'SKU-REV-001',
            'is_active' => true,
            'rating' => 0,
            'reviews_count' => 0,
        ]);
    }

    public function test_authenticated_user_can_submit_a_review(): void
    {
        $user = User::factory()->create();
        $product = $this->makeProduct();

        $response = $this->actingAs($user)->post(route('reviews.store', $product), [
            'rating' => 5,
            'comment' => 'Excelente producto, muy recomendado.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('product_reviews', [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
        ]);

        $product->refresh();
        $this->assertEquals(5, $product->rating);
        $this->assertEquals(1, $product->reviews_count);
    }

    public function test_resubmitting_a_review_updates_it_instead_of_duplicating(): void
    {
        $user = User::factory()->create();
        $product = $this->makeProduct();

        $this->actingAs($user)->post(route('reviews.store', $product), [
            'rating' => 3,
            'comment' => 'Primera reseña',
        ]);

        $this->actingAs($user)->post(route('reviews.store', $product), [
            'rating' => 5,
            'comment' => 'Reseña actualizada',
        ]);

        $this->assertEquals(1, \App\Models\ProductReview::where('product_id', $product->id)->count());
        $product->refresh();
        $this->assertEquals(5, $product->rating);
    }

    public function test_guest_cannot_submit_a_review(): void
    {
        $product = $this->makeProduct();

        $this->post(route('reviews.store', $product), [
            'rating' => 5,
            'comment' => 'Intento sin sesión',
        ])->assertRedirect(route('login'));
    }
}
