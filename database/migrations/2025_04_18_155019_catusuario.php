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
        Schema::create('catusuario', function (Blueprint $table) {
            $table->string('ecodUsuario',50);
            $table->string('tNombre',40);
            $table->string('tApellido',40);
            $table->string('tCRUP',25);
            $table->string('tRFC',30);
            $table->integer('nEdad',4);
            $table->string('tSexo',20);
            $table->double('nTelefono');
            $table->string('tNotas');
            $table->date('fhNacimiento');
            $table->string('iUsuario');
            $table->string('ecodTipoUsuario',50);
            $table->string('ecodEstatus',50);
            $table->datetime('fhCreacion');
            $table->string('ecodCreacion',50);
            $table->string('ecodEdicion',50);
            $table->datetime('fhEdicion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('catusuario');
    }
};
