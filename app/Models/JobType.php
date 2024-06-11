<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    use HasFactory;
    protected $table = 'job_types';
    protected $fillable = ['job_type'];

    public function jobs(){
        return $this->hasMany(Job::class,'type_id');
    }
    public function crews(){
        return $this->hasMany(Crew::class,'type_id');
    }
}
