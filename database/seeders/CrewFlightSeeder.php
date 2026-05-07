<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrewFlightSeeder extends Seeder
{
    public function run(): void
    {
        $user = \App\Models\User::where('email', 'dev.mohamedadell@gmail.com')->first();
        $flight = DB::table('flights')->first();
        $crew = DB::table('crews')->first();

        if ($user && $flight && $crew) {
            $existingCount = DB::table('crews_flights')
                ->where('flight_id', $flight->id)
                ->where('crew_id', $crew->id)
                ->count();

            if ($existingCount == 0) {
                DB::table('crews_flights')->insert([
                    'flight_id' => $flight->id,
                    'crew_id' => $crew->id,
                    'training_start_at' => now(),
                    'training_end_at' => now(),
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}