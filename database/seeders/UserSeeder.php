<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Mohamed Adel',
            'email' => 'dev.mohamedadell@gmail.com',
            'password' => Hash::make('Admin@123'), // It's a good practice to hash passwords
            'role' => 'admin'
        ]);
        // User::create([
        //     'name' => 'Ahlam Taboli',
        //     'email' => 'ahlam@gmail.com',
        //     'password' => Hash::make('12345678'), // It's a good practice to hash passwords
        //     'role' => 'captain'
        // ]);

    }   
}
