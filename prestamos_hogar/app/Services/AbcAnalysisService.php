<?php

namespace App\Services;

use App\Models\Usuario;
use App\Models\Prestamo;
use App\Models\Pago;

class AbcAnalysisService
{
    /**
     * Realiza el análisis ABC de clientes por rentabilidad
     * 
     * @return array
     */
    public function analizarClientes()
    {
        // Obtener todos los clientes con sus préstamos y pagos
        $clientes = Usuario::with(['prestamos.pagos'])->get();
        
        $clientesRentabilidad = [];
        
        foreach ($clientes as $cliente) {
            // Calcular ingresos generados por el cliente (suma de pagos)
            $ingresos = 0;
            foreach ($cliente->prestamos as $prestamo) {
                foreach ($prestamo->pagos as $pago) {
                    $ingresos += $pago->monto;
                }
            }
            
            // Calcular costos (monto de préstamos)
            $costos = $cliente->prestamos->sum('monto');
            
            // Calcular rentabilidad (ingresos - costos)
            $rentabilidad = $ingresos - $costos;
            
            $clientesRentabilidad[] = [
                'id' => $cliente->id,
                'nombre' => $cliente->nombre_completo,
                'rentabilidad' => $rentabilidad,
                'ingresos' => $ingresos,
                'costos' => $costos,
                'num_prestamos' => $cliente->prestamos->count()
            ];
        }
        
        // Ordenar por rentabilidad de mayor a menor
        usort($clientesRentabilidad, function ($a, $b) {
            return $b['rentabilidad'] <=> $a['rentabilidad'];
        });
        
        // Calcular rentabilidad total
        $rentabilidadTotal = array_sum(array_column($clientesRentabilidad, 'rentabilidad'));
        
        // Calcular porcentaje acumulado y asignar categoría
        $acumulado = 0;
        foreach ($clientesRentabilidad as &$cliente) {
            $porcentaje = ($rentabilidadTotal > 0) ? ($cliente['rentabilidad'] / $rentabilidadTotal) * 100 : 0;
            $acumulado += $porcentaje;
            
            if ($acumulado <= 80) {
                $cliente['categoria'] = 'A';
            } elseif ($acumulado <= 95) {
                $cliente['categoria'] = 'B';
            } else {
                $cliente['categoria'] = 'C';
            }
            
            $cliente['porcentaje'] = $porcentaje;
            $cliente['acumulado'] = $acumulado;
        }
        
        // Agrupar por categoría
        $categorias = [
            'A' => ['clientes' => [], 'rentabilidad' => 0, 'porcentaje' => 0],
            'B' => ['clientes' => [], 'rentabilidad' => 0, 'porcentaje' => 0],
            'C' => ['clientes' => [], 'rentabilidad' => 0, 'porcentaje' => 0]
        ];
        
        foreach ($clientesRentabilidad as $cliente) {
            $cat = $cliente['categoria'];
            $categorias[$cat]['clientes'][] = $cliente;
            $categorias[$cat]['rentabilidad'] += $cliente['rentabilidad'];
            $categorias[$cat]['porcentaje'] = ($rentabilidadTotal > 0) ? ($categorias[$cat]['rentabilidad'] / $rentabilidadTotal) * 100 : 0;
        }
        
        return [
            'clientes' => $clientesRentabilidad,
            'categorias' => $categorias,
            'rentabilidad_total' => $rentabilidadTotal
        ];
    }
}