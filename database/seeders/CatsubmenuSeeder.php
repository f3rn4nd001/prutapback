<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\catsubmenu;
use Carbon\Carbon;

class CatsubmenuSeeder extends Seeder
{
    public function run(): void
    {
        $catsubmenu = new catsubmenu;
        $catsubmenu-> ecodSubmenu = '710b0887-8372-4148-bf17-f169d762fcf3';
        $catsubmenu-> tNombre = 'Usuarios';
        $catsubmenu-> tUrl = '/catalogo/usuario';
        $catsubmenu-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catsubmenu-> fhCreacion = Carbon::now();
        $catsubmenu-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catsubmenu->save();

        $catsubmenu = new catsubmenu;
        $catsubmenu-> ecodSubmenu = '3d8d0c26-e4c6-480c-8d73-a5a9cba0eae2';
        $catsubmenu-> tNombre = 'Productos';
        $catsubmenu-> tUrl = '/catalogo/productos';
        $catsubmenu-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catsubmenu-> fhCreacion = Carbon::now();
        $catsubmenu-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catsubmenu->save();
        
        $catsubmenu = new catsubmenu;
        $catsubmenu-> ecodSubmenu = '0c6e7c58-a3b2-4279-8eec-35201a9bec09';
        $catsubmenu-> tNombre = 'Perfiles';
        $catsubmenu-> tUrl = '/catalogo/perfiles';
        $catsubmenu-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catsubmenu-> fhCreacion = Carbon::now();
        $catsubmenu-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catsubmenu->save();
    }
}
