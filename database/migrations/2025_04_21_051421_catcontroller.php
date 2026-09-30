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
        Schema::create('catcontroller', function (Blueprint $table) {
            $table->string('ecodControler',50);
            $table->string('tNombre',55);
            $table->string('tUrl',100);
            $table->string('ecodEstatus',50);
            $table->string('ecodCreacion',50);
            $table->datetime('fhCreacion');
            $table->string('ecodEdicion',50);
            $table->datetime('fhEdicion');
        });
    }

    public function down(): void
    {
        Schema::drop('catcontroller');
    }
};
