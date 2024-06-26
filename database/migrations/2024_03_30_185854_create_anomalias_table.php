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
        Schema::create('anomalias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ejecucion_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->time('hora');
            $table->date('fecha');
            $table->string('url_imagen');
            $table->unsignedBigInteger('tipo_anomalia_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ejecucion_id')->references('id')->on('ejecucions')->onDelete('cascade');
            $table->foreign('tipo_anomalia_id')->references('id')->on('tipo_anomalias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anomalias');
    }
};
