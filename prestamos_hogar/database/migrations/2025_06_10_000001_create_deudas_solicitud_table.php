// database/migrations/2025_06_10_000001_create_deudas_solicitud_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deudas_solicitud', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_credito_id')->constrained('solicitud_creditos')->onDelete('cascade');
            $table->string('institucion')->nullable();
            $table->decimal('monto', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deudas_solicitud');
    }
};