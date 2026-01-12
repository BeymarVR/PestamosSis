// database/migrations/2025_06_10_000000_create_solicitud_creditos_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitud_creditos', function (Blueprint $table) {
            $table->id();
            
            // Relación con usuario (cliente)
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            
            // Datos del formulario - Sección I
            $table->string('oficial_credito')->nullable();
            $table->string('numero_solicitud')->unique();
            $table->date('fecha_solicitud');
            $table->enum('producto', ['mensual', 'semanal', 'diario']);
            
            // I. DATOS GENERALES DEL SOLICITANTE (complementa tabla usuarios)
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('edad')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('telefono_fijo')->nullable();
            $table->string('celular_solicitante')->nullable();
            $table->text('domicilio')->nullable();
            $table->enum('tipo_vivienda', ['propia', 'alquiler', 'familiar', 'anticretico', 'otra'])->nullable();
            $table->decimal('monto_vivienda', 12, 2)->nullable();
            $table->integer('tiempo_permanencia_anios')->nullable();
            $table->integer('tiempo_permanencia_meses')->nullable();
            $table->string('correo_solicitante')->nullable();
            
            // II. DATOS PERSONALES DEL CONYUGUE
            $table->string('conyuge_nombre_completo')->nullable();
            $table->string('conyuge_ci')->nullable();
            $table->string('conyuge_expedido')->nullable();
            $table->date('conyuge_fecha_nacimiento')->nullable();
            $table->integer('conyuge_edad')->nullable();
            $table->string('conyuge_estado_civil')->nullable();
            $table->string('conyuge_telefono_fijo')->nullable();
            $table->string('conyuge_celular')->nullable();
            $table->text('conyuge_domicilio')->nullable();
            $table->enum('conyuge_tipo_vivienda', ['propia', 'alquiler', 'familiar', 'anticretico', 'otra'])->nullable();
            $table->decimal('conyuge_monto_vivienda', 12, 2)->nullable();
            $table->integer('conyuge_tiempo_permanencia_anios')->nullable();
            $table->integer('conyuge_tiempo_permanencia_meses')->nullable();
            $table->string('conyuge_correo')->nullable();
            
            // III. DATOS DEL GARANTE
            $table->string('garante_nombre_completo')->nullable();
            $table->string('garante_ci')->nullable();
            $table->string('garante_expedido')->nullable();
            $table->date('garante_fecha_nacimiento')->nullable();
            $table->integer('garante_edad')->nullable();
            $table->string('garante_estado_civil')->nullable();
            $table->string('garante_telefono_fijo')->nullable();
            $table->string('garante_celular')->nullable();
            $table->text('garante_domicilio')->nullable();
            $table->enum('garante_tipo_vivienda', ['propia', 'alquiler', 'familiar', 'anticretico', 'otra'])->nullable();
            $table->decimal('garante_monto_vivienda', 12, 2)->nullable();
            $table->integer('garante_tiempo_permanencia_anios')->nullable();
            $table->integer('garante_tiempo_permanencia_meses')->nullable();
            $table->string('garante_correo')->nullable();
            
            // IV. DATOS LABORALES (JSON para estructuras complejas)
            $table->json('datos_laborales')->nullable(); // {tipo: dependiente/independiente, profesion, empresa, etc}
            
            // V. DEUDAS EN OTRAS INSTITUCIONES (se manejará en tabla aparte)
            
            // VI. SOLICITUD DE CREDITO
            $table->decimal('monto_solicitado', 12, 2);
            $table->string('moneda')->default('BS');
            $table->string('monto_literal')->nullable();
            $table->decimal('tipo_cambio', 10, 4)->nullable();
            $table->text('objetivo_credito')->nullable();
            
            // VII. TERMINOS Y CONDICIONES
            $table->boolean('autorizacion_buro')->default(false);
            $table->string('firma_solicitante')->nullable(); // Para PDF
            $table->string('firma_conyuge')->nullable();
            $table->string('firma_garante')->nullable();
            
            // Información de aprobación
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
            $table->date('fecha_aprobacion')->nullable();
            $table->string('autorizado_por')->nullable();
            $table->date('fecha_firma_contrato')->nullable();
            
            // Relación con préstamo generado
            $table->foreignId('prestamo_id')->nullable()->constrained('prestamos')->nullOnDelete();
            
            // Archivos adjuntos (ruta o JSON)
            $table->json('archivos_adjuntos')->nullable();
            
            // Auditoría
            $table->foreignId('creado_por')->nullable()->constrained('usuarios');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitud_creditos');
    }
};