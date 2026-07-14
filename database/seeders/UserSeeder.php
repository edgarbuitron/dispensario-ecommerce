<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Cliente Test',
            'email' => 'cliente@test.com',
            'phone' => '5551234567',
            'password' => bcrypt('password123'),
            'age_verified' => true,
            'age_verified_at' => now(),
            'is_active' => true,
        ]);

        // Crear 10 usuarios más para pruebas
        User::factory(10)->create();
    }
}
