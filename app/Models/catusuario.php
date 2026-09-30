<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class catusuario extends Eloquent
{
    protected $table = 'catusuario';
    protected $primaryKey = 'ecodUsuario'; 
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ecodUsuario',
        'tNombre',
        'ecodEstatus',
    ];
    
    protected $casts = [
        'nEdad' => 'integer',
        'nTelefono' => 'double',
        'fhNacimiento' => 'date',
        'nTelefono' => 'double',
        'fhCreacion' => 'datetime',
        'fhEdicion' => 'datetime',
    ];
}
