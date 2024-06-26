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
        Schema::create('grupo_materia_boleta_inscripcions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boleta_inscripcion_id');
            $table->unsignedBigInteger('grupo_materia_id');
            $table->timestamps();

            $table->foreign('grupo_materia_id')->references('id')->on('grupo_materias')->onDelete('cascade');
            $table->foreign('boleta_inscripcion_id')->references('id')->on('boleta_inscripcions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_materia_boleta_inscripcions');
    }
};
