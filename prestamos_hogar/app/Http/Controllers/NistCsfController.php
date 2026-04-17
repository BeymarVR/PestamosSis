<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\LogActividad;
use App\Models\Prestamo;
use App\Models\Notificacion;
use App\Models\PlanPago;

class NistCsfController extends Controller
{
    public function index()
    {
        // Govern (GV): Roles definidos y métricas de control
        $adminCount = Usuario::whereHas('rol', function($q) { $q->where('nombre', 'admin'); })->count();
        $gestorCount = Usuario::whereHas('rol', function($q) { $q->where('nombre', 'gestor'); })->count();

        // Identify (ID): Manejo de activos y exposición (evitamos n+1 en el score)
        $clientesActivos = Usuario::whereHas('rol', function($q) { $q->where('nombre', 'usuario'); })->count();
        $riesgoAlto = Usuario::with(['prestamos.planPagos.pagos', 'prestamos.planPagos.mora', 'rol'])->get()->filter(function($u) {
            return $u->rol && $u->rol->nombre === 'usuario' && $u->calcularScoreCrediticio() < 60; 
        })->count();

        // Protect (PR): Autenticación y cifrado (estadísticas generales)
        $sesionesActivas = LogActividad::where('accion', 'login')->where('created_at', '>=', now()->subDay())->count();

        // Detect (DE): Eventos anómalos o registrados
        $logsRecientes = LogActividad::where('created_at', '>=', now()->subDays(7))->count();
        $alertasMora = PlanPago::where('estado', 'mora')->count();

        // Respond (RS): Acciones y notificaciones activas
        $notificacionesPendientes = Notificacion::where('leida', false)->count();

        // Recover (RC): Recuperación financiera tras una anomalía o pago rutinario
        $pagosRecientes = PlanPago::where('estado', 'pagado')
            ->where('updated_at', '>=', now()->subDays(30))
            ->sum('monto_cuota');

        $stats = [
            'gv' => ['admins' => $adminCount, 'gestores' => $gestorCount],
            'id' => ['clientes' => $clientesActivos, 'riesgo_alto' => $riesgoAlto],
            'pr' => ['sesiones_24h' => $sesionesActivas],
            'de' => ['logs_7d' => $logsRecientes, 'alertas_mora' => $alertasMora],
            'rs' => ['notis_pendientes' => $notificacionesPendientes],
            'rc' => ['recuperado_30d' => $pagosRecientes],
        ];

        return view('admin.nist.index', compact('stats'));
    }
}
