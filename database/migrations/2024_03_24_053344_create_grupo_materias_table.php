<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('grupo_materias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('user_docente_id');

            $table->string('contraseña');
            $table->integer('cantidad_estudiantes');
            $table->integer('cantidad_estudiantes_inscritos');
            $table->timestamps();

            $table->foreign('user_docente_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('grupo_materias');
    }
};
