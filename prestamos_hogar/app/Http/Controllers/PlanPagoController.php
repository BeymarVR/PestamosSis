<?php

namespace App\Http\Controllers;

use App\Models\PlanPago;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlanPagoController extends Controller
{
    public function getMontoCuota($id)
    {
        $planPago = PlanPago::findOrFail($id);
        return response()->json([
            'monto_cuota' => $planPago->monto_cuota,
            'fecha_vencimiento' => $planPago->fecha_vencimiento->format('d/m/Y')
        ]);
    }

    public function registrarPago(Request $request)
    {
        $request->validate([
            'plan_pago_id' => 'required|exists:plan_pagos,id',
            'fecha_pago' => 'required|date',
            'monto_pagado' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string'
        ]);

        $planPago = PlanPago::findOrFail($request->plan_pago_id);
        
        // Verificar si el pago es tardío (3 días después del vencimiento)
        $fechaVencimiento = Carbon::parse($planPago->fecha_vencimiento);
        $fechaPago = Carbon::parse($request->fecha_pago);
        
        $diasMora = $fechaVencimiento->diffInDays($fechaPago, false);
        $mora = 0;
        
        if ($diasMora > 3) {
            // Calcular mora (60% anual, 5% mensual)
            $tasaMoraDiaria = 0.60 / 365; // 60% anual
            $mora = $planPago->monto_cuota * $tasaMoraDiaria * $diasMora;
        }

            $planPago->update([
                'fecha_pago' => $request->fecha_pago,
                'monto_pagado' => $request->monto_pagado,
                'mora' => $mora,
                'estado' => 'pagado',
                'observaciones' => $request->observaciones
            ]);

            // ✅ Desactivar la mora si existe y está activa
            if ($planPago->mora && $planPago->mora->estado === 'activa') {
                $planPago->mora->update([
                    'estado' => 'inactiva',
                    'updated_at' => now()
                ]);
            }

        return response()->json([
            'success' => true,
            'message' => 'Pago registrado correctamente'
        ]);
    }

    public function aplicarMora(Request $request)
    {
        $request->validate([
            'plan_pago_id' => 'required|exists:plan_pagos,id',
            'porcentaje_mora' => 'required|numeric|min:0|max:100',
            'justificacion' => 'nullable|string'
        ]);

        $planPago = PlanPago::findOrFail($request->plan_pago_id);
        
        $fechaVencimiento = Carbon::parse($planPago->fecha_vencimiento);
        $diasMora = $fechaVencimiento->diffInDays(now(), false);
        
        if ($diasMora > 3) {
            $tasaMoraDiaria = ($request->porcentaje_mora / 100) / 365;
            $mora = $planPago->monto_cuota * $tasaMoraDiaria * $diasMora;
            
            $planPago->update([
                'mora' => $mora,
                'estado' => 'mora',
                'observaciones' => $request->justificacion
            ]);
            
            return response()->json(['success' => true, 'mora' => $mora]);
        }

        return response()->json(['success' => false, 'message' => 'No se puede aplicar mora antes de 3 días de atraso']);
    }
}