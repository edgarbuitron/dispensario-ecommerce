<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    protected array $names = [
        'Carlos Mendoza', 'Ana Torres', 'Luis Ramírez', 'María Fernández', 'Jorge Castillo',
        'Sofía Herrera', 'Diego Morales', 'Valentina Rojas', 'Fernando Silva', 'Camila Vargas',
        'Ricardo Peña', 'Daniela Ortiz', 'Andrés Guzmán', 'Paula Navarro', 'Miguel Ángel Ruiz',
    ];

    protected array $positiveComments = [
        'Excelente calidad, superó mis expectativas. Definitivamente volveré a comprar.',
        'Muy buen producto, llegó a tiempo y en perfectas condiciones.',
        'La mejor compra que he hecho en el dispensario, altamente recomendado.',
        'Sabor y efecto tal como se describe. Muy satisfecho con la compra.',
        'Empaque discreto y producto de primera calidad.',
        'Justo lo que buscaba, la relación precio-calidad es excelente.',
    ];

    protected array $neutralComments = [
        'Buen producto en general, aunque esperaba un poco más por el precio.',
        'Cumple con lo esperado, nada extraordinario pero tampoco decepciona.',
        'Está bien, aunque el envío tardó más de lo previsto.',
    ];

    public function run(): void
    {
        Product::all()->each(function (Product $product) {
            $reviewCount = 2 + ($product->id % 5); // entre 2 y 6 reseñas
            $ratings = [];

            for ($i = 0; $i < $reviewCount; $i++) {
                $rating = $this->pickRating($product->id, $i);
                $ratings[] = $rating;

                $comment = $rating >= 4
                    ? $this->positiveComments[($product->id + $i) % count($this->positiveComments)]
                    : $this->neutralComments[($product->id + $i) % count($this->neutralComments)];

                ProductReview::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'customer_name' => $this->names[($product->id * 3 + $i) % count($this->names)],
                    ],
                    [
                        'rating' => $rating,
                        'comment' => $comment,
                        'created_at' => now()->subDays(($product->id + $i) % 60),
                    ]
                );
            }

            $product->update([
                'rating' => round(array_sum($ratings) / count($ratings), 2),
                'reviews_count' => count($ratings),
            ]);
        });
    }

    protected function pickRating(int $productId, int $index): int
    {
        $value = ($productId * 7 + $index * 5) % 10;

        return match (true) {
            $value < 1 => 3,
            $value < 4 => 4,
            default => 5,
        };
    }
}
