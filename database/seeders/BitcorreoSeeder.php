<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\bitcorreo;

class BitcorreoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bitcorreo = new bitcorreo;
        $bitcorreo-> ecodCorreo = '8a69b1f0-3ea5-4422-b9e7-87e238dc71e0';
        $bitcorreo-> tCorreo = 'f3rn4nd0.v3ntur4@gmail.com';
        $bitcorreo-> tpassword = '$2y$12$PseR.w3xJcLLruCoNWS/EeEIy/L4QugcPj5Hy/MJK/cQcwnGxrdhu';
        $bitcorreo->save();
        
    }
}
