<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ForecastService;
use App\Services\InventoryService;
use App\Services\OptimizationService;
use App\Services\AbcAnalysisService;

class DashboardController extends Controller
{
    protected $forecastService;
    protected $inventoryService;
    protected $optimizationService;
    protected $abcAnalysisService;

    public function __construct(
        ForecastService $forecastService,
        InventoryService $inventoryService,
        OptimizationService $optimizationService,
        AbcAnalysisService $abcAnalysisService
    ) {
        $this->forecastService = $forecastService;
        $this->inventoryService = $inventoryService;
        $this->optimizationService = $optimizationService;
        $this->abcAnalysisService = $abcAnalysisService;
    }

    /**
     * Muestra el dashboard administrativo
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Datos para los gráficos existentes
        $capital = \App\Models\Capital::latest()->first();
        $prestamosActivos = \App\Models\Prestamo::where('estado', 'vigente')->sum('monto');
        $porcentajeUsado = $prestamosActivos > 0 ? ($prestamosActivos / ($capital->monto_actual + $prestamosActivos)) * 100 : 0;

        // Datos para los nuevos gráficos
        
        // 1. Pronóstico de solicitudes con suavización exponencial
        $pronostico = $this->forecastService->pronosticarSolicitudes(3, 0.3);
        
        // 2. Modelo EOQ para capital
        $datosEOQ = $this->inventoryService->obtenerDatosEOQ();
        
        // 3. Asignación óptima de capital
        $asignacionOptima = $this->optimizationService->asignacionOptimaCapital();
        
        // 4. Análisis ABC de clientes
        $analisisABC = $this->abcAnalysisService->analizarClientes();
        
        // Top 5 deudores (ya existe en la vista)
        $topDeudores = \App\Models\Usuario::with(['prestamos.planPagos' => function ($q) {
            $q->whereIn('estado', ['pendiente', 'mora']);
        }])->get()->map(function ($usuario) {
            $deuda = 0;
            foreach ($usuario->prestamos as $prestamo) {
                foreach ($prestamo->planPagos as $cuota) {
                    $deuda += $cuota->monto_cuota;
                }
            }
            return [
                'nombre' => $usuario->nombre_completo,
                'deuda_total' => round($deuda, 2),
            ];
        })->sortByDesc('deuda_total')->take(5);

        // Datos para gráficos existentes
        $pagados = \App\Models\PlanPago::where('estado', 'pagado')->count();
        $pendientes = \App\Models\PlanPago::where('estado', 'pendiente')->count();
        $enMora = \App\Models\PlanPago::where('estado', 'mora')->count();
        
        $meses = collect();
        $conteos = collect();
        for ($i = 5; $i >= 0; $i--) {
            $fecha = \Illuminate\Support\Carbon::now()->subMonths($i);
            $mes = $fecha->format('M Y');
            $count = \App\Models\Prestamo::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
            $meses->push($mes);
            $conteos->push($count);
        }

        return view('dashboard', compact(
            'capital',
            'prestamosActivos',
            'porcentajeUsado',
            'pronostico',
            'datosEOQ',
            'asignacionOptima',
            'analisisABC',
            'topDeudores',
            'pagados',
            'pendientes',
            'enMora',
            'meses',
            'conteos'
        ));
    }
}