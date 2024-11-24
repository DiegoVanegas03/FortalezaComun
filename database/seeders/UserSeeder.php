<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Diego Emiliano',
            'last_name' => 'Vanegas Cerda',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'rol' => 'admin',
            'puesto' => 'RH',
        ]);
        User::factory(10)->create();
    }
}
