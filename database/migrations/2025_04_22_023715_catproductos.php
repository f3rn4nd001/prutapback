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
        Schema::create('catproductos', function (Blueprint $table) {
            $table->string('ecodProductos',50);
            $table->string('tNombre',50);
            $table->string('ecodMarca',50);
            $table->decimal('nPrecio', 5, 2);
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
        Schema::drop('catproductos');
    }
};
