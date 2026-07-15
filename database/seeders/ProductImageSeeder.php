<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductImageSeeder extends Seeder
{
    /**
     * Paleta de colores para generar imágenes de muestra (SVG) por producto,
     * ya que aún no hay fotografías reales cargadas desde el admin.
     */
    protected array $palette = [
        '#2f6f4f', '#8a5a2f', '#5a7d9a', '#a34b4b', '#6b4b8a', '#3f8a7d', '#a37e2f', '#4b6b8a',
    ];

    public function run(): void
    {
        $directory = storage_path('app/public/products');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        Product::all()->each(function (Product $product) use ($directory) {
            $imageCount = 3 + ($product->id % 3); // entre 3 y 5 imágenes

            for ($i = 0; $i < $imageCount; $i++) {
                $filename = $product->slug . '-' . ($i + 1) . '.svg';
                $color = $this->palette[($product->id + $i) % count($this->palette)];
                $label = $product->type ? $product->type . ' ' . ($i + 1) : $product->name;

                File::put($directory . DIRECTORY_SEPARATOR . $filename, $this->buildSvg($color, $label));

                ProductImage::updateOrCreate(
                    ['product_id' => $product->id, 'image_path' => $filename],
                    [
                        'alt_text' => $product->name . ' - imagen ' . ($i + 1),
                        'is_primary' => $i === 0,
                        'sort_order' => $i,
                    ]
                );
            }
        });
    }

    protected function buildSvg(string $color, string $label): string
    {
        $safeLabel = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="600" height="600" viewBox="0 0 600 600">
    <rect width="600" height="600" fill="{$color}"/>
    <text x="300" y="300" font-family="Arial, sans-serif" font-size="32" fill="#ffffff" text-anchor="middle" dominant-baseline="middle">{$safeLabel}</text>
</svg>
SVG;
    }
}
