<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    public function run(): void
    {
        BankAccount::create([
            'bank_name' => 'BBVA México',
            'account_holder' => 'Dispensario Premium SA de CV',
            'account_number' => '0117623000100000000',
            'clabe' => '012180011762300010',
            'swift_code' => 'BBVAMXMM',
            'instructions' => 'Transferencia a nombre del titular. Incluya el número de orden en la referencia.',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        BankAccount::create([
            'bank_name' => 'Banamex',
            'account_holder' => 'Dispensario Premium SA de CV',
            'account_number' => '0002112345678901234',
            'clabe' => '002180000211234567',
            'swift_code' => 'BANAMXMM',
            'instructions' => 'Transferencia interbancaria disponible las 24 horas.',
            'is_active' => true,
            'sort_order' => 2,
        ]);
    }
}
