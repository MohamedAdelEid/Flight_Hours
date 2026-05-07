<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlightSeeder extends Seeder
{
    public function run(): void
    {
        $user = \App\Models\User::where('email', 'dev.mohamedadell@gmail.com')->first();
        $aircraft = \App\Models\Aircraft::first();
        $origin = \App\Models\Airport::where('airport_code', 'DMM')->first();
        $destination = \App\Models\Airport::where('airport_code', 'RUH')->first();

        if ($user && $aircraft && $origin && $destination) {
            $existingFlights = DB::table('flights')->pluck('flight_number')->toArray();

            if (!in_array('FL001', $existingFlights)) {
                DB::table('flights')->insert([
                    'flight_number' => 'FL001',
                    'flight_date' => '2025-01-15',
                    'aircraft_id' => $aircraft->id,
                    'aircraft_number' => $aircraft->id,
                    'origin_airport_id' => $origin->id,
                    'destination_airport_id' => $destination->id,
                    'departure_time' => '2025-01-15 08:00:00',
                    'arrival_time' => '2025-01-15 09:30:00',
                    'flight_type' => 'normal_flight',
                    'status' => 'completed',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            if (!in_array('FL002', $existingFlights)) {
                DB::table('flights')->insert([
                    'flight_number' => 'FL002',
                    'flight_date' => '2025-01-15',
                    'aircraft_id' => $aircraft->id,
                    'aircraft_number' => $aircraft->id,
                    'origin_airport_id' => $destination->id,
                    'destination_airport_id' => $origin->id,
                    'departure_time' => '2025-01-15 10:00:00',
                    'arrival_time' => '2025-01-15 11:30:00',
                    'flight_type' => 'normal_flight',
                    'status' => 'completed',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            if (!in_array('FL003', $existingFlights)) {
                DB::table('flights')->insert([
                    'flight_number' => 'FL003',
                    'flight_date' => '2025-02-20',
                    'aircraft_id' => $aircraft->id,
                    'aircraft_number' => $aircraft->id,
                    'origin_airport_id' => $origin->id,
                    'destination_airport_id' => $destination->id,
                    'departure_time' => '2025-02-20 14:00:00',
                    'arrival_time' => '2025-02-20 15:30:00',
                    'flight_type' => 'normal_flight',
                    'status' => 'completed',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            if (!in_array('FL004', $existingFlights)) {
                DB::table('flights')->insert([
                    'flight_number' => 'FL004',
                    'flight_date' => '2025-03-10',
                    'aircraft_id' => $aircraft->id,
                    'aircraft_number' => $aircraft->id,
                    'origin_airport_id' => $destination->id,
                    'destination_airport_id' => $origin->id,
                    'departure_time' => '2025-03-10 16:00:00',
                    'arrival_time' => '2025-03-10 17:30:00',
                    'flight_type' => 'normal_flight',
                    'status' => 'pending',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            if (!in_array('FL005', $existingFlights)) {
                DB::table('flights')->insert([
                    'flight_number' => 'FL005',
                    'flight_date' => '2025-04-05',
                    'aircraft_id' => $aircraft->id,
                    'aircraft_number' => $aircraft->id,
                    'origin_airport_id' => $origin->id,
                    'destination_airport_id' => $destination->id,
                    'departure_time' => '2025-04-05 18:00:00',
                    'arrival_time' => '2025-04-05 19:30:00',
                    'flight_type' => 'normal_flight',
                    'status' => 'pending',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}