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
    public function flights(){
        return $this->hasMany(Flight::class);
    }
    public function scopeSearch($query, $value)
    {
        $query->where('aircraft_name', 'like', "%{$value}%")
            ->orWhere('aircraft_code', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('manufacturer', 'like', "%{$value}%")
            ->orWhere('registration_number', 'like', "%{$value}%")
            ->orWhereHas('user',function ($subQuery) use($value){
                $subQuery->where('name', 'like', "%{$value}%");
            } );
    }
}
