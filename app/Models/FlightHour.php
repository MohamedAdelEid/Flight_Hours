<?php

namespace App\Models;

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
}
