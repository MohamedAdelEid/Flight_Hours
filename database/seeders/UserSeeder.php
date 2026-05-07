<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (! User::where('email', 'dev.mohamedadell@gmail.com')->exists()) {
            User::create([
                'name' => 'Mohamed Adel',
                'email' => 'dev.mohamedadell@gmail.com',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
            ]);
        }

        if (! User::where('email', 'ahlam@gmail.com')->exists()) {
            User::create([
                'name' => 'Ahlam Taboli',
                'email' => 'ahlam@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'captain',
            ]);
        }

        if (! User::where('email', 'captain@gmail.com')->exists()) {
            User::create([
                'name' => 'Mohamed Adel',
                'email' => 'captain@gmail.com',
                'password' => Hash::make('Captian@123'),
                'role' => 'captain',
            ]);
        }

        if (! User::where('email', 'employee@gmail.com')->exists()) {
            User::create([
                'name' => 'Mohamed Adel',
                'email' => 'employee@gmail.com',
                'password' => Hash::make('employee@123'),
                'role' => 'employee',
            ]);
        }
    }
}
