<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $table = 'flights';
    protected $fillable = [
        'flight_number','flight_date','aircraft_id','origin_airport_id','destination_airport_id','status',
        'departure_time','arrival_time','user_id','aircraft_number','flight_type'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function flightHours()
    {
        return $this->hasMany(FlightHour::class);
    }
    public function aircraft(){
        return $this->belongsTo(Aircraft::class);
    }
    public function originAirport()
    {
        return $this->belongsTo(Airport::class, 'origin_airport_id');
    }

    public function destinationAirport()
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }
    public function crews()
    {
        return $this->belongsToMany(Crew::class, 'crews_flights');
    }
    public function scopeSearch($query, $value)
    {
        return $query->where('flight_number', 'like', "%{$value}%")
            ->orWhere('flight_date', 'like', "%{$value}%")
            ->orWhereHas('user', function ($subQuery) use ($value) {
                $subQuery->where('name', 'like', "%{$value}%");
            })
            ->orWhereHas('originAirport', function ($subQuery) use ($value) {
                $subQuery->where('airport_name', 'like', "%{$value}%");
            })
            ->orWhereHas('destinationAirport', function ($subQuery) use ($value) {
                $subQuery->where('airport_name', 'like', "%{$value}%");
            })
            ->orWhereHas('aircraft', function ($subQuery) use ($value) {
                $subQuery->where('aircraft_name', 'like', "%{$value}%");
            });
    }

}

