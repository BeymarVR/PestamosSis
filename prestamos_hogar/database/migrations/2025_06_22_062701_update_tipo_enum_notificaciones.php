<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // ✅ Importa DB aquí

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE notificaciones DROP CONSTRAINT IF EXISTS notificaciones_tipo_check;");
        DB::statement("ALTER TABLE notificaciones ADD CONSTRAINT notificaciones_tipo_check CHECK (tipo IN ('pago_proximo', 'pago_atrasado', 'mora', 'pago'));");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE notificaciones DROP CONSTRAINT IF EXISTS notificaciones_tipo_check;");
        DB::statement("ALTER TABLE notificaciones ADD CONSTRAINT notificaciones_tipo_check CHECK (tipo IN ('pago_proximo', 'pago_atrasado', 'mora'));");
    }
};
