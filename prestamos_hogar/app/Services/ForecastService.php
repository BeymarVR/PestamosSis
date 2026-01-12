<?php

namespace App\Services;

use App\Models\Prestamo;
use Illuminate\Support\Carbon;

class ForecastService
{
    /**
     * Calcula el pronóstico de solicitudes usando suavización exponencial
     * 
     * @param int $periodos Número de periodos a pronosticar
     * @param float $alpha Factor de suavización (0-1)
     * @return array
     */
    public function pronosticarSolicitudes($periodos = 3, $alpha = 0.3)
    {
        // Obtener datos históricos de los últimos 12 meses
        $historico = [];
        for ($i = 11; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $count = Prestamo::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
            $historico[] = [
                'mes' => $fecha->format('M Y'),
                'valor' => $count
            ];
        }

        // Calcular pronóstico con suavización exponencial
        $pronostico = [];
        $S = $historico[0]['valor']; // Inicializar con el primer valor

        // Calcular suavización para datos históricos
        foreach ($historico as $index => $dato) {
            if ($index > 0) {
                $S = $alpha * $dato['valor'] + (1 - $alpha) * $S;
            }
        }

        // Generar pronóstico para los próximos meses
        for ($i = 1; $i <= $periodos; $i++) {
            $fecha = Carbon::now()->addMonths($i);
            $pronostico[] = [
                'mes' => $fecha->format('M Y'),
                'valor' => round($S)
            ];
        }

        // Calcular intervalos de confianza (simplificado)
        $confianza_superior = [];
        $confianza_inferior = [];
        foreach ($pronostico as $p) {
            $confianza_superior[] = $p['valor'] + 10; // Simplificado
            $confianza_inferior[] = max(0, $p['valor'] - 10); // Simplificado
        }

        return [
            'historico' => $historico,
            'pronostico' => $pronostico,
            'confianza_superior' => $confianza_superior,
            'confianza_inferior' => $confianza_inferior
        ];
    }
}