<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    use HasFactory;
    protected $table = 'crews';
    protected $fillable = [
      'financial_number',
        'first_name',
        'last_name',
        'nickname',
        'date_of_birth',
        'license_number',
        'job_id',
        'job_type',
        'status',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function job(){
        return $this->belongsTo(Job::class);
    }
    public function flights()
    {
        return $this->belongsToMany(Flight::class, 'crews_flights');
    }
    public function job_type(){
        return $this->belongsTo(JobType::class);
    }
    public function scopeSearch($query, $value)
    {
        $query->where('financial_number', 'like', "%{$value}%")
            ->orWhere('first_name', 'like', "%{$value}%")
            ->orWhere('last_name', 'like', "%{$value}%")
            ->orWhere('nickname', 'like', "%{$value}%")
            ->orWhere('license_number', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhereHas('job', function ($subQuery) use ($value) {
                $subQuery->where('job_name', 'like', "%{$value}%");
            })
            ->orWhereHas('user',function ($subQuery) use($value){
                $subQuery->where('name', 'like', "%{$value}%");
            } )
        ;
    }
}
