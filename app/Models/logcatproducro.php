<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class logcatproducro extends Eloquent
{
    protected $table = 'logcatproducro';
    protected $primaryKey = 'ecodLogProducto'; 
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ecodLogProducto',
        'tNombre',
        'ecodEstatus',
    ];
    
    
}
