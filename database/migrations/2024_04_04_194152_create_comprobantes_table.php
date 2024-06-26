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
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_estudiante_id');
            $table->unsignedBigInteger('user_administrativo_id');
            $table->time('hora');
            $table->date('fecha');
            $table->decimal('monto_total', 8, 2);
            $table->timestamps();

            $table->foreign('user_estudiante_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_administrativo_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantes');
    }
};
