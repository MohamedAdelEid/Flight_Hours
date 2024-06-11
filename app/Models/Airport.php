<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;
    protected $table = 'airports';
    protected $fillable = [
      'airport_name',
      'airport_code',
      'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function flights(){
        return $this->hasMany(Flight::class);
    }
    public function scopeSearch($query, $value)
    {
        $query->where('airport_name', 'like', "%{$value}%")
            ->orWhere('airport_code', 'like', "%{$value}%")
            ->orWhereHas('user',function ($subQuery) use($value){
                $subQuery->where('name', 'like', "%{$value}%");
            } );
    }
}
