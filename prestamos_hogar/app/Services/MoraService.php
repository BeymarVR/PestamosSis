<?php

namespace App\Services;

use App\Models\Mora;
use Carbon\Carbon;

class MoraService
{
    public function aplicarMora($planPago)
{
    // Si ya tiene mora activa o está pagado, no hacemos nada
    if ($planPago->estado !== 'pendiente' || ($planPago->mora && $planPago->mora->estado === 'activa')) {
        return $planPago->mora;
    }

    // Calcular si han pasado más de 3 días desde el vencimiento
    $fechaVenc = Carbon::parse($planPago->fecha_vencimiento);
    $diasAtraso = intval($fechaVenc->diffInDays(now(), false));

    if ($diasAtraso > 3) {
        $interesMora = round($planPago->monto_cuota * 0.05, 2);

        $mora = Mora::create([
            'plan_pago_id' => $planPago->id,
            'interes_mora' => $interesMora,
            'estado' => 'activa',
            'dias_atraso' => $diasAtraso,
            'fecha_calculo' => now(),
        ]);

        // 🔄 CAMBIAR EL ESTADO DE LA CUOTA A 'mora'
        $planPago->update([
        'estado' => 'mora',
        ]);

        // 🛎️ Crear notificación
        app(\App\Services\NotificacionService::class)->crear([
            'tipo' => 'mora',
            'mensaje' => "La cuota #{$planPago->numero_cuota} del préstamo {$planPago->prestamo->codigo} ha entrado en mora.",
            'plan_pago_id' => $planPago->id,
            'fecha_vencimiento' => $planPago->fecha_vencimiento,
        ]);

        return $mora;
    }

    return null;
}


    public function aplicarMorasMasivas($planPagos)
    {
        foreach ($planPagos as $cuota) {
            $this->aplicarMora($cuota);
        }
    }
}
