<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Carbon\Carbon;

class ScoreFlaskController extends Controller
{
    public function mostrarScore($id)
    {
        $usuario = Usuario::findOrFail($id);
        $prestamos = $usuario->prestamos()->with('planPagos.pagos', 'planPagos.mora')->get();

        $totalCuotas = 0;
        $cuotasATiempo = 0;
        $cantidadMoras = 0;

        foreach ($prestamos as $prestamo) {
            foreach ($prestamo->planPagos as $cuota) {
                $totalCuotas++;
                $fechaPago = optional($cuota->pagos->first())->fecha_pago;
                if ($fechaPago && $fechaPago <= $cuota->fecha_vencimiento) {
                    $cuotasATiempo++;
                }
                if ($cuota->mora) {
                    $cantidadMoras++;
                }
            }
        }

        $porcentaje = $totalCuotas > 0 ? ($cuotasATiempo / $totalCuotas) * 100 : 0;

        // ✅ Obtener antigüedad desde fecha_primer_prestamo o primer préstamo real
        if ($usuario->fecha_primer_prestamo) {
            $fechaBase = Carbon::parse($usuario->fecha_primer_prestamo);
        } else {
            $primerPrestamo = $usuario->prestamos()->orderBy('created_at')->first();
            $fechaBase = $primerPrestamo?->created_at ?? $usuario->created_at;
        }

        $antiguedadDias = $fechaBase ? $fechaBase->diffInDays(now()) : 0;

        $cantidadPrestamos = $usuario->prestamos()->count();
        $montoPromedio = $usuario->prestamos()->avg('monto') ?? 0;

        $scoreIA = null;
        $error_api = null;

        try {
    $response = Http::timeout(3)->post('http://127.0.0.1:5000/predict', [
        'porcentaje_pagos_a_tiempo' => round($porcentaje, 2),
        'cantidad_moras' => $cantidadMoras,
        'antiguedad_dias' => $antiguedadDias,
        'prestamos_previos' => $cantidadPrestamos,
        'monto_promedio' => round($montoPromedio, 2),
    ]);

    if ($response->successful()) {
        $data = $response->json();
        $scoreIA = $data['score_crediticio'] ?? null;
        $nivel = $data['nivel'] ?? null;
        $recomendaciones = $data['recomendaciones'] ?? [];
    } else {
        $error_api = '⚠️ La API respondió con un error inesperado.';
    }

} catch (ConnectionException $e) {
    $error_api = '⚠️ No se pudo conectar con la API de scoring. Intenta más tarde.';
}


        return view('admin.usuarios.score-ia', compact(
    'usuario',
    'porcentaje',
    'cantidadMoras',
    'antiguedadDias',
    'cantidadPrestamos',
    'montoPromedio',
    'scoreIA',
    'nivel',
    'recomendaciones',
    'error_api'
));

    }
}