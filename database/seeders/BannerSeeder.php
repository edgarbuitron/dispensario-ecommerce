<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        Banner::create([
            'title' => 'Bienvenido a Dispensario Premium',
            'subtitle' => 'Los mejores productos con envío rápido',
            'image' => 'banner-1.jpg',
            'position' => 'hero',
            'start_date' => now(),
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Banner::create([
            'title' => 'Descuento en Compras Mayores',
            'subtitle' => 'Compra más, ahorra más',
            'image' => 'banner-2.jpg',
            'link' => '/products',
            'position' => 'secondary',
            'start_date' => now(),
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Banner::create([
            'title' => 'Envío Gratis en Pedidos Mayores a $500',
            'subtitle' => 'Disfruta de nuestro servicio de entrega sin costo',
            'image' => 'banner-3.jpg',
            'position' => 'bottom',
            'start_date' => now(),
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
