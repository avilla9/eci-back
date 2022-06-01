<?php

namespace Database\Seeders;

use App\Models\Delegation;
use Illuminate\Database\Seeder;

class DelegationSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Delegation::insert([
            [
                'name' => 'Alicante',
                'code' => 'DE00001115',
            ],
            [
                'name' => 'Alcalá de Hres',
                'code' => 'DE00001104',
            ],
            [
                'name' => 'Colón',
                'code' => 'DE00001113',
            ]
        ]);
    }
}
