<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherFlights extends Model
{
    use HasFactory;
    protected $table = 'other_flights';
    protected $fillable = ['airport_id','aircraft_id','flight_number','flight_date'];
    public function aircraft(){
        return $this->belongsTo(Aircraft::class);
    }
    public function airport(){
        return $this->belongsTo(Airport::class);
    }
}
