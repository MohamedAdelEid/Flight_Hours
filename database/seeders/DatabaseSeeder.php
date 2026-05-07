<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            JobTypeSeeder::class,
            AircraftSeeder::class,
            AirportSeeder::class,
            JobSeeder::class,
            CrewSeeder::class,
            FlightSeeder::class,
            FlightHourSeeder::class,
            OtherFlightsSeeder::class,
            CrewFlightSeeder::class,
        ]);
    }
}
