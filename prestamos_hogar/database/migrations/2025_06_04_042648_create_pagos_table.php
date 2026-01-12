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
        Schema::create('pagos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('plan_pago_id')->constrained()->onDelete('cascade');
    $table->decimal('monto', 12, 2);
    $table->date('fecha_pago');
    $table->enum('metodo_pago', ['efectivo', 'transferencia', 'cheque', 'deposito', 'otro']);
    $table->string('comprobante')->nullable();
    $table->text('observaciones')->nullable();
    $table->foreignId('usuario_registrador_id')->constrained('usuarios');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
