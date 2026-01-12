<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Usuario;
use App\Models\PlanPago;
use App\Models\Capital;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Mora;
use App\Services\MoraService;
use App\Models\SolicitudCredito;

class PrestamoController extends Controller
{

    protected $moraService;

    public function __construct(MoraService $moraService)
    {
        $this->moraService = $moraService;
    }

 public function index(Request $request)
{
    $query = Prestamo::with('usuario')->latest();
    if ($request->filled('usuario_id')) {
        $query->where('usuario_id', $request->usuario_id);
    }
    // Filtro por nombre del usuario
    if ($request->filled('buscar')) {
        $query->whereHas('usuario', function ($q) use ($request) {
            $q->where('nombre_completo', 'ILIKE', '%' . $request->buscar . '%');
        });
    }

    // Filtro por estado
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    // Orden por monto
    if ($request->orden === 'asc') {
        $query->orderBy('monto', 'asc');
    } elseif ($request->orden === 'desc') {
        $query->orderBy('monto', 'desc');
    } else {
        $query->latest(); // orden por fecha por defecto
    }

    $prestamos = $query->paginate(10);

    return view('admin.prestamos.index', compact('prestamos'));
}

public function create(Request $request)
{
    $usuarios = Usuario::all();
    $capitalDisponible = Capital::latest()->first()->monto_actual ?? 0;
    
    // Si viene de una solicitud, precargar datos
    $solicitud = null;
    $usuarioSeleccionado = null;
    $montoPrecargado = null;
    
    if ($request->has('solicitud_id')) {
        $solicitud = SolicitudCredito::with('usuario')->find($request->solicitud_id);
        if ($solicitud && $solicitud->estaAprobada() && !$solicitud->tienePrestamo()) {
            $usuarioSeleccionado = $solicitud->usuario;
            $montoPrecargado = $solicitud->monto_solicitado;
        }
    } elseif ($request->has('usuario_id')) {
        $usuarioSeleccionado = Usuario::find($request->usuario_id);
    }
    
    return view('admin.prestamos.create', compact(
        'usuarios', 
        'capitalDisponible',
        'solicitud',
        'usuarioSeleccionado',
        'montoPrecargado'
    ));
}

