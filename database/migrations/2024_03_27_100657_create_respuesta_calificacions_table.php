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
        Schema::create('respuesta_calificacions', function (Blueprint $table) {
            $table->id();
            $table->string('contenido', 500)->nullable();
            $table->float('puntaje')->nullable();
            $table->unsignedBigInteger('respuesta_id')->nullable();
            $table->unsignedBigInteger('pregunta_id')->nullable();
            $table->unsignedBigInteger('calificacion_id');
            $table->timestamps();

            $table->foreign('respuesta_id')->references('id')->on('respuestas')->onDelete('cascade');
            $table->foreign('calificacion_id')->references('id')->on('calificacions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuesta_calificacions');
    }
};
