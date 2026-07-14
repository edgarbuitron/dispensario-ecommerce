<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::create([
            'username' => 'admin',
            'email' => 'admin@dispensario.com',
            'name' => 'Administrador Principal',
            'password' => bcrypt('admin123456'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        AdminUser::create([
            'username' => 'manager',
            'email' => 'manager@dispensario.com',
            'name' => 'Gerente de Tienda',
            'password' => bcrypt('manager123456'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        AdminUser::create([
            'username' => 'operador',
            'email' => 'operador@dispensario.com',
            'name' => 'Operador',
            'password' => bcrypt('operador123456'),
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}
