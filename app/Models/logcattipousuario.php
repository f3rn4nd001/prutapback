<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class logcattipousuario extends Eloquent
{
    protected $table = 'logcattipousuario';
    protected $primaryKey = 'ecodLogTipoUsuario'; 
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'ecodLogTipoUsuario',
        'tNombre',
    ];
}
