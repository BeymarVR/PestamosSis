<?php

namespace App\Services;

use App\Models\Capital;

class OptimizationService
{
    /**
     * Calcula la asignación óptima de capital entre segmentos de riesgo
     * 
     * @return array
     */
    public function asignacionOptimaCapital()
    {
        // Obtener capital total disponible
        $capitalTotal = Capital::latest()->first()->monto_actual ?? 0;
        
        // Definir segmentos de riesgo con sus rentabilidades esperadas y límites
        $segmentos = [
            'bajo_riesgo' => [
                'rentabilidad' => 0.15, // 15% anual
                'limite_min' => 0.3, // Mínimo 30% del capital
                'limite_max' => 0.6, // Máximo 60% del capital
                'asignacion' => 0
            ],
            'medio_riesgo' => [
                'rentabilidad' => 0.25, // 25% anual
                'limite_min' => 0.2, // Mínimo 20% del capital
                'limite_max' => 0.5, // Máximo 50% del capital
                'asignacion' => 0
            ],
            'alto_riesgo' => [
                'rentabilidad' => 0.40, // 40% anual
                'limite_min' => 0.1, // Mínimo 10% del capital
                'limite_max' => 0.3, // Máximo 30% del capital
                'asignacion' => 0
            ]
        ];
        
        // Asignación inicial: proporcional a la rentabilidad esperada
        $totalRentabilidad = array_sum(array_column($segmentos, 'rentabilidad'));
        
        foreach ($segmentos as $nombre => $segmento) {
            $segmentos[$nombre]['asignacion'] = $capitalTotal * ($segmento['rentabilidad'] / $totalRentabilidad);
        }
        
        // Ajustar para cumplir con los límites (algoritmo simplificado)
        foreach ($segmentos as $nombre => $segmento) {
            $minimo = $capitalTotal * $segmento['limite_min'];
            $maximo = $capitalTotal * $segmento['limite_max'];
            
            if ($segmento['asignacion'] < $minimo) {
                $segmentos[$nombre]['asignacion'] = $minimo;
            } elseif ($segmento['asignacion'] > $maximo) {
                $segmentos[$nombre]['asignacion'] = $maximo;
            }
        }
        
        // Calcular rentabilidad esperada total
        $rentabilidadTotal = 0;
        foreach ($segmentos as $nombre => $segmento) {
            $rentabilidadTotal += $segmento['asignacion'] * $segmento['rentabilidad'];
        }
        
        return [
            'segmentos' => $segmentos,
            'capital_total' => $capitalTotal,
            'rentabilidad_esperada' => $rentabilidadTotal,
            'roi' => ($capitalTotal > 0) ? ($rentabilidadTotal / $capitalTotal) * 100 : 0
        ];
    }
}