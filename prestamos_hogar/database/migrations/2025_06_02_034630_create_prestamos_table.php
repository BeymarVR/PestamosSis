<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('prestamos', function (Blueprint $table) {
        $table->id();
        $table->string('codigo')->unique();
        $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
        $table->decimal('monto', 10, 2);
        $table->decimal('tasa_interes_mensual', 5, 2);
        $table->tinyInteger('plazo_meses');
        $table->enum('frecuencia_pago', ['diario', 'semanal', 'quincenal', 'mensual']);
        $table->date('fecha_desembolso');
        $table->enum('estado', ['vigente', 'cancelado', 'mora'])->default('vigente');
        $table->string('referencia_celular')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
