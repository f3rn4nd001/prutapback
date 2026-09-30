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
        Schema::create('logcattipousuario', function (Blueprint $table) {
            $table->string('ecodLogTipoUsuario',50);
            $table->string('ecodTipoUsuario',50);
            $table->string('tNombre',50);
            $table->datetime('fhCreacion');
            $table->string('ecodCreacion',50);
            $table->string('ecodEdicion',50);
            $table->datetime('fhEdicion');
            $table->string('tMotivoEliminacon',250);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('logcattipousuario');
    }
};
