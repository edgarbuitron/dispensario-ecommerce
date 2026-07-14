<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Vapes', 'slug' => 'vapes'],
            ['name' => 'Cartuchos', 'slug' => 'cartuchos'],
            ['name' => 'Flores', 'slug' => 'flores'],
            ['name' => 'Aceites', 'slug' => 'aceites'],
            ['name' => 'Gominolas', 'slug' => 'gominolas'],
            ['name' => 'Comestibles', 'slug' => 'comestibles'],
            ['name' => 'CBD', 'slug' => 'cbd'],
            ['name' => 'Accesorios', 'slug' => 'accesorios'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => 'Categoría de ' . $category['name'],
                'is_active' => true,
            ]);
        }
    }
}
