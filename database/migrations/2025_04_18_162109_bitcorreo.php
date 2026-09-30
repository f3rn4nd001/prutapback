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
        Schema::create('bitcorreo', function (Blueprint $table) {
            $table->string('ecodCorreo',50);
            $table->string('tCorreo',100);
            $table->string('tpassword',100);
            $table->text('tToken')->nullable();
            $table->string('tIp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('bitcorreo');
    }
};
