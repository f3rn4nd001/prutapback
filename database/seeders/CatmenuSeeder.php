<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\catmenu;
use Carbon\Carbon;

class CatmenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catmenu = new catmenu;
        $catmenu-> ecodMenu = '9bd00aa8-7232-44dc-bcb7-f209d503e391';
        $catmenu-> tNombre = 'Catalogo';
        $catmenu-> ecodIconos = '07cd1626-ac19-47f8-9ed6-ab4a3de7f574';
        $catmenu-> ecodCreacion = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catmenu-> fhCreacion = Carbon::now();
        $catmenu-> ecodEstatus = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $catmenu->save();
    }
}
