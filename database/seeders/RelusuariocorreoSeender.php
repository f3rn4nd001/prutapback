<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\relusuariocorreo;

class RelusuariocorreoSeender extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relusuariocorreo = new relusuariocorreo;
        $relusuariocorreo-> ecodRelUsuarioCorreo = '01ae3cd3-144c-46a3-99aa-bb9174761b37';
        $relusuariocorreo-> ecodCorreo = '8a69b1f0-3ea5-4422-b9e7-87e238dc71e0';
        $relusuariocorreo-> ecodUsuario = '2660376e-dbf8-44c1-b69f-b2554e3e5d4c';
        $relusuariocorreo->save();
        

    }
}
