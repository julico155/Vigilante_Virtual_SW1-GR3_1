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
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->decimal('ponderacion', 8, 2);
            $table->string('comentario')->nullable();
            $table->unsignedBigInteger('tipo_pregunta_id');
            $table->unsignedBigInteger('examen_id');
            $table->timestamps();

            $table->foreign('tipo_pregunta_id')->references('id')->on('tipo_preguntas')->onDelete('cascade');
            $table->foreign('examen_id')->references('id')->on('examens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
