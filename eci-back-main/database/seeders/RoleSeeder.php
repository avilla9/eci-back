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
        'name' => 'Super Usuario',
        'description' => 'Administrador del sito web',
        'level' => 1,
      ],
      [
        'name' => 'Agente Veterano',
        'description' => 'Usuario de rango Agente veterano',
        'level' => 11,
      ],
      [
        'name' => 'Delegado',
        'description' => 'Usuario de rango Delegado',
        'level' => 12,
      ],
      [
        'name' => 'Agente',
        'description' => 'Usuario de rango Agente',
        'level' => 13,
      ],
      [
        'name' => 'Agente En Formación',
        'description' => 'Usuario de rando En formación',
        'level' => 14,
      ],
    ]);
  }
}