    public function edit($id)
    {
        $prestamo = Prestamo::with('usuario')->findOrFail($id);
        $usuarios = Usuario::all();
        return view('admin.prestamos.edit', compact('prestamo', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'monto' => 'required|numeric|min:1',
            'tasa_interes_mensual' => 'required|numeric|min:0',
            'plazo_meses' => 'required|integer|min:1|max:3',
            'frecuencia_pago' => 'required|in:diario,semanal,quincenal,mensual',
            'fecha_desembolso' => 'required|date',
            'referencia_celular' => 'nullable|string|max:20',
            'estado' => 'required|in:vigente,cancelado,mora'
        ]);

        $prestamo = Prestamo::findOrFail($id);

        // Validar si hay pagos registrados
        $cuotasConPagos = $prestamo->planPagos()->whereHas('pagos')->exists();

        if ($cuotasConPagos) {
            return back()->with('🔴', 'Este préstamo ya tiene pagos registrados, por lo tanto no se puede modificar el plan de pagos.');
        }

        // Si se cambió el monto, ajustar el capital
        if ($prestamo->monto != $request->monto) {
            $diferencia = $request->monto - $prestamo->monto;
            $capital = Capital::latest()->first();

            if ($diferencia > 0 && $capital->monto_actual < $diferencia) {
                return back()->with('error', 'No hay suficiente capital para aumentar el monto del préstamo.');
            }

            Capital::create([
                'monto_inicial' => -$diferencia,
                'monto_actual' => $capital->monto_actual - $diferencia,
                'descripcion' => 'Ajuste de capital por edición del préstamo ID: ' . $prestamo->id,
                'usuario_id' => Auth::id()
            ]);
        }

        $prestamo->update($request->all());

        // Eliminar cuotas anteriores y generar nuevas
        $prestamo->planPagos()->delete();
        $this->generarPlanPagos($prestamo);

        return redirect()->route('admin.prestamos.index')->with('success', 'Préstamo actualizado y plan de pagos regenerado.');
    }

public function store(Request $request)
{
    $request->validate([
        'usuario_id' => 'required|exists:usuarios,id',
        'monto' => 'required|numeric|min:1',
        'tasa_interes_mensual' => 'required|numeric|min:0',
        'plazo_meses' => 'required|integer|min:1|max:3',
        'frecuencia_pago' => 'required|in:diario,semanal,quincenal,mensual',
        'fecha_desembolso' => 'required|date',
        'referencia_celular' => 'nullable|string|max:20',
        'solicitud_id' => 'nullable|exists:solicitud_creditos,id',
    ]);

    $capital = Capital::latest()->first();
    $montoPrestamo = $request->monto;

    if (!$capital || $capital->monto_actual < $montoPrestamo) {
        return back()->with('error', 'No hay suficiente capital disponible para este préstamo');
    }

    // Verificar si el usuario tiene solicitud aprobada (solo si no viene de solicitud)
    if (!$request->has('solicitud_id')) {
        $solicitudAprobada = SolicitudCredito::where('usuario_id', $request->usuario_id)
            ->where('estado', 'aprobada')
            ->whereNull('prestamo_id')
            ->first();
        
        if (!$solicitudAprobada) {
            return back()->with('error', 'El cliente debe tener una solicitud de crédito APROBADA antes de crear un préstamo.');
        }
        
        $solicitudId = $solicitudAprobada->id;
    } else {
        $solicitudId = $request->solicitud_id;
    }

    $prestamo = Prestamo::create([
        'codigo' => 'PRE-' . Str::upper(Str::random(6)),
        'usuario_id' => $request->usuario_id,
        'monto' => $montoPrestamo,
        'tasa_interes_mensual' => $request->tasa_interes_mensual,
        'plazo_meses' => $request->plazo_meses,
        'frecuencia_pago' => $request->frecuencia_pago,
        'fecha_desembolso' => $request->fecha_desembolso,
        'estado' => 'vigente',
        'referencia_celular' => $request->referencia_celular,
    ]);

    // Vincular préstamo con solicitud
    if ($solicitudId) {
        $solicitud = SolicitudCredito::find($solicitudId);
        if ($solicitud) {
            $solicitud->update([
                'prestamo_id' => $prestamo->id,
                'fecha_firma_contrato' => now()
            ]);
        }
    }

    Capital::create([
        'monto_inicial' => -$montoPrestamo,
        'monto_actual' => $capital->monto_actual - $montoPrestamo,
        'descripcion' => "Préstamo a " . $prestamo->usuario->nombre_completo . " (ID: $prestamo->id)",
        'usuario_id' => Auth::id()
    ]);

    // Actualizar fecha primer préstamo
    $usuario = $prestamo->usuario;
    if (!$usuario->fecha_primer_prestamo) {
        $usuario->fecha_primer_prestamo = $prestamo->fecha_desembolso ?? now();
        $usuario->save();
    }

    $this->generarPlanPagos($prestamo);

    return redirect()->route('admin.prestamos.index')->with('success', 'Préstamo registrado correctamente con plan de pagos generado.');
}

    public function cancelar($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        if ($prestamo->estado == 'vigente') {
            $capital = Capital::latest()->first();

            Capital::create([
                'monto_inicial' => $prestamo->monto,
                'monto_actual' => $capital->monto_actual + $prestamo->monto,
                'descripcion' => "Cancelación préstamo ID: $prestamo->id",
                'usuario_id' => Auth::id()
            ]);
        }

        $prestamo->update(['estado' => 'cancelado']);

        return back()->with('success', 'Préstamo cancelado y capital reintegrado');
    }

