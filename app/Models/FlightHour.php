<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightHour extends Model
{
    use HasFactory;
    protected $fillable = [
        'aircraft_id','flight_id','hours'
    ];

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
    static function calcFlightHours($flight)
    {
        $departureTime = Carbon::parse($flight->departure_time);
        $arrivalTime = Carbon::parse($flight->arrival_time);
        $diff = $departureTime->diff($arrivalTime);
        $hours = $diff->h + ($diff->i / 60);
        FlightHour::create([
            'aircraft_id' => $flight->aircraft_id,
            'flight_id' => $flight->id,
            'hours' => $hours
        ]);
    }
}


