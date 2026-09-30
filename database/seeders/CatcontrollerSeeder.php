<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\catcontroller;
use Carbon\Carbon;

class CatcontrollerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catcontroller = new catcontroller;
        $catcontroller-> ecodControler = '20b70474-70ee-483e-8d6c-2fa5f280d404';
        $catcontroller-> tNombre = 'Editar usuario';
        $catcontroller-> tUrl = '/catalogo/usuario/registrar';
        $catcontroller-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller-> fhCreacion = Carbon::now();
        $catcontroller-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller->save();

        $catcontroller = new catcontroller;
        $catcontroller-> ecodControler = '2cedd864-391d-4d1f-8f7a-c7f3fc5a39ab';
        $catcontroller-> tNombre = 'Eliminar usuario';
        $catcontroller-> tUrl = '/catalogo/usuario/eliminar';
        $catcontroller-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller-> fhCreacion = Carbon::now();
        $catcontroller-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller->save();

        $catcontroller = new catcontroller;
        $catcontroller-> ecodControler = '43fd861b-bd43-4514-b01b-b33a0955f8d5';
        $catcontroller-> tNombre = 'Editar productos';
        $catcontroller-> tUrl = '/catalogo/productos/registrar';
        $catcontroller-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller-> fhCreacion = Carbon::now();
        $catcontroller-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller->save();
        
        $catcontroller = new catcontroller;
        $catcontroller-> ecodControler = '6d1c226a-4805-4833-a13b-efeb91dc4e53';
        $catcontroller-> tNombre = 'Eliminar productos';
        $catcontroller-> tUrl = '/catalogo/productos/eliminar';
        $catcontroller-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller-> fhCreacion = Carbon::now();
        $catcontroller-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller->save();

        $catcontroller = new catcontroller;
        $catcontroller-> ecodControler = '2c1a72cf-5003-4ab1-a2cd-092eac57a7c1';
        $catcontroller-> tNombre = 'Eliminar Perfiles';
        $catcontroller-> tUrl = '/catalogo/perfiles/eliminar';
        $catcontroller-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller-> fhCreacion = Carbon::now();
        $catcontroller-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller->save();
        
        $catcontroller = new catcontroller;
        $catcontroller-> ecodControler = 'af707ff1-5e40-4fd8-a472-f27cac7467bb';
        $catcontroller-> tNombre = 'Editar Perfiles';
        $catcontroller-> tUrl = '/catalogo/perfiles/registrar';
        $catcontroller-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller-> fhCreacion = Carbon::now();
        $catcontroller-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catcontroller->save();
        
    }
}
