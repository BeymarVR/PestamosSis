<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;


class ExportScoringDataset extends Command
{
    protected $signature = 'export:scoring-dataset';
    protected $description = 'Exporta el dataset de scoring crediticio como CSV';

    public function handle()
    {
        $csvPath = storage_path('app/public/scoring_dataset.csv');
        $handle = fopen($csvPath, 'w');

        // Encabezados del CSV
        fputcsv($handle, [
            'usuario_id',
            'porcentaje_pagos_a_tiempo',
            'cantidad_moras',
            'antiguedad_dias',
            'prestamos_previos',
            'monto_promedio',
            'score_crediticio'
        ]);

        $usuarios = Usuario::all();

        foreach ($usuarios as $usuario) {
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

    // Calcular antigüedad
    try {
        $fechaBase = $usuario->fecha_primer_prestamo ?? (
            $usuario->prestamos()->orderBy('created_at')->first()?->created_at ?? $usuario->created_at
        );
        $createdAt = $fechaBase instanceof \Carbon\Carbon ? $fechaBase : Carbon::parse($fechaBase);
        $antiguedad = $createdAt->diffInDays(now());
    } catch (\Exception $e) {
        $antiguedad = 0;
    }

    $montoPromedio = $usuario->prestamos()->avg('monto');
    $cantidadPrestamos = $usuario->prestamos()->count();

    // ✅ Llamar a la API solo después de calcular todo
    try {
        $response = Http::timeout(3)->post('http://127.0.0.1:5000/predict', [
            'porcentaje_pagos_a_tiempo' => round($porcentaje, 2),
            'cantidad_moras' => $cantidadMoras,
            'antiguedad_dias' => $antiguedad,
            'prestamos_previos' => $cantidadPrestamos,
            'monto_promedio' => round($montoPromedio ?? 0, 2),
        ]);

        $score = $response->successful()
            ? $response->json()['score_crediticio'] ?? 0
            : 0;
    } catch (\Exception $e) {
        $score = 0;
    }

    // Exportar al CSV
    fputcsv($handle, [
        $usuario->id,
        round($porcentaje, 2),
        (int) $cantidadMoras,
        (int) $antiguedad,
        (int) $cantidadPrestamos,
        round($montoPromedio ?? 0, 2),
        (int) $score,
    ]);
}


        fclose($handle);

        $this->info("✅ Dataset exportado: storage/app/public/scoring_dataset.csv");
    }
}
