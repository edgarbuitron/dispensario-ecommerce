<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Stiiizy Starter Kit',
                'price' => 45.00,
                'type' => 'Vape',
                'presentation' => 'Kit Completo',
                'category' => 'Vapes',
                'brand' => 'Stiiizy',
            ],
            [
                'name' => 'Cartucho Raw Garden 1g',
                'price' => 60.00,
                'type' => 'Cartucho',
                'presentation' => '1g',
                'category' => 'Cartuchos',
                'brand' => 'Raw Garden',
            ],
            [
                'name' => 'Flor Cookies 28g',
                'price' => 280.00,
                'type' => 'Flor',
                'presentation' => '28g (1oz)',
                'category' => 'Flores',
                'brand' => 'Cookies',
            ],
            [
                'name' => 'Aceite de CBD 1000mg',
                'price' => 65.00,
                'type' => 'Aceite',
                'presentation' => '30ml',
                'category' => 'Aceites',
                'brand' => 'Premium Select',
            ],
            [
                'name' => 'Gominolas THC 10pc',
                'price' => 20.00,
                'type' => 'Gominola',
                'presentation' => '10 piezas',
                'category' => 'Gominolas',
                'brand' => 'Sunset',
            ],
            [
                'name' => 'Brownies Comestible 100mg',
                'price' => 15.00,
                'type' => 'Comestible',
                'presentation' => '100mg',
                'category' => 'Comestibles',
                'brand' => 'West Coast',
            ],
            [
                'name' => 'Frasco Vidrio 50ml',
                'price' => 8.00,
                'type' => 'Accesorio',
                'presentation' => 'Unitario',
                'category' => 'Accesorios',
                'brand' => null,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category'])->first();
            $brand = $productData['brand'] ? Brand::where('name', $productData['brand'])->first() : null;

            Product::create([
                'category_id' => $category->id,
                'brand_id' => $brand?->id,
                'name' => $productData['name'],
                'slug' => str()->slug($productData['name']),
                'price' => $productData['price'],
                'cost_price' => $productData['price'] * 0.4,
                'description' => 'Producto premium de ' . $productData['name'],
                'short_description' => 'Excelente ' . $productData['type'],
                'type' => $productData['type'],
                'presentation' => $productData['presentation'],
                'stock_status' => 'available',
                'sku' => 'SKU-' . uniqid(),
                'is_featured' => rand(0, 1),
                'is_new' => true,
                'is_active' => true,
            ]);
        }
    }
}
