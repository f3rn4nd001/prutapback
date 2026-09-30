<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class catestatus extends Eloquent
{
    use HasFactory, Notifiable;

    protected $connection = 'mongodb';
    protected $table = 'catestatus';
    protected $primaryKey = 'ecodEstatus'; 
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ecodEstatus',
        'tNombre',
    ];
}
