<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE moras DROP CONSTRAINT IF EXISTS moras_estado_check;");
        DB::statement("ALTER TABLE moras ADD CONSTRAINT moras_estado_check CHECK (estado IN ('activa', 'inactiva'));");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE moras DROP CONSTRAINT IF EXISTS moras_estado_check;");
    }
};

