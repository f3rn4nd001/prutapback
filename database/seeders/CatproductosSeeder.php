<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\catproductos;
use Carbon\Carbon;

class CatproductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catproductos = new catproductos;
        $catproductos-> ecodProductos = '999720ca-4b1a-4363-a7aa-029c500d1e72';
        $catproductos-> tNombre = 'productos1';
        $catproductos-> ecodMarca = '0a09db62-c192-4a52-9f94-3da5337d7bfb';
        $catproductos-> nPrecio = 222;
        $catproductos-> ecodEstatus = '07cd1626-ac19-47f8-9ed6-ab4a3de7f574';
        $catproductos-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catproductos-> fhCreacion = Carbon::now();
        $catproductos-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catproductos->save();

        $catproductos = new catproductos;
        $catproductos-> ecodProductos = '000720ca-4b1a-4363-a7aa-029c500d1e72';
        $catproductos-> tNombre = 'productos3';
        $catproductos-> ecodMarca = '0a09db62-c192-4a52-9f94-3da5337d7bfb';
        $catproductos-> nPrecio = 222;
        $catproductos-> ecodEstatus = '07cd1626-ac19-47f8-9ed6-ab4a3de7f574';
        $catproductos-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catproductos-> fhCreacion = Carbon::now();
        $catproductos-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catproductos->save();
    }
}
