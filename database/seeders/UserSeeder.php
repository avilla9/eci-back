<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default credentials
        User::insert([
            [
                'dni'  => '00001',
                'name' => 'Carlota',
                'last_name' => 'Flores',
                'email' => 'clopez@thevaluescorner.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'gender' => 'f',
                'active' => 1,
                'delegation_code' => 'DE00001115',
                'remember_token' => Str::random(10),
                'role_id' => 13
            ],
            [
                'dni' => '00000',
                'name' => 'Armando',
                'last_name' => 'Villanueva',
                'email' => 'armandojvilla9@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'gender' => 'm',
                'active' => 1,
                'delegation_code' => 'DE00001113',
                'remember_token' => Str::random(10),
                'role_id' => 13
            ],            
            [
                'dni' => '00002',
                'name' => 'Goldjack',
                'last_name' => 'Anderson',
                'email' => 'goldjackanderson@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'gender' => 'f',
                'active' => 1,
                'delegation_code' => 'DE00001113',
                'remember_token' => Str::random(10),
                'role_id' => 13
            ],            
        ]);

        // Fake users
        User::factory()->times(9)->create();
    }
}
