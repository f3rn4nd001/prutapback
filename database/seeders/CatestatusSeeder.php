<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\catestatus;

class CatestatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catestatus = new catestatus;
        $catestatus-> ecodEstatus = '01ae3cd3-144c-46a3-99aa-bb9174761b37';
        $catestatus-> tNombre = 'En proceso';
        $catestatus->save();
        
        $catestatus = new catestatus;
        $catestatus-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catestatus-> tNombre = 'Activo';
        $catestatus->save();

        $catestatus = new catestatus;
        $catestatus-> ecodEstatus = '58a7e6e5-4a10-474a-8f5e-c97155edf248';
        $catestatus-> tNombre = 'Mantenimiento';
        $catestatus->save();

        $catestatus = new catestatus;
        $catestatus-> ecodEstatus = '5bf018a2-07c0-497e-b376-94531e337dad';
        $catestatus-> tNombre = 'Cancelado';
        $catestatus->save();

        $catestatus = new catestatus;
        $catestatus-> ecodEstatus = '93a484c5-ce42-435e-98ac-12bc215d95b5';
        $catestatus-> tNombre = 'Terminado';
        $catestatus->save();

        $catestatus = new catestatus;
        $catestatus-> ecodEstatus = 'aae1c339-1b68-40f2-a47f-2f9e17ef7fd3';
        $catestatus-> tNombre = 'Agotado';
        $catestatus->save();

        $catestatus = new catestatus;
        $catestatus-> ecodEstatus = 'fa6cc9a2-f221-4e27-b575-1fac2698d27a';
        $catestatus-> tNombre = 'Eliminado';
        $catestatus->save();
    }
}
