<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function makeProduct(array $overrides = []): Product
    {
        $category = Category::firstOrCreate(
            ['slug' => 'flores'],
            ['name' => 'Flores', 'description' => 'Categoría de flores', 'is_active' => true]
        );

        $brand = Brand::firstOrCreate(
            ['slug' => 'cookies'],
            ['name' => 'Cookies', 'description' => 'Marca premium', 'is_active' => true]
        );

        return Product::create(array_merge([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'Flor Gelato 3.5g',
            'slug' => 'flor-gelato-35g',
            'price' => 35.00,
            'discount_percentage' => null,
            'stock_status' => 'available',
            'sku' => 'SKU-TEST-001',
            'is_active' => true,
            'rating' => 4.5,
            'reviews_count' => 3,
        ], $overrides));
    }

    public function test_catalog_index_loads(): void
    {
        $this->makeProduct();

        $response = $this->get(route('catalog.index'));

        $response->assertOk();
        $response->assertSee('Flor Gelato 3.5g');
    }

    public function test_catalog_filters_by_category(): void
    {
        $this->makeProduct();

        $other = Category::create(['name' => 'Aceites', 'slug' => 'aceites', 'is_active' => true]);
        Product::create([
            'category_id' => $other->id,
            'name' => 'Aceite CBD',
            'slug' => 'aceite-cbd',
            'price' => 50,
            'stock_status' => 'available',
            'sku' => 'SKU-TEST-002',
            'is_active' => true,
        ]);

        $response = $this->get(route('catalog.index', ['category' => 'flores']));

        $response->assertOk();
        $response->assertSee('Flor Gelato 3.5g');
        $response->assertDontSee('Aceite CBD');
    }

    public function test_catalog_filters_on_sale_products(): void
    {
        $this->makeProduct(['discount_percentage' => 20]);
        $this->makeProduct(['name' => 'Sin Descuento', 'slug' => 'sin-descuento', 'sku' => 'SKU-TEST-003']);

        $response = $this->get(route('catalog.index', ['on_sale' => 1]));

        $response->assertOk();
        $response->assertSee('Flor Gelato 3.5g');
        $response->assertDontSee('Sin Descuento');
    }

    public function test_catalog_sorts_by_rating(): void
    {
        $this->makeProduct(['rating' => 3.0]);
        $this->makeProduct(['name' => 'Mejor Calificado', 'slug' => 'mejor-calificado', 'sku' => 'SKU-TEST-004', 'rating' => 5.0]);

        $response = $this->get(route('catalog.index', ['sort' => 'rating']));

        $response->assertOk();
        $products = $response->viewData('products');

        $this->assertEquals('Mejor Calificado', $products->first()->name);
    }

    public function test_product_show_page_loads_with_reviews_section(): void
    {
        $product = $this->makeProduct();

        $response = $this->get(route('product.show', $product->slug));

        $response->assertOk();
        $response->assertSee('Reseñas de Clientes');
    }

    public function test_quick_search_endpoint_returns_matching_products(): void
    {
        $this->makeProduct();

        $response = $this->getJson(route('search', ['q' => 'Gelato']));

        $response->assertOk();
        $response->assertJsonFragment(['name' => 'Flor Gelato 3.5g']);
    }
}
