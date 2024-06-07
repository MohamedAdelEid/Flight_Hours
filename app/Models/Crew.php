<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    use HasFactory;
    protected $fillable = [
        'financial_number',
        'first_name',
        'last_name',
        'nickname',
        'date_of_birth',
        'aircraft_type',
        'license_number',
        'job_id',
        'status',
        'user_id',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
