<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\cattipousuario;
use Carbon\Carbon;

class CattipousuarioSeeder extends Seeder
{
    public function run(): void
    {
        $cattipousuario = new cattipousuario;
        $cattipousuario-> ecodTipoUsuario = '0328f6ff-a2d4-47c8-959d-9e603b22db29';
        $cattipousuario-> tNombre = 'Operador';
        $cattipousuario-> fhCreacion = Carbon::now();
        $cattipousuario-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $cattipousuario->save();
        $cattipousuario = new cattipousuario;
        $cattipousuario-> ecodTipoUsuario = 'b55aa80a-8c1f-4e91-8366-07dd44446b5c';
        $cattipousuario-> tNombre = 'Cliente';
        $cattipousuario-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $cattipousuario-> fhCreacion = Carbon::now();
        $cattipousuario->save();
        $cattipousuario = new cattipousuario;
        $cattipousuario-> ecodTipoUsuario = 'd2438dce-4bb9-402f-801b-9dc371d08e6e';
        $cattipousuario-> tNombre = 'Empleados';
        $cattipousuario-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $cattipousuario-> fhCreacion = Carbon::now();
        $cattipousuario->save();
        $cattipousuario = new cattipousuario;
        $cattipousuario-> ecodTipoUsuario = 'fa6cc9a2-f221-4e27-b575-1fac2698d27a';
        $cattipousuario-> tNombre = 'Administrador';
        $cattipousuario-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $cattipousuario-> fhCreacion = Carbon::now();
        $cattipousuario->save();
    }
}
