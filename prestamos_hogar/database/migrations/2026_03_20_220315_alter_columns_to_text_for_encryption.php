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
        // 1. Drop unique index for CI (encrypted strings cannot be reliably unique across DB)
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropUnique(['ci']);
            $table->text('ci')->change();
            $table->text('celular')->nullable()->change();
        });

        Schema::table('solicitud_creditos', function (Blueprint $table) {
            $table->text('telefono_fijo')->nullable()->change();
            $table->text('celular_solicitante')->nullable()->change();
            $table->text('conyuge_ci')->nullable()->change();
            $table->text('conyuge_celular')->nullable()->change();
            $table->text('garante_ci')->nullable()->change();
            $table->text('garante_celular')->nullable()->change();
        });

        Schema::table('prestamos', function (Blueprint $table) {
            $table->text('referencia_celular')->nullable()->change();
        });

        // Encrypt existing data
        $users = \Illuminate\Support\Facades\DB::table('usuarios')->get();
        foreach ($users as $user) {
            $updates = [];
            if (!empty($user->ci) && !\Illuminate\Support\Str::startsWith($user->ci, 'eyJpdiI')) { $updates['ci'] = \Illuminate\Support\Facades\Crypt::encryptString($user->ci); }
            if (!empty($user->celular) && !\Illuminate\Support\Str::startsWith($user->celular, 'eyJpdiI')) { $updates['celular'] = \Illuminate\Support\Facades\Crypt::encryptString($user->celular); }
            if (!empty($updates)) {
                \Illuminate\Support\Facades\DB::table('usuarios')->where('id', $user->id)->update($updates);
            }
        }
        
        $solicitudes = \Illuminate\Support\Facades\DB::table('solicitud_creditos')->get();
        foreach ($solicitudes as $sol) {
            $updates = [];
            $cols = ['telefono_fijo', 'celular_solicitante', 'conyuge_ci', 'conyuge_celular', 'garante_ci', 'garante_celular'];
            foreach ($cols as $col) {
                if (!empty($sol->$col) && !\Illuminate\Support\Str::startsWith($sol->$col, 'eyJpdiI')) {
                    $updates[$col] = \Illuminate\Support\Facades\Crypt::encryptString($sol->$col);
                }
            }
            if (!empty($updates)) {
                \Illuminate\Support\Facades\DB::table('solicitud_creditos')->where('id', $sol->id)->update($updates);
            }
        }

        $prestamos = \Illuminate\Support\Facades\DB::table('prestamos')->get();
        foreach ($prestamos as $prestamo) {
            if (!empty($prestamo->referencia_celular) && !\Illuminate\Support\Str::startsWith($prestamo->referencia_celular, 'eyJpdiI')) {
                \Illuminate\Support\Facades\DB::table('prestamos')->where('id', $prestamo->id)->update([
                    'referencia_celular' => \Illuminate\Support\Facades\Crypt::encryptString($prestamo->referencia_celular)
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('ci', 255)->change();
            $table->string('celular', 255)->nullable()->change();
            $table->unique('ci');
        });
        
        Schema::table('solicitud_creditos', function (Blueprint $table) {
            $table->string('telefono_fijo', 255)->nullable()->change();
            $table->string('celular_solicitante', 255)->nullable()->change();
            $table->string('conyuge_ci', 255)->nullable()->change();
            $table->string('conyuge_celular', 255)->nullable()->change();
            $table->string('garante_ci', 255)->nullable()->change();
            $table->string('garante_celular', 255)->nullable()->change();
        });

        Schema::table('prestamos', function (Blueprint $table) {
            $table->string('referencia_celular', 255)->nullable()->change();
        });
    }
};
