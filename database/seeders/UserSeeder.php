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
                'dni' => '9876543',
                'name' => 'Left4code',
                'email' => 'midone@left4code.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'gender' => 'm',
                'active' => 1,
                'remember_token' => Str::random(10),
                'role_id' => 1,
                'delegation_code' => 'DE00001115',
                'territorial' => 'II',
            ],
            /* [ 
                'name' => 'Carlota flores',
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
                'name' => 'Juan Hernandez',
                'email' => 'jhernandez@thevaluescorner.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'gender' => 'm',
                'active' => 1,
                'delegation_code' => 'DE00001104',
                'remember_token' => Str::random(10),
                'role_id' => 5
            ],
            [ 
                'name' => 'Rafael Moreno',
                'email' => 'rmoreno@thevaluescorner.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'gender' => 'm',
                'active' => 1,
                'delegation_code' => 'DE00001104',
                'remember_token' => Str::random(10),
                'role_id' => 2
            ],
            [ 
                'name' => 'Ana Picazo',
                'email' => 'apicazo@thevaluescorner.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'gender' => 'f',
                'active' => 1,
                'delegation_code' => 'DE00001113',
                'remember_token' => Str::random(10),
                'role_id' => 4
            ], */            
        ]);

        // Fake users
        User::factory()->times(9)->create();
    }
}
