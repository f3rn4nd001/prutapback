<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\catmarca;
use Carbon\Carbon;

class CatmarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catmarca = new catmarca;
        $catmarca-> ecodMarca = 'd21d8b56-b4de-4445-bcfd-f44791550797';
        $catmarca-> tNombre = 'Renault Trucks';
        $catmarca-> tPaisOrigen = 'Francia';
        $catmarca-> ecodEstatus = '07cd1626-ac19-47f8-9ed6-ab4a3de7f574';
        $catmarca-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catmarca-> fhCreacion = Carbon::now();
        $catmarca-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catmarca->save();

        $catmarca = new catmarca;
        $catmarca-> ecodMarca = '0a09db62-c192-4a52-9f94-3da5337d7bfb';
        $catmarca-> tNombre = 'Freightliner';
        $catmarca-> tPaisOrigen = 'EE. UU.';
        $catmarca-> ecodEstatus = '07cd1626-ac19-47f8-9ed6-ab4a3de7f574';
        $catmarca-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catmarca-> fhCreacion = Carbon::now();
        $catmarca-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catmarca->save();
    }
}
