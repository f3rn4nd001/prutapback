<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Bitcorreo extends Eloquent implements JWTSubject
{
    use HasFactory, Notifiable;
    
    protected $connection = 'mongodb';
    protected $table = 'bitcorreo';
    protected $primaryKey = 'ecodCorreo'; 
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ecodCorreo',
        'tToken',
        'tIp',
        'tpassword',
        'tCorreo'
    ];
    
    protected $hidden = [
        'tpassword',
        'tToken',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
}
