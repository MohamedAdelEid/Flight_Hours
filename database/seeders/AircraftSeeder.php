<?php

namespace Database\Seeders;

use App\Models\Aircraft;
use Illuminate\Database\Seeder;

class AircraftSeeder extends Seeder
{
    public function run(): void
    {
        $user = \App\Models\User::where('email', 'dev.mohamedadell@gmail.com')->first();

        if ($user) {
            if (! Aircraft::where('aircraft_code', 'B738')->exists()) {
                Aircraft::create([
                    'aircraft_name' => 'Boeing 737-800',
                    'aircraft_code' => 'B738',
                    'manufacturer' => 'Boeing',
                    'status' => 'active',
                    'registration_number' => 'N738AB',
                    'user_id' => $user->id,
                ]);
            }
            if (! Aircraft::where('aircraft_code', 'A320')->exists()) {
                Aircraft::create([
                    'aircraft_name' => 'Airbus A320',
                    'aircraft_code' => 'A320',
                    'manufacturer' => 'Airbus',
                    'status' => 'active',
                    'registration_number' => 'N320AB',
                    'user_id' => $user->id,
                ]);
            }
            if (! Aircraft::where('aircraft_code', 'B77W')->exists()) {
                Aircraft::create([
                    'aircraft_name' => 'Boeing 777-300ER',
                    'aircraft_code' => 'B77W',
                    'manufacturer' => 'Boeing',
                    'status' => 'active',
                    'registration_number' => 'N777AB',
                    'user_id' => $user->id,
                ]);
            }
            if (! Aircraft::where('aircraft_code', 'A21N')->exists()) {
                Aircraft::create([
                    'aircraft_name' => 'Airbus A321neo',
                    'aircraft_code' => 'A21N',
                    'manufacturer' => 'Airbus',
                    'status' => 'active',
                    'registration_number' => 'N321AB',
                    'user_id' => $user->id,
                ]);
            }
            if (! Aircraft::where('aircraft_code', 'B789')->exists()) {
                Aircraft::create([
                    'aircraft_name' => 'Boeing 787-9',
                    'aircraft_code' => 'B789',
                    'manufacturer' => 'Boeing',
                    'status' => 'maintenance',
                    'registration_number' => 'N789AB',
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
