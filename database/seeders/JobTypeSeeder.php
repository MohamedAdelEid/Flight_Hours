<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTypeSeeder extends Seeder
{
    public function run(): void
    {
        $existingTypes = DB::table('job_types')->pluck('job_type')->toArray();

        if (! in_array('piloting', $existingTypes)) {
            DB::table('job_types')->insert(['job_type' => 'piloting']);
        }
        if (! in_array('engineering', $existingTypes)) {
            DB::table('job_types')->insert(['job_type' => 'engineering']);
        }
        if (! in_array('cabin', $existingTypes)) {
            DB::table('job_types')->insert(['job_type' => 'cabin']);
        }
        if (! in_array('ground', $existingTypes)) {
            DB::table('job_types')->insert(['job_type' => 'ground']);
        }
    }
}
