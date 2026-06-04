<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'dev.mohamedadell@gmail.com')->first();

        if (! $user) {
            return;
        }

        $pilotingType = JobType::where('job_type', 'piloting')->first();
        $cabinType = JobType::where('job_type', 'cabin')->first();

        $jobs = [
            [
                'job_name' => 'قائد طيار',
                'type_id' => $pilotingType?->id,
            ],
            [
                'job_name' => 'طيار أول',
                'type_id' => $pilotingType?->id,
            ],
            [
                'job_name' => 'مضيف جوي',
                'type_id' => $cabinType?->id,
            ],
            [
                'job_name' => 'مضيف أول',
                'type_id' => $cabinType?->id,
            ],
        ];

        foreach ($jobs as $job) {
            if (! $job['type_id']) {
                continue;
            }

            Job::updateOrCreate(
                ['job_name' => $job['job_name']],
                [
                    'type_id' => $job['type_id'],
                    'status'  => 'active',
                    'user_id' => $user->id,
                ]
            );
        }
    }
}