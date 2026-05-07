<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    public function run(): void
    {
        $user = \App\Models\User::where('email', 'dev.mohamedadell@gmail.com')->first();

        if ($user) {
            $existingCodes = DB::table('airports')->pluck('airport_code')->toArray();

            if (! in_array('DMM', $existingCodes)) {
                Airport::create([
                    'airport_name' => 'مطار الملك فهد الدولي',
                    'airport_code' => 'DMM',
                    'user_id' => $user->id,
                ]);
            }
            if (! in_array('RUH', $existingCodes)) {
                Airport::create([
                    'airport_name' => 'مطار الملك خالد الدولي',
                    'airport_code' => 'RUH',
                    'user_id' => $user->id,
                ]);
            }
            if (! in_array('MED', $existingCodes)) {
                Airport::create([
                    'airport_name' => 'مطار الأمير محمد بن عبدالعزيز الدولي',
                    'airport_code' => 'MED',
                    'user_id' => $user->id,
                ]);
            }
            if (! in_array('DXB', $existingCodes)) {
                Airport::create([
                    'airport_name' => 'مطار دبي الدولي',
                    'airport_code' => 'DXB',
                    'user_id' => $user->id,
                ]);
            }
            if (! in_array('DOH', $existingCodes)) {
                Airport::create([
                    'airport_name' => 'مطار الدوحة الدولي',
                    'airport_code' => 'DOH',
                    'user_id' => $user->id,
                ]);
            }
            if (! in_array('KWI', $existingCodes)) {
                Airport::create([
                    'airport_name' => 'مطار الكويت الدولي',
                    'airport_code' => 'KWI',
                    'user_id' => $user->id,
                ]);
            }
            if (! in_array('MCT', $existingCodes)) {
                Airport::create([
                    'airport_name' => 'مطار مسقط الدولي',
                    'airport_code' => 'MCT',
                    'user_id' => $user->id,
                ]);
            }
            if (! in_array('AMM', $existingCodes)) {
                Airport::create([
                    'airport_name' => 'مطار عمّانلكة ',
                    'airport_code' => 'AMM',
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
