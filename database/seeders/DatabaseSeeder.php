<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear categorías
        $this->call(CategorySeeder::class);
        
        // Crear marcas
        $this->call(BrandSeeder::class);
        
        // Crear productos
        $this->call(ProductSeeder::class);

        // Crear imágenes de muestra para los productos
        $this->call(ProductImageSeeder::class);

        // Crear reseñas de clientes
        $this->call(ReviewSeeder::class);

        // Crear usuarios clientes
        $this->call(UserSeeder::class);
        
        // Crear usuarios admin
        $this->call(AdminUserSeeder::class);
        
        // Crear datos bancarios
        $this->call(BankAccountSeeder::class);
        
        // Crear configuración
        $this->call(SettingSeeder::class);
        
        // Crear banners
        $this->call(BannerSeeder::class);
        
        // Crear cupones
        $this->call(CouponSeeder::class);
    }
}
