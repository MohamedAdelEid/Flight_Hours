<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    protected $fillable = [
        'job_name',
        'type_id',
        'status',
        'user_id',
        'hourly_calculation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function crews()
    {
        return $this->hasMany(Crew::class);
    }

    public function job_type()
    {
        return $this->belongsTo(JobType::class, 'type_id');
    }

    public function scopeSearch($query, $value)
    {
        $query
            ->where('job_name', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhereHas('job_type', function ($subQuery) use ($value) {
                $subQuery->where('job_type', 'like', "%{$value}%");
            })
            ->orWhereHas('user', function ($subQuery) use ($value) {
                $subQuery->where('name', 'like', "%{$value}%");
            });
    }
}
