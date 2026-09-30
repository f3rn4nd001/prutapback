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
        Schema::create('relusuariocorreo', function (Blueprint $table) {
            $table->string('ecodRelUsuarioCorreo',50);
            $table->string('ecodCorreo',50);
            $table->string('ecodUsuario',50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('relusuariocorreo');
    }
};
