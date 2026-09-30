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
        Schema::create('catmenu', function (Blueprint $table) {
            $table->string('ecodMenu',50);
            $table->string('tNombre',25);
            $table->string('ecodIconos',50);
            $table->string('ecodEstatus',50);
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
        Schema::drop('catmenu');

    }
};
