<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\caticono;

class CaticonoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $caticono = new caticono;
        $caticono-> ecodIcono = '07cd1626-ac19-47f8-9ed6-ab4a3de7f574';
        $caticono-> tIcono = 'folder';
        $caticono-> tNombre = 'folder';
        $caticono->save();

        $caticono = new caticono;
        $caticono-> ecodIcono = '13c2f4db-22c4-41b2-b348-a85b037836ae';
        $caticono-> tIcono = 'build';
        $caticono-> tNombre = 'build';
        $caticono->save();
    }
}
