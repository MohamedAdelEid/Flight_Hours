<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTypeSeeder extends Seeder
{
    public function run(): void
    {
        $jobTypes = [
            'piloting',
            'cabin',
        ];

        foreach ($jobTypes as $type) {
            DB::table('job_types')->updateOrInsert(
                ['job_type' => $type],
                ['job_type' => $type]
            );
        }
    }
}