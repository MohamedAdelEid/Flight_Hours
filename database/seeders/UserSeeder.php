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
            'name' => 'Mohamed Adel',
            'email' => 'dev.mohamedadell@gmail.com',
            'password' => Hash::make('Admin@123'),  // It's a good practice to hash passwords
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Ahlam Taboli',
            'email' => 'ahlam@gmail.com',
            'password' => Hash::make('12345678'),  // It's a good practice to hash passwords
            'role' => 'captain'
        ]);
        User::create([
            'name' => 'Mohamed Adel',
            'email' => 'captain@gmail.com',
            'password' => Hash::make('Captian@123'),  // It's a good practice to hash passwords
            'role' => 'captain'
        ]);
        User::create([
            'name' => 'Mohamed Adel',
            'email' => 'employee@gmail.com',
            'password' => Hash::make('employee@123'),  // It's a good practice to hash passwords
            'role' => 'employee'
        ]);
    }
}
