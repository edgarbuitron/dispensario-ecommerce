<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Catálogo de productos por categoría (slug de categoría => datos).
     * Cada categoría trae entre 10 y 30 productos (12 aquí) coherentes con su tipo.
     */
    protected function catalog(): array
    {
        return [
            'vapes' => [
                'type' => 'Vape',
                'brands' => ['stiiizy', 'plug-play', 'heavy-hitters'],
                'items' => [
                    ['Stiiizy Pod Blue Dream', '0.5g Pod', 28.00, 'Blue Dream'],
                    ['Stiiizy Pod OG Kush', '0.5g Pod', 28.00, 'OG Kush'],
                    ['Stiiizy Pod Gelato', '1g Pod', 45.00, 'Gelato'],
                    ['Stiiizy Battery Kit', 'Kit Completo', 25.00, null],
                    ['Stiiizy Pod Mango', '0.5g Pod', 28.00, 'Mango'],
                    ['Stiiizy Pod Watermelon', '0.5g Pod', 28.00, 'Watermelon'],
                    ['Plug Play Pod Sour Diesel', '0.5g Pod', 35.00, 'Sour Diesel'],
                    ['Plug Play Pod Wedding Cake', '0.5g Pod', 35.00, 'Wedding Cake'],
                    ['Plug Play Pod Runtz', '1g Pod', 50.00, 'Runtz'],
                    ['Heavy Hitters Vape Pen Girl Scout Cookies', '1g Pen', 55.00, 'Girl Scout Cookies'],
                    ['Heavy Hitters Vape Pen Pineapple Express', '1g Pen', 55.00, 'Pineapple Express'],
                    ['Heavy Hitters Disposable Grape Ape', '0.3g Desechable', 22.00, 'Grape Ape'],
                ],
            ],
            'cartuchos' => [
                'type' => 'Cartucho',
                'brands' => ['raw-garden', 'heavy-hitters', 'plug-play'],
                'items' => [
                    ['Cartucho Raw Garden Sour Apple', '1g', 60.00, 'Sour Apple'],
                    ['Cartucho Raw Garden Live Resin OG Kush', '0.5g', 42.00, 'OG Kush'],
                    ['Cartucho Raw Garden Live Resin Gelato', '1g', 60.00, 'Gelato'],
                    ['Cartucho Raw Garden Runtz', '1g', 62.00, 'Runtz'],
                    ['Cartucho Raw Garden Blue Dream', '1g', 58.00, 'Blue Dream'],
                    ['Cartucho Raw Garden Pineapple Express', '1g', 58.00, 'Pineapple Express'],
                    ['Cartucho Heavy Hitters Jack Herer', '1g', 65.00, 'Jack Herer'],
                    ['Cartucho Heavy Hitters Girl Scout Cookies', '1g', 65.00, 'Girl Scout Cookies'],
                    ['Cartucho Heavy Hitters Grape Ape', '0.5g', 45.00, 'Grape Ape'],
                    ['Cartucho Plug Play Wedding Cake', '1g', 68.00, 'Wedding Cake'],
                    ['Cartucho Plug Play Zkittlez', '1g', 68.00, 'Zkittlez'],
                    ['Cartucho Plug Play Mimosa', '0.5g', 48.00, 'Mimosa'],
                ],
            ],
            'flores' => [
                'type' => 'Flor',
                'brands' => ['cookies'],
                'items' => [
                    ['Flor Cookies Gelato 3.5g', '3.5g', 35.00, 'Gelato'],
                    ['Flor Cookies Gelato 7g', '7g', 62.00, 'Gelato'],
                    ['Flor Cookies Gelato 14g', '14g', 115.00, 'Gelato'],
                    ['Flor Cookies Gelato 28g', '28g (1oz)', 210.00, 'Gelato'],
                    ['Flor Cookies OG Kush 3.5g', '3.5g', 32.00, 'OG Kush'],
                    ['Flor Cookies OG Kush 7g', '7g', 58.00, 'OG Kush'],
                    ['Flor Cookies OG Kush 14g', '14g', 105.00, 'OG Kush'],
                    ['Flor Cookies OG Kush 28g', '28g (1oz)', 195.00, 'OG Kush'],
                    ['Flor Cookies Wedding Cake 3.5g', '3.5g', 38.00, 'Wedding Cake'],
                    ['Flor Cookies Wedding Cake 7g', '7g', 68.00, 'Wedding Cake'],
                    ['Flor Cookies Wedding Cake 14g', '14g', 125.00, 'Wedding Cake'],
                    ['Flor Cookies Wedding Cake 28g', '28g (1oz)', 230.00, 'Wedding Cake'],
                ],
            ],
            'aceites' => [
                'type' => 'Aceite',
                'brands' => ['premium-select'],
                'items' => [
                    ['Aceite de CBD 500mg', '15ml', 40.00, null],
                    ['Aceite de CBD 1000mg', '30ml', 65.00, null],
                    ['Aceite de CBD 1500mg', '30ml', 85.00, null],
                    ['Aceite de CBD 2000mg', '60ml', 120.00, null],
                    ['Aceite de CBD Sabor Menta 1000mg', '30ml', 68.00, 'Menta'],
                    ['Aceite de CBD Sabor Limón 1000mg', '30ml', 68.00, 'Limón'],
                    ['Aceite Full Spectrum 750mg', '30ml', 72.00, null],
                    ['Aceite Broad Spectrum 1000mg', '30ml', 78.00, null],
                    ['Aceite de THC 500mg', '15ml', 55.00, null],
                    ['Aceite de CBD para Mascotas 250mg', '15ml', 35.00, null],
                    ['Aceite de CBD Nocturno 1000mg', '30ml', 70.00, null],
                    ['Aceite de CBD Relax 1500mg', '30ml', 90.00, null],
                ],
            ],
            'gominolas' => [
                'type' => 'Gominola',
                'brands' => ['sunset'],
                'items' => [
                    ['Gominolas THC Fresa 10pc', '10 piezas', 20.00, 'Fresa'],
                    ['Gominolas THC Uva 10pc', '10 piezas', 20.00, 'Uva'],
                    ['Gominolas THC Mango 10pc', '10 piezas', 20.00, 'Mango'],
                    ['Gominolas THC Sandía 10pc', '10 piezas', 20.00, 'Sandía'],
                    ['Gominolas CBD Mixtas 20pc', '20 piezas', 32.00, 'Mixto'],
                    ['Gominolas THC Cereza 10pc', '10 piezas', 20.00, 'Cereza'],
                    ['Gominolas Sour Mix 10pc', '10 piezas', 22.00, 'Ácido Mixto'],
                    ['Gominolas THC Piña 10pc', '10 piezas', 20.00, 'Piña'],
                    ['Gominolas Nocturnas CBN 10pc', '10 piezas', 25.00, null],
                    ['Gominolas Energéticas THC 10pc', '10 piezas', 24.00, null],
                    ['Gominolas Relax CBD 20pc', '20 piezas', 34.00, null],
                    ['Gominolas Tropical Mix 10pc', '10 piezas', 21.00, 'Tropical'],
                ],
            ],
            'comestibles' => [
                'type' => 'Comestible',
                'brands' => ['west-coast'],
                'items' => [
                    ['Brownies Comestible 100mg', '100mg', 15.00, null],
                    ['Galletas Chispas de Chocolate THC 100mg', '100mg', 16.00, null],
                    ['Chocolate Barra THC 200mg', '200mg', 18.00, null],
                    ['Chocolate Barra CBD 200mg', '200mg', 18.00, null],
                    ['Caramelos Duros THC 50mg', '50mg', 12.00, null],
                    ['Palomitas THC 100mg', '100mg', 14.00, null],
                    ['Miel THC 100mg', '100mg', 20.00, null],
                    ['Mantequilla de Maní THC 150mg', '150mg', 17.00, null],
                    ['Té THC Relajante', '10 sobres', 15.00, null],
                    ['Café THC Energizante', '10 cápsulas', 19.00, null],
                    ['Pastel Individual THC 100mg', '100mg', 13.00, null],
                    ['Barra de Granola THC 100mg', '100mg', 14.00, null],
                ],
            ],
            'cbd' => [
                'type' => 'CBD',
                'brands' => ['premium-select'],
                'items' => [
                    ['Cápsulas CBD 300mg', '30 cápsulas', 38.00, null],
                    ['Cápsulas CBD 600mg', '30 cápsulas', 62.00, null],
                    ['Crema CBD Muscular 250mg', '100ml', 30.00, null],
                    ['Bálsamo CBD 100mg', '50ml', 22.00, null],
                    ['Tintura CBD 1000mg', '30ml', 75.00, null],
                    ['Spray CBD Sublingual 500mg', '20ml', 45.00, null],
                    ['CBD para Mascotas Cápsulas', '30 cápsulas', 28.00, null],
                    ['Parche CBD Transdérmico', '4 parches', 25.00, null],
                    ['CBD Aislado Puro 1g', '1g', 55.00, null],
                    ['Té CBD Relajante', '10 sobres', 16.00, null],
                    ['Gomitas CBD Sueño 20pc', '20 piezas', 33.00, null],
                    ['Loción CBD Corporal 200ml', '200ml', 27.00, null],
                ],
            ],
            'accesorios' => [
                'type' => 'Accesorio',
                'brands' => [],
                'items' => [
                    ['Frasco Vidrio 50ml', 'Unitario', 8.00, null],
                    ['Grinder Metálico 4 Piezas', 'Unitario', 18.00, null],
                    ['Bandeja de Enrollar', 'Unitario', 12.00, null],
                    ['Papel de Liar King Size', '32 hojas', 4.00, null],
                    ['Encendedor Premium', 'Unitario', 6.00, null],
                    ['Pipa de Vidrio', 'Unitario', 25.00, null],
                    ['Bong Mini de Vidrio', 'Unitario', 45.00, null],
                    ['Boquillas Filtro x50', '50 unidades', 5.00, null],
                    ['Estuche Hermético', 'Unitario', 15.00, null],
                    ['Báscula Digital de Precisión', 'Unitario', 20.00, null],
                    ['Kit de Limpieza para Pipas', 'Kit Completo', 14.00, null],
                    ['Contenedor UV Protector', 'Unitario', 22.00, null],
                ],
            ],
        ];
    }

    public function run(): void
    {
        foreach ($this->catalog() as $categorySlug => $data) {
            $category = Category::where('slug', $categorySlug)->first();

            if (!$category) {
                continue;
            }

            $brands = collect($data['brands'])
                ->map(fn ($slug) => Brand::where('slug', $slug)->first())
                ->filter();

            foreach ($data['items'] as $index => [$name, $presentation, $price, $flavor]) {
                $brand = $brands->isNotEmpty() ? $brands[$index % $brands->count()] : null;

                // Distribución de stock para poder probar el filtro de disponibilidad.
                // La cantidad es la fuente de verdad: el estado se deriva de ella al guardar.
                $stockQuantity = match (true) {
                    $index % 9 === 0 => 0,
                    $index % 5 === 0 => 2 + ($index % 4),
                    default => 15 + (($index * 7) % 40),
                };
                $stockStatus = match (true) {
                    $stockQuantity <= 0 => 'out_of_stock',
                    $stockQuantity <= 5 => 'low',
                    default => 'available',
                };

                // Uno de cada tres productos trae descuento, con porcentajes variados.
                $discountPercentage = match ($index % 3) {
                    0 => [10.00, 15.00, 20.00, 25.00, 30.00][$index % 5],
                    default => null,
                };

                // Calificación pseudoaleatoria pero determinística (para poder ordenar por estrellas).
                $rating = round(3.0 + (($index * 37) % 21) / 10, 2); // entre 3.0 y 5.0
                $reviewsCount = 5 + (($index * 13) % 80);

                Product::updateOrCreate(
                    ['slug' => Str::slug($name)],
                    [
                        'category_id' => $category->id,
                        'brand_id' => $brand?->id,
                        'name' => $name,
                        'price' => $price,
                        'discount_percentage' => $discountPercentage,
                        'cost_price' => round($price * 0.4, 2),
                        'rating' => $rating,
                        'reviews_count' => $reviewsCount,
                        'description' => "Producto premium de la categoría {$category->name}: {$name}.",
                        'short_description' => "Excelente {$data['type']}" . ($flavor ? " sabor {$flavor}" : ''),
                        'type' => $data['type'],
                        'flavor' => $flavor,
                        'presentation' => $presentation,
                        'stock_status' => $stockStatus,
                        'stock_quantity' => $stockQuantity,
                        'sku' => 'SKU-' . strtoupper($categorySlug) . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                        'is_featured' => $index < 2,
                        'is_new' => $index >= count($data['items']) - 3,
                        'featured_until' => $index < 2 ? now()->addMonths(2) : null,
                        'new_until' => $index >= count($data['items']) - 3 ? now()->addDays(30) : null,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
