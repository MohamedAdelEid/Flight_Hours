<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    use HasFactory;
    protected $table = 'aircrafts';
    protected $fillable = [
        'aircraft_name',
        'aircraft_code',
        'manufacturer',
        'status',
        'registration_number',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function flightHours()
    {
        return $this->hasMany(FlightHour::class);
    }
}
