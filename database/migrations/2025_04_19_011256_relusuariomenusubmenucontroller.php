<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('relusuariomenusubmenucontroller', function (Blueprint $table) {
            $table->string('ecodRelusRarioMenuSubmenuController',50);
            $table->string('ecodUsuario',50);
            $table->string('ecodMenu',50)->nullable();
            $table->string('ecodSubmenu',50)->nullable();
            $table->string('ecodController',50)->nullable();
            $table->text('tToken');
        });
    }

    public function down(): void
    {
        Schema::drop('relusuariomenusubmenucontroller');
    }
};
