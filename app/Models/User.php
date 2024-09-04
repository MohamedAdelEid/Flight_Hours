<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\updatedEmailnotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string'
    ];

    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class);
    }
    public function airports()
    {
        return $this->hasMany(Airport::class);
    }
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    public function crews()
    {
        return $this->hasMany(Crew::class);
    }
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === "admin";
    }

    public function isEmployee(): bool
    {
        return $this->role === "employee";
    }

    public function isCaptain(): bool
    {
        return $this->role === "captain";
    }


}
