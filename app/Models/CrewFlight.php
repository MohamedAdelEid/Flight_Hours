<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrewFlight extends Model
{
    use HasFactory;
    protected $fillable = [
        'flight_id','crew_id','user_id'
    ];

    public function flights(){
        return $this->belongsToMany(Flight::class);
    }
    public function crews(){
        return $this->belongsToMany(Crew::class);
    }
}
