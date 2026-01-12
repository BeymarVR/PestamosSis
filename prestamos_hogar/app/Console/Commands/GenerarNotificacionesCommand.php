<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PlanPago;
use App\Models\Notificacion;
use Carbon\Carbon;

class GenerarNotificacionesCommand extends Command
{
    protected $signature = 'notificaciones:generar';
    protected $description = 'Genera notificaciones para pagos próximos y atrasados';

    public function handle()
    {
        // 1. Notificar pagos próximos (5 días antes)
        PlanPago::where('estado', 'pendiente')
            ->whereDate('fecha_vencimiento', Carbon::today()->addDays(5))
            ->each(function ($cuota) {
                Notificacion::firstOrCreate([
                    'usuario_id' => $cuota->prestamo->usuario_id,
                    'plan_pago_id' => $cuota->id,
                    'tipo' => 'pago_proximo'
                ], [
                    'mensaje' => "📅 Próximo pago: Cuota #{$cuota->numero_cuota} de Bs {$cuota->monto_cuota} vence el {$cuota->fecha_vencimiento->format('d/m/Y')}",
                    'fecha_vencimiento' => $cuota->fecha_vencimiento
                ]);
            });

        // 2. Notificar pagos atrasados (después de vencimiento)
        PlanPago::where('estado', 'pendiente')
            ->whereDate('fecha_vencimiento', '<', Carbon::today())
            ->each(function ($cuota) {
                $diasAtraso = Carbon::today()->diffInDays($cuota->fecha_vencimiento);
                
                Notificacion::firstOrCreate([
                    'usuario_id' => $cuota->prestamo->usuario_id,
                    'plan_pago_id' => $cuota->id,
                    'tipo' => 'pago_atrasado'
                ], [
                    'mensaje' => "⚠️ Pago atrasado: Cuota #{$cuota->numero_cuota} de Bs {$cuota->monto_cuota} ({$diasAtraso} días de retraso)",
                    'fecha_vencimiento' => $cuota->fecha_vencimiento
                ]);
            });

        // 3. Notificar moras (3 días después de vencimiento)
        PlanPago::where('estado', 'pendiente')
            ->whereDate('fecha_vencimiento', '<=', Carbon::today()->subDays(3))
            ->each(function ($cuota) {
                $diasMora = Carbon::today()->diffInDays($cuota->fecha_vencimiento);
                $mora = $cuota->monto_cuota * (0.60 / 365) * $diasMora;
                
                Notificacion::firstOrCreate([
                    'usuario_id' => $cuota->prestamo->usuario_id,
                    'plan_pago_id' => $cuota->id,
                    'tipo' => 'mora'
                ], [
                    'mensaje' => "🔴 Mora aplicada: Cuota #{$cuota->numero_cuota} - Bs {$mora} por {$diasMora} días de atraso",
                    'fecha_vencimiento' => $cuota->fecha_vencimiento
                ]);
            });

        $this->info('✅ Notificaciones generadas: ' . now());
    }
}