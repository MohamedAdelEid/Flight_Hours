<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    const STATUS_PENDING_REVIEW = 'pending_review';
    const STATUS_COMPLETED = 'completed';
    const STATUS_REJECTED = 'rejected';

    protected $table = 'flights';

    protected $fillable = [
        'round_trip_id','flight_number','flight_date','aircraft_id','origin_airport_id','destination_airport_id','status',
        'departure_time','arrival_time','user_id','aircraft_number','flight_type','image',
        'reviewed_by','reviewed_at','rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function reviewer(){
        return $this->belongsTo(User::class, 'reviewed_by');
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
    public function crewNormalFlights()
    {
        return $this->hasMany(CrewNormalFlights::class, 'flight_id');
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

    public function scopePendingReview($query)
    {
        return $query->where('status', self::STATUS_PENDING_REVIEW);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }
}
