<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CattipousuarioSeeder::class);  
        $this->call(BitcorreoSeeder::class);  
        $this->call(CatestatusSeeder::class);  
        $this->call(RelusuariocorreoSeender::class);  
        $this->call(CatusuariosSeeder::class);  
        $this->call(RelusuariomenusubmenucontrollerSeeder::class);
        $this->call(CatmenuSeeder::class);
        $this->call(CaticonoSeeder::class);
        $this->call(CatsubmenuSeeder::class);
        $this->call(CatcontrollerSeeder::class);
        $this->call(RelmarcamodeloSeeder::class);
        $this->call(CatmarcaSeeder::class);
        $this->call(CatmodeloSeeder::class);
        $this->call(CatproductosSeeder::class);
        $this->call(RlmenusubmenucontrolleSeeder::class);
        
    }
}
