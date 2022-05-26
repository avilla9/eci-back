<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;

class RoleSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    // Default credentials
    Role::insert([
      [
        'name' => 'Administrador',
        'description' => 'Administrador del sito web',
        'level' => 1,
      ],
      [
        'name' => 'Operador',
        'description' => 'Operador del sito web',
        'level' => 1,
      ],
      [
        'name' => 'Delegado',
        'description' => 'Usuario de rango Delegado',
        'level' => 2,
      ],
      [
        'name' => 'Agente',
        'description' => 'Usuario de rango Agente',
        'level' => 3,
      ],
      [
        'name' => 'En formación',
        'description' => 'Usuario de rando En formación',
        'level' => 4,
      ],
    ]);
  }
}
