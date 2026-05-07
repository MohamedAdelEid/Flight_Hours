<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrewSeeder extends Seeder
{
    public function run(): void
    {
        $user = \App\Models\User::where('email', 'dev.mohamedadell@gmail.com')->first();
        $pilotJob = \App\Models\Job::where('job_name', 'قائد طيار')->first();
        $firstOfficerJob = \App\Models\Job::where('job_name', 'طيار أول')->first();

        if ($user && $pilotJob) {
            $existingFinancials = DB::table('crews')->pluck('financial_number')->toArray();

            if (!in_array('12345', $existingFinancials)) {
                DB::table('crews')->insert([
                    'financial_number' => '12345',
                    'first_name' => 'أحمد',
                    'last_name' => 'محمد',
                    'nickname' => 'أحمدو',
                    'date_of_birth' => '1985-03-15',
                    'license_number' => 'LIC-12345',
                    'job_id' => $pilotJob->id,
                    'job_type' => $pilotJob->id,
                    'status' => 'active',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            if (!in_array('12346', $existingFinancials) && $firstOfficerJob) {
                DB::table('crews')->insert([
                    'financial_number' => '12346',
                    'first_name' => 'خالد',
                    'last_name' => 'علي',
                    'nickname' => 'خالدو',
                    'date_of_birth' => '1988-07-22',
                    'license_number' => 'LIC-12346',
                    'job_id' => $firstOfficerJob->id,
                    'job_type' => $firstOfficerJob->id,
                    'status' => 'active',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            if (!in_array('12347', $existingFinancials)) {
                DB::table('crews')->insert([
                    'financial_number' => '12347',
                    'first_name' => 'سعود',
                    'last_name' => 'سليمان',
                    'nickname' => 'سعود',
                    'date_of_birth' => '1990-01-10',
                    'license_number' => 'LIC-12347',
                    'job_id' => $pilotJob->id,
                    'job_type' => $pilotJob->id,
                    'status' => 'active',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            if (!in_array('12348', $existingFinancials) && $firstOfficerJob) {
                DB::table('crews')->insert([
                    'financial_number' => '12348',
                    'first_name' => 'عمر',
                    'last_name' => 'عيسي',
                    'nickname' => 'عمر',
                    'date_of_birth' => '1992-05-25',
                    'license_number' => 'LIC-12348',
                    'job_id' => $firstOfficerJob->id,
                    'job_type' => $firstOfficerJob->id,
                    'status' => 'active',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            if (!in_array('12349', $existingFinancials)) {
                DB::table('crews')->insert([
                    'financial_number' => '12349',
                    'first_name' => 'مصطفي',
                    'last_name' => '��حمد',
                    'nickname' => 'مصطفي',
                    'date_of_birth' => '1987-11-30',
                    'license_number' => 'LIC-12349',
                    'job_id' => $pilotJob->id,
                    'job_type' => $pilotJob->id,
                    'status' => 'inactive',
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}