<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrewFlight extends Model
{
    use HasFactory;
    protected $table = 'crews_flights';
    protected $fillable = [
        'flight_id','crew_id','job_id','training_start_at','training_end_at','user_id'
    ];

    public function flights(){
        return $this->belongsTo(Flight::class);
    }
    public function crew(){
        return $this->belongsTo(Crew::class);
    }
    public function job(){
        return $this->belongsTo(Job::class);
    }

}
