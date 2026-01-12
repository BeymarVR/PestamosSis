<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plan_pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained()->onDelete('cascade');
            $table->integer('numero_cuota');
            $table->date('fecha_vencimiento');
            $table->decimal('monto_cuota', 10, 2);
            $table->decimal('capital', 10, 2);
            $table->decimal('interes', 10, 2);
            $table->decimal('saldo', 10, 2);
            $table->string('estado')->default('pendiente'); // pendiente, pagado, mora
            $table->date('fecha_pago')->nullable();
            $table->decimal('mora', 10, 2)->default(0);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plan_pagos');
    }
};