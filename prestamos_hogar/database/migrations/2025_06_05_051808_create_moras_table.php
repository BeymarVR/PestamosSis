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
        Schema::create('moras', function (Blueprint $table) {
        $table->id();
        $table->foreignId('plan_pago_id')->constrained('plan_pagos')->onDelete('cascade');
        $table->decimal('interes_mora', 10, 2);
        $table->integer('dias_atraso');
        $table->timestamp('fecha_calculo');
        $table->enum('estado', ['activa', 'justificada', 'pagada'])->default('activa');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moras');
    }
};
