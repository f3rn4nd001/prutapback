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
        Schema::create('logcatproducro', function (Blueprint $table) {
            $table->string('ecodLogProducto',50);
            $table->string('ecodProductos',50);
            $table->string('tNombre',50);
            $table->decimal('nPrecio',5,2);
            $table->string('ecodMarca',50);
            $table->string('ecodEstatus',50);
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
        Schema::drop('logcatproducro');

    }
};
