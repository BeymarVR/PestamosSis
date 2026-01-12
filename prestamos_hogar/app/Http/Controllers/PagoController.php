<?php

namespace App\Http\Controllers;

use App\Models\{Pago, PlanPago, Capital, Mora};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Storage, Auth};
use Carbon\Carbon;
use App\Services\MoraService;

class PagoController extends Controller
{

      protected $moraService;

    public function __construct(MoraService $moraService)
    {
        $this->moraService = $moraService;
    }

    public function store(Request $request)
{
    $request->validate([
        'plan_pago_id' => 'required|exists:plan_pagos,id',
        'fecha_pago' => 'required|date',
        'monto' => 'required|numeric|min:0.01',
        'metodo_pago' => 'required|in:efectivo,transferencia,cheque,deposito,otro',
        'comprobante' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        'observaciones' => 'nullable|string|max:500'
    ]);

    try {
        // Cargamos el plan de pago
        $planPago = PlanPago::with(['prestamo', 'mora'])->findOrFail($request->plan_pago_id);

        // 🔥 AQUI ES DONDE INYECTAMOS EL SERVICIO DE MORA
        // Aplicamos mora actualizada automáticamente
        $mora = app(\App\Services\MoraService::class)->aplicarMora($planPago);

        $interesMora = $mora ? $mora->interes_mora : 0;

        // Guardar comprobante si existe
        $comprobantePath = null;
        if ($request->hasFile('comprobante')) {
            $comprobantePath = $request->file('comprobante')->store('comprobantes', 'public');
        }

        // Registrar el pago
        $pago = Pago::create([
            'plan_pago_id' => $planPago->id,
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'metodo_pago' => $request->metodo_pago,
            'comprobante' => $comprobantePath,
            'observaciones' => $request->observaciones,
            'usuario_registrador_id' => Auth::id()
        ]);
        // 🔔 Notificar que se registró el pago
        app(\App\Services\NotificacionService::class)->crear([
            'tipo' => 'pago',
            'mensaje' => "Pago de Bs {$request->monto} registrado para la cuota #{$planPago->numero_cuota} del préstamo {$planPago->prestamo->codigo}.",
            'plan_pago_id' => $planPago->id,
            'fecha_vencimiento' => $planPago->fecha_vencimiento
        ]);

        // Actualizar capital
        $capital = Capital::latest()->first();
        Capital::create([
            'monto_inicial' => $request->monto,
            'monto_actual' => $capital->monto_actual + $request->monto,
            'descripcion' => "Pago cuota #{$planPago->numero_cuota} - Préstamo {$planPago->prestamo->codigo}" . ($interesMora > 0 ? " (con mora)" : ""),
            'usuario_id' => Auth::id()
        ]);

        // Validar estado de la cuota (si ya quedó totalmente pagada)
        $totalPagado = $planPago->pagos()->sum('monto');
        $totalDeuda = $planPago->monto_cuota + $interesMora;

        if ($totalPagado >= $totalDeuda) {
            $planPago->update([
                'estado' => 'pagado',
                'fecha_pago' => $request->fecha_pago
            ]);

            if ($planPago->mora && $planPago->mora->estado === 'activa') {
                $planPago->mora->update(['estado' => 'inactiva']);
            }

            // Si todas las cuotas están pagadas → el préstamo se cancela
            $prestamo = $planPago->prestamo;
            $todasPagadas = $prestamo->planPagos()->where('estado', '!=', 'pagado')->doesntExist();
            if ($todasPagadas) {
                $prestamo->update(['estado' => 'cancelado']);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Pago registrado correctamente',
            'pago' => $pago
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al registrar el pago: ' . $e->getMessage()
        ], 500);
    }
}


    public function show($id)
    {
        $pago = Pago::with(['planPago.prestamo.usuario', 'usuarioRegistrador'])->findOrFail($id);
        return response()->json($pago);
    }

public function detalleCuota($id)
{
    $cuota = PlanPago::with('mora')->findOrFail($id);

    // Calculamos correctamente la mora si existe
    $mora = null;
    $interesMora = 0;

    if ($cuota->mora && $cuota->mora->estado === 'activa') {
        $mora = $cuota->mora;
        $interesMora = $mora->interes_mora;
    }

    return response()->json([
        'cuota_id' => $cuota->id,
        'monto_pendiente' => round($cuota->monto_cuota, 2),
        'interes_mora' => round($interesMora, 2),
        'total' => round($cuota->monto_cuota + $interesMora, 2),
        'estado' => $cuota->estado,
        'mora' => $mora
    ]);
}



}
