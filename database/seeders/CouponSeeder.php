<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::create([
            'code' => 'BIENVENIDA10',
            'description' => 'Cupón de bienvenida: 10% de descuento',
            'type' => 'percentage',
            'discount_value' => 10,
            'minimum_purchase' => 100,
            'max_uses' => 500,
            'max_per_customer' => 1,
            'valid_from' => now(),
            'valid_until' => now()->addYear(),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'DESCUENTO50',
            'description' => 'Descuento fijo de $50',
            'type' => 'fixed',
            'discount_value' => 50,
            'minimum_purchase' => 300,
            'max_uses' => 100,
            'max_per_customer' => 2,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(6),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'VIP20',
            'description' => 'Cupón VIP: 20% de descuento',
            'type' => 'percentage',
            'discount_value' => 20,
            'minimum_purchase' => 500,
            'max_uses' => 50,
            'max_per_customer' => 5,
            'valid_from' => now(),
            'valid_until' => now()->addYear(),
            'is_active' => true,
        ]);
    }
}
