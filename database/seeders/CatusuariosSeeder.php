<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\catusuario;
use Carbon\Carbon;

class CatusuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $catusuario = new catusuario;
        $catusuario-> ecodUsuario = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catusuario-> tNombre = 'Carlos Fernando';
        $catusuario-> tApellido = 'Ventura Marin';
        $catusuario-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catusuario-> ecodTipoUsuario = 'fa6cc9a2-f221-4e27-b575-1fac2698d27a';
        $catusuario-> fhCreacion = Carbon::now();
        $catusuario-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catusuario->save();

        $catusuario = new catusuario;
        $catusuario-> ecodUsuario = '26a0da36e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catusuario-> tNombre = 'Pedrop';
        $catusuario-> tApellido = 'Marin';
        $catusuario-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catusuario-> ecodTipoUsuario = 'fa6cc9a2-f221-4e27-b575-1fac2698d27a';
        $catusuario-> fhCreacion = Carbon::now();
        $catusuario-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catusuario->save();
       
    }
}
