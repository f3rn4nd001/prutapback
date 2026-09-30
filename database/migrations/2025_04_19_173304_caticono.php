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
        Schema::create('caticono', function (Blueprint $table) {
            $table->_id('ecodIcono',50);
            $table->string('tIcono',50);
            $table->string('tNombre',30);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('caticono');

    }
};
