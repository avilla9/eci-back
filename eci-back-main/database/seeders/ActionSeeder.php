<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Action::insert([
            [
                'name' => 'like',
                'description' => 'Interacción que indica que a un usuario le ha gustado un post'
            ],
            [
                'name' => 'view',
                'description' => 'Interacción que indica que un usuario ha visto un post'
            ],
            [
                'name' => 'share',
                'description' => 'Interacción que indica que un usuario ha compartido un post'
            ],
            [
                'name' => 'click',
                'description' => 'Interacción que indica que un usuario ha hecho click'
            ]
        ]);
    }
}
