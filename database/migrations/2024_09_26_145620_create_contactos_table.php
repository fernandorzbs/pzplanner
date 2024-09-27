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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('celular')->unique()->nullable();
            $table->string('genero')->boolean()->default(0);
            $table->string('estado')->boolean()->default(1);
            $table->boolean('confirmado')->default(1);
            $table->string('whatsapp_exist')->boolean()->default(0);
            $table->string('pais')->default('py')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