    private function generarPlanPagos($prestamo)
    {
        PlanPago::where('prestamo_id', $prestamo->id)->delete();

        $monto = $prestamo->monto;
        $tasaInteres = $prestamo->tasa_interes_mensual / 100;
        $plazo = $prestamo->plazo_meses;
        $fechaInicio = Carbon::parse($prestamo->fecha_desembolso);

        switch($prestamo->frecuencia_pago) {
            case 'diario':
                $numCuotas = $plazo * 30;
                $intervalo = '1 day';
                break;
            case 'semanal':
                $numCuotas = $plazo * 4;
                $intervalo = '1 week';
                break;
            case 'quincenal':
                $numCuotas = $plazo * 2;
                $intervalo = '15 days';
                break;
            case 'mensual':
                $numCuotas = $plazo;
                $intervalo = '1 month';
                break;
        }

        $tasaPeriodo = $tasaInteres / ($numCuotas / $plazo);
        $cuota = $monto * ($tasaPeriodo * pow(1 + $tasaPeriodo, $numCuotas)) / (pow(1 + $tasaPeriodo, $numCuotas) - 1);

        $saldo = $monto;
        $fechaPago = $fechaInicio->copy();

        for ($i = 1; $i <= $numCuotas; $i++) {
            $fechaPago->add($intervalo);

            $interes = $saldo * $tasaPeriodo;
            $capital = $cuota - $interes;
            $saldo -= $capital;

            PlanPago::create([
                'prestamo_id' => $prestamo->id,
                'numero_cuota' => $i,
                'fecha_vencimiento' => $fechaPago->format('Y-m-d'),
                'monto_cuota' => $cuota,
                'capital' => $capital,
                'interes' => $interes,
                'saldo' => max($saldo, 0),
                'estado' => 'pendiente'
            ]);
        }
    }

public function showPlanPagos($id)
{
    $prestamo = Prestamo::with(['usuario', 'planPagos.mora'])->findOrFail($id);

    $this->moraService->aplicarMorasMasivas($prestamo->planPagos);

 // ✅ Verifica si alguna cuota está en mora
    $tieneMoras = $prestamo->planPagos->contains(function ($cuota) {
        return $cuota->mora && $cuota->mora->estado === 'activa';
    });

    if ($tieneMoras && $prestamo->estado !== 'mora') {
        $prestamo->estado = 'mora';
        $prestamo->save();
    }

    return view('admin.prestamos.plan-pagos', compact('prestamo'));
}


public function show($id)
{
    $prestamo = Prestamo::with(['usuario', 'planPagos.pagos', 'planPagos.mora'])->findOrFail($id);
    return view('admin.prestamos.show', compact('prestamo'));
}


    public function generarPlanPagosPDF($id)
    {
        $prestamo = Prestamo::with(['usuario', 'planPagos'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.prestamos.pdf.plan-pagos', compact('prestamo'));
        return $pdf->download("plan-pagos-{$prestamo->codigo}.pdf");
    }

    public function generarContratoPDF($id)
    {
        $prestamo = Prestamo::with('usuario')->findOrFail($id);
        $prestamista = Auth::user();
        $pdf = Pdf::loadView('admin.contratos.contrato-pdf', compact('prestamo', 'prestamista'));
        return $pdf->download("contrato-prestamo-{$prestamo->codigo}.pdf");
    }

    public function destroy($id)
{
    $prestamo = Prestamo::with('pagos')->findOrFail($id);

    // Validar si ya tiene pagos
    if ($prestamo->planPagos()->has('pagos')->exists()) {
        return back()->with('error', 'No se puede eliminar un préstamo que ya tiene pagos registrados.');
    }

    // Reintegrar capital si estaba vigente
    if ($prestamo->estado == 'vigente') {
        $capital = \App\Models\Capital::latest()->first();
        \App\Models\Capital::create([
            'monto_inicial' => $prestamo->monto,
            'monto_actual' => $capital->monto_actual + $prestamo->monto,
            'descripcion' => "Reintegro por eliminación del préstamo ID: $prestamo->id",
            'usuario_id' => Auth::id()
        ]);
    }

    // Eliminar el préstamo y plan de pagos en cascada
    $prestamo->delete();

    return redirect()->route('admin.prestamos.index')
        ->with('success', 'Préstamo eliminado correctamente.');
}


}
