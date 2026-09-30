<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class cattipousuario extends Eloquent
{
    use HasFactory, Notifiable;
    
    protected $connection = 'mongodb';
    protected $table = 'cattipousuario';
    protected $primaryKey = 'ecodTipoUsuario'; 
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ecodTipoUsuario',
        'tNombre',
    ];
}
