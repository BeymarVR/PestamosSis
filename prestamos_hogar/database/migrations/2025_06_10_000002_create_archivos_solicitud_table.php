// database/migrations/2025_06_10_000002_create_archivos_solicitud_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archivos_solicitud', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_credito_id')->constrained('solicitud_creditos')->onDelete('cascade');
            $table->string('nombre_archivo');
            $table->string('ruta');
            $table->string('tipo')->nullable(); // ci, comprobante_ingresos, etc
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos_solicitud');
    }
};