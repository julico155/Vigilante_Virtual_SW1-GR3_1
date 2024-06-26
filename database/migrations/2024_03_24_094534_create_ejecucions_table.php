<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esta tabla hace referencia a que un examen pueda ser ejecutado varias veces
     * que no haya la necesidad de volverlo a crear
     */
    public function up(): void
    {
        
        Schema::create('ejecucions', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->integer('ponderacion');
            $table->integer('nro_preguntas');
            $table->string('contrasena');
            $table->char('navegacion')->nullable();
            $table->char('retroalimentacion')->nullable();
            $table->unsignedBigInteger('examen_id');
            $table->unsignedBigInteger('estado_ejecucion_id');
            $table->timestamps();

            $table->foreign('examen_id')->references('id')->on('examens')->onDelete('cascade');
            $table->foreign('estado_ejecucion_id')->references('id')->on('estado_ejecucions')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejecucions');
    }
};
