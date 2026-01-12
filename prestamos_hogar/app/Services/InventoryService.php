<?php

namespace App\Services;

use App\Models\Capital;
use App\Models\Prestamo;

class InventoryService
{
    /**
     * Calcula la cantidad económica de pedido (EOQ) para el capital
     * 
     * @param float $demandaAnual Demanda anual de capital
     * @param float $costoOrdenar Costo de ordenar (fijo por cada inyección de capital)
     * @param float $costoMantener Costo de mantener capital como porcentaje del valor
     * @return array
     */
    public function calcularEOQ($demandaAnual, $costoOrdenar, $costoMantenerPorcentaje)
    {
        // EOQ = sqrt(2 * D * S / H)
        // D: demanda anual
        // S: costo de ordenar
        // H: costo de mantener por unidad por año
        $H = $costoMantenerPorcentaje; // Ya que es un porcentaje del valor
        
        $eoq = sqrt((2 * $demandaAnual * $costoOrdenar) / $H);
        
        return [
            'eoq' => round($eoq, 2),
            'demanda_anual' => $demandaAnual,
            'costo_ordenar' => $costoOrdenar,
            'costo_mantener' => $costoMantenerPorcentaje
        ];
    }
    
    /**
     * Calcula el punto de reorden (ROP) para el capital
     * 
     * @param float $demandaDiaria Demanda diaria promedio de capital
     * @param int $leadTime Tiempo de entrega en días para inyectar capital
     * @param float $inventarioSeguridad Inventario de seguridad
     * @return float
     */
    public function calcularROP($demandaDiaria, $leadTime, $inventarioSeguridad)
    {
        return ($demandaDiaria * $leadTime) + $inventarioSeguridad;
    }
    
    /**
     * Obtiene los datos necesarios para el modelo EOQ
     * 
     * @return array
     */
    public function obtenerDatosEOQ()
    {
        // Valores por defecto (podrían configurarse en la base de datos)
        $costoOrdenar = 1000; // Costo fijo por cada inyección de capital
        $costoMantenerPorcentaje = 0.15; // 15% anual del valor del capital
        
        // Calcular demanda anual (suma de préstamos del último año)
        $haceUnAno = now()->subYear();
        $demandaAnual = Prestamo::where('created_at', '>=', $haceUnAno)->sum('monto');
        
        // Calcular demanda diaria promedio
        $diasOperacion = 365; // Asumimos operación todos los días
        $demandaDiaria = $demandaAnual / $diasOperacion;
        
        // Lead time en días (tiempo para inyectar capital)
        $leadTime = 7; // 7 días
        
        // Inventario de seguridad (10% de la demanda durante lead time)
        $inventarioSeguridad = $demandaDiaria * $leadTime * 0.1;
        
        // Calcular EOQ
        $eoq = $this->calcularEOQ($demandaAnual, $costoOrdenar, $costoMantenerPorcentaje);
        
        // Calcular ROP
        $rop = $this->calcularROP($demandaDiaria, $leadTime, $inventarioSeguridad);
        
        // Capital actual
        $capitalActual = Capital::latest()->first()->monto_actual ?? 0;
        
        return [
            'eoq' => $eoq,
            'rop' => $rop,
            'capital_actual' => $capitalActual,
            'demanda_anual' => $demandaAnual,
            'demanda_diaria' => $demandaDiaria,
            'lead_time' => $leadTime,
            'inventario_seguridad' => $inventarioSeguridad
        ];
    }
}