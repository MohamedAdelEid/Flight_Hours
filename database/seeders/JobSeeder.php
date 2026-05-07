<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $user = \App\Models\User::where('email', 'dev.mohamedadell@gmail.com')->first();
        $pilotingType = \App\Models\JobType::where('job_type', 'piloting')->first();
        $engineeringType = \App\Models\JobType::where('job_type', 'engineering')->first();
        $cabinType = \App\Models\JobType::where('job_type', 'cabin')->first();

        if ($user) {
            if ($pilotingType && ! Job::where('job_name', 'قائد طيار')->exists()) {
                Job::create([
                    'job_name' => 'قائد طيار',
                    'type_id' => $pilotingType->id,
                    'status' => 'active',
                    'user_id' => $user->id,
                ]);
            }
            if ($pilotingType && ! Job::where('job_name', 'طيار أول')->exists()) {
                Job::create([
                    'job_name' => 'طيار أول',
                    'type_id' => $pilotingType->id,
                    'status' => 'active',
                    'user_id' => $user->id,
                ]);
            }
            if ($engineeringType && ! Job::where('job_name', 'مهندس طيران')->exists()) {
                Job::create([
                    'job_name' => 'مهندس طيران',
                    'type_id' => $engineeringType->id,
                    'status' => 'active',
                    'user_id' => $user->id,
                ]);
            }
            if ($cabinType && ! Job::where('job_name', 'مضيف جوي')->exists()) {
                Job::create([
                    'job_name' => 'مضيف جوي',
                    'type_id' => $cabinType->id,
                    'status' => 'active',
                    'user_id' => $user->id,
                ]);
            }
            if ($cabinType && ! Job::where('job_name', 'مضيف أول')->exists()) {
                Job::create([
                    'job_name' => 'مضيف أول',
                    'type_id' => $cabinType->id,
                    'status' => 'active',
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
