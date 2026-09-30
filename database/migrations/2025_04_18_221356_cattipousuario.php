<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cattipousuario', function (Blueprint $table) {
            $table->string('ecodTipoUsuario',50);
            $table->string('tNombre',30);
            $table->string('ecodCreacion',50);
            $table->datetime('fhCreacion');
            $table->string('ecodEdicion',50);
            $table->datetime('fhEdicion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('cattipousuario');
    }
};
