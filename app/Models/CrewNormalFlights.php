<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrewNormalFlights extends Model
{
    use HasFactory;
    protected $table = 'crew_normal_flights';
    protected $fillable = [
        'flight_id','crew_id','user_id'
    ];

    public function flights(){
        return $this->belongsTo(Flight::class);
    }
    public function crew(){
        return $this->belongsTo(Crew::class);
    }

}
