<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Stiiizy', 'slug' => 'stiiizy'],
            ['name' => 'Cookies', 'slug' => 'cookies'],
            ['name' => 'Raw Garden', 'slug' => 'raw-garden'],
            ['name' => 'Heavy Hitters', 'slug' => 'heavy-hitters'],
            ['name' => 'Plug Play', 'slug' => 'plug-play'],
            ['name' => 'West Coast', 'slug' => 'west-coast'],
            ['name' => 'Sunset', 'slug' => 'sunset'],
            ['name' => 'Premium Select', 'slug' => 'premium-select'],
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => $brand['slug'],
                'description' => 'Marca premium: ' . $brand['name'],
                'is_active' => true,
            ]);
        }
    }
}
