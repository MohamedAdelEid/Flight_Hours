<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OtherFlightsSeeder extends Seeder
{
    public function run(): void
    {
        $aircraft = \App\Models\Aircraft::first();
        $airport = \App\Models\Airport::first();

        if ($aircraft && $airport) {
            $existingFlights = DB::table('other_flights')->pluck('flight_number')->toArray();

            if (!in_array('OT001', $existingFlights)) {
                DB::table('other_flights')->insert([
                    'aircraft_id' => $aircraft->id,
                    'airport_id' => $airport->id,
                    'flight_number' => 'OT001',
                    'flight_date' => '2025-01-10',
                    'flight_type' => 'simulated_flight',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            if (!in_array('OT002', $existingFlights)) {
                DB::table('other_flights')->insert([
                    'aircraft_id' => $aircraft->id,
                    'airport_id' => $airport->id,
                    'flight_number' => 'OT002',
                    'flight_date' => '2025-02-15',
                    'flight_type' => 'unloaded_flight',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            if (!in_array('OT003', $existingFlights)) {
                DB::table('other_flights')->insert([
                    'aircraft_id' => $aircraft->id,
                    'airport_id' => $airport->id,
                    'flight_number' => 'OT003',
                    'flight_date' => '2025-03-20',
                    'flight_type' => 'airplane_test',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}