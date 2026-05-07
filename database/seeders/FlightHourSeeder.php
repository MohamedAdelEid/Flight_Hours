<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlightHourSeeder extends Seeder
{
    public function run(): void
    {
        $flights = DB::table('flights')->get();

        if ($flights->count() > 0) {
            foreach ($flights as $flight) {
                $existingHours = DB::table('flight_hours')
                    ->where('flight_id', $flight->id)
                    ->count();

                if ($existingHours == 0) {
                    DB::table('flight_hours')->insert([
                        'aircraft_id' => $flight->aircraft_id,
                        'flight_id' => $flight->id,
                        'hours' => 1.50,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
}