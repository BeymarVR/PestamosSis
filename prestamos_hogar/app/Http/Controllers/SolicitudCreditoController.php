<?php

namespace App\Http\Controllers;

use App\Models\SolicitudCredito;
use App\Models\Usuario;
use App\Models\DeudaSolicitud;
use App\Models\ArchivoSolicitud;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SolicitudCreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $user = $request->user();
    
    if ($user->rol->nombre === 'admin' || $user->rol->nombre === 'gestor') {
        // Admin/Gestor ven todas las solicitudes
        $query = SolicitudCredito::with('usuario');
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        
        if ($request->filled('buscar')) {
            $query->whereHas('usuario', function($q) use ($request) {
                $q->where('nombre_completo', 'ILIKE', '%' . $request->buscar . '%')
                  ->orWhere('ci', 'ILIKE', '%' . $request->buscar . '%');
            });
        }
        
        $solicitudes = $query->latest()->paginate(10);
        
        $ruta = $user->rol->nombre === 'admin' ? 'admin' : 'gestor';
        return view("{$ruta}.solicitud-credito.index", compact('solicitudes'));
    } else {
        // Usuario solo ve sus propias solicitudes
        $solicitudes = SolicitudCredito::where('usuario_id', $user->id)
            ->latest()
            ->paginate(10);
        
        return view('usuario.solicitud-credito.index', compact('solicitudes'));
    }
}

public function create()
{
    $user = Auth::user();
    
    if ($user->rol->nombre === 'admin' || $user->rol->nombre === 'gestor') {
        // Admin/Gestor pueden seleccionar usuario
        $usuarios = Usuario::all();
        $oficialCredito = $user->nombre_completo; // <-- Agregar esta línea
        
        $ruta = $user->rol->nombre === 'admin' ? 'admin' : 'gestor';
        return view("{$ruta}.solicitud-credito.create", compact('usuarios', 'oficialCredito')); // <-- Agregar 'oficialCredito'
    } else {
        // Usuario crea su propia solicitud
        $oficialCredito = 'Sistema Automático'; // <-- Agregar valor por defecto
        return view('usuario.solicitud-credito.create', compact('oficialCredito'));
    }
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'producto' => 'required|in:mensual,semanal,diario',
            'fecha_solicitud' => 'required|date',
            
            // Datos solicitante
            'fecha_nacimiento' => 'nullable|date',
            'edad' => 'nullable|integer|min:18|max:100',
            'estado_civil' => 'nullable|string|max:50',
            'telefono_fijo' => 'nullable|string|max:20',
            'celular_solicitante' => 'nullable|string|max:20',
            'domicilio' => 'nullable|string|max:255',
            'tipo_vivienda' => 'nullable|in:propia,alquiler,familiar,anticretico,otra',
            'monto_vivienda' => 'nullable|numeric|min:0',
            'tiempo_permanencia_anios' => 'nullable|integer|min:0',
            'tiempo_permanencia_meses' => 'nullable|integer|min:0|max:11',
            'correo_solicitante' => 'nullable|email|max:100',
            
            // Datos cónyuge
            'conyuge_nombre_completo' => 'nullable|string|max:255',
            'conyuge_ci' => 'nullable|string|max:20',
            'conyuge_expedido' => 'nullable|string|max:5',
            'conyuge_fecha_nacimiento' => 'nullable|date',
            'conyuge_edad' => 'nullable|integer|min:0',
            'conyuge_estado_civil' => 'nullable|string|max:50',
            'conyuge_telefono_fijo' => 'nullable|string|max:20',
            'conyuge_celular' => 'nullable|string|max:20',
            'conyuge_domicilio' => 'nullable|string|max:255',
            'conyuge_tipo_vivienda' => 'nullable|in:propia,alquiler,familiar,anticretico,otra',
            'conyuge_monto_vivienda' => 'nullable|numeric|min:0',
            'conyuge_tiempo_permanencia_anios' => 'nullable|integer|min:0',
            'conyuge_tiempo_permanencia_meses' => 'nullable|integer|min:0|max:11',
            'conyuge_correo' => 'nullable|email|max:100',
            
            // Datos garante
            'garante_nombre_completo' => 'nullable|string|max:255',
            'garante_ci' => 'nullable|string|max:20',
            'garante_expedido' => 'nullable|string|max:5',
            'garante_fecha_nacimiento' => 'nullable|date',
            'garante_edad' => 'nullable|integer|min:0',
            'garante_estado_civil' => 'nullable|string|max:50',
            'garante_telefono_fijo' => 'nullable|string|max:20',
            'garante_celular' => 'nullable|string|max:20',
            'garante_domicilio' => 'nullable|string|max:255',
            'garante_tipo_vivienda' => 'nullable|in:propia,alquiler,familiar,anticretico,otra',
            'garante_monto_vivienda' => 'nullable|numeric|min:0',
            'garante_tiempo_permanencia_anios' => 'nullable|integer|min:0',
            'garante_tiempo_permanencia_meses' => 'nullable|integer|min:0|max:11',
            'garante_correo' => 'nullable|email|max:100',
            
            // Datos laborales
            'tipo_laboral' => 'required|in:dependiente,independiente',
            'profesion_ocupacion' => 'nullable|string|max:255',
            'empresa_trabaja' => 'nullable|string|max:255',
            'cargo_desempena' => 'nullable|string|max:255',
            'fecha_ingreso' => 'nullable|date',
            'fecha_pago_sueldo' => 'nullable|integer|min:1|max:31',
            'descripcion_negocio' => 'nullable|string|max:255',
            'direccion_negocio' => 'nullable|string|max:255',
            'antiguedad_negocio' => 'nullable|string|max:100',
            'telefono_negocio' => 'nullable|string|max:20',
            'salario_actual' => 'nullable|numeric|min:0',
            'ingreso_promedio_mes' => 'nullable|numeric|min:0',
            
            // Ingresos y gastos
            'ventas' => 'nullable|numeric|min:0',
            'otros_ingresos' => 'nullable|numeric|min:0',
            'canasta_familiar' => 'nullable|numeric|min:0',
            'vaticos' => 'nullable|numeric|min:0',
            'servicios_basicos' => 'nullable|numeric|min:0',
            'alquiler' => 'nullable|numeric|min:0',
            'otros_gastos' => 'nullable|numeric|min:0',
            
            // Deudas (se procesarán después)
            'deudas' => 'nullable|array',
            'deudas.*.institucion' => 'nullable|string|max:255',
            'deudas.*.monto' => 'nullable|numeric|min:0',
            
            // Solicitud de crédito
            'monto_solicitado' => 'required|numeric|min:100|max:100000',
            'moneda' => 'required|string|max:10',
            'monto_literal' => 'nullable|string|max:255',
            'tipo_cambio' => 'nullable|numeric|min:0',
            'objetivo_credito' => 'nullable|string|max:500',
            
            // Términos
            'autorizacion_buro' => 'required|boolean',
            
            // Archivos
            'archivos' => 'nullable|array',
            'archivos.*' => 'file|max:10240', // Máximo 10MB
        ]);

        // Procesar datos laborales en JSON
        $datosLaborales = [
            'tipo' => $request->tipo_laboral,
            'profesion_ocupacion' => $request->profesion_ocupacion,
            'empresa_trabaja' => $request->empresa_trabaja,
            'cargo_desempena' => $request->cargo_desempena,
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_pago_sueldo' => $request->fecha_pago_sueldo,
            'descripcion_negocio' => $request->descripcion_negocio,
            'direccion_negocio' => $request->direccion_negocio,
            'antiguedad_negocio' => $request->antiguedad_negocio,
            'telefono_negocio' => $request->telefono_negocio,
            'salario_actual' => $request->salario_actual,
            'ingreso_promedio_mes' => $request->ingreso_promedio_mes,
            'ingresos_gastos' => [
                'ventas' => $request->ventas,
                'otros_ingresos' => $request->otros_ingresos,
                'canasta_familiar' => $request->canasta_familiar,
                'vaticos' => $request->vaticos,
                'servicios_basicos' => $request->servicios_basicos,
                'alquiler' => $request->alquiler,
                'otros_gastos' => $request->otros_gastos,
                'total_ingresos' => ($request->ventas ?? 0) + ($request->otros_ingresos ?? 0),
                'total_gastos' => ($request->canasta_familiar ?? 0) + ($request->vaticos ?? 0) + 
                                 ($request->servicios_basicos ?? 0) + ($request->alquiler ?? 0) + 
                                 ($request->otros_gastos ?? 0),
            ]
        ];

        // Crear solicitud
        $solicitud = SolicitudCredito::create([
            'usuario_id' => $request->usuario_id,
            'oficial_credito' => Auth::user()->nombre_completo,
            'numero_solicitud' => SolicitudCredito::generarNumeroSolicitud(),
            'fecha_solicitud' => $request->fecha_solicitud,
            'producto' => $request->producto,
            
            // Datos solicitante
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'edad' => $request->edad,
            'estado_civil' => $request->estado_civil,
            'telefono_fijo' => $request->telefono_fijo,
            'celular_solicitante' => $request->celular_solicitante,
            'domicilio' => $request->domicilio,
            'tipo_vivienda' => $request->tipo_vivienda,
            'monto_vivienda' => $request->monto_vivienda,
            'tiempo_permanencia_anios' => $request->tiempo_permanencia_anios,
            'tiempo_permanencia_meses' => $request->tiempo_permanencia_meses,
            'correo_solicitante' => $request->correo_solicitante,
            
            // Datos cónyuge
            'conyuge_nombre_completo' => $request->conyuge_nombre_completo,
            'conyuge_ci' => $request->conyuge_ci,
            'conyuge_expedido' => $request->conyuge_expedido,
            'conyuge_fecha_nacimiento' => $request->conyuge_fecha_nacimiento,
            'conyuge_edad' => $request->conyuge_edad,
            'conyuge_estado_civil' => $request->conyuge_estado_civil,
            'conyuge_telefono_fijo' => $request->conyuge_telefono_fijo,
            'conyuge_celular' => $request->conyuge_celular,
            'conyuge_domicilio' => $request->conyuge_domicilio,
            'conyuge_tipo_vivienda' => $request->conyuge_tipo_vivienda,
            'conyuge_monto_vivienda' => $request->conyuge_monto_vivienda,
            'conyuge_tiempo_permanencia_anios' => $request->conyuge_tiempo_permanencia_anios,
            'conyuge_tiempo_permanencia_meses' => $request->conyuge_tiempo_permanencia_meses,
            'conyuge_correo' => $request->conyuge_correo,
            
            // Datos garante
            'garante_nombre_completo' => $request->garante_nombre_completo,
            'garante_ci' => $request->garante_ci,
            'garante_expedido' => $request->garante_expedido,
            'garante_fecha_nacimiento' => $request->garante_fecha_nacimiento,
            'garante_edad' => $request->garante_edad,
            'garante_estado_civil' => $request->garante_estado_civil,
            'garante_telefono_fijo' => $request->garante_telefono_fijo,
            'garante_celular' => $request->garante_celular,
            'garante_domicilio' => $request->garante_domicilio,
            'garante_tipo_vivienda' => $request->garante_tipo_vivienda,
            'garante_monto_vivienda' => $request->garante_monto_vivienda,
            'garante_tiempo_permanencia_anios' => $request->garante_tiempo_permanencia_anios,
            'garante_tiempo_permanencia_meses' => $request->garante_tiempo_permanencia_meses,
            'garante_correo' => $request->garante_correo,
            
            // Datos laborales
            'datos_laborales' => $datosLaborales,
            
            // Solicitud de crédito
            'monto_solicitado' => $request->monto_solicitado,
            'moneda' => $request->moneda,
            'monto_literal' => $request->monto_literal,
            'tipo_cambio' => $request->tipo_cambio,
            'objetivo_credito' => $request->objetivo_credito,
            
            // Términos
            'autorizacion_buro' => $request->autorizacion_buro,
            
            // Estado inicial
            'estado' => 'pendiente',
            'creado_por' => Auth::id(),
        ]);

        // Guardar deudas
        if ($request->filled('deudas')) {
            foreach ($request->deudas as $deuda) {
                if (!empty($deuda['institucion']) && $deuda['monto'] > 0) {
                    DeudaSolicitud::create([
                        'solicitud_credito_id' => $solicitud->id,
                        'institucion' => $deuda['institucion'],
                        'monto' => $deuda['monto']
                    ]);
                }
            }
        }

        // Guardar archivos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $path = $archivo->store('solicitudes/' . $solicitud->id, 'public');
                
                ArchivoSolicitud::create([
                    'solicitud_credito_id' => $solicitud->id,
                    'nombre_archivo' => $archivo->getClientOriginalName(),
                    'ruta' => $path,
                    'tipo' => $this->determinarTipoArchivo($archivo->getClientOriginalName())
                ]);
            }
        }

        return redirect()->route('admin.solicitud-credito.show', $solicitud->id)
            ->with('success', 'Solicitud de crédito registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $solicitud = SolicitudCredito::with(['usuario', 'creador', 'deudas', 'archivos'])
                                    ->findOrFail($id);
        
        return view('admin.solicitud-credito.show', compact('solicitud'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $solicitud = SolicitudCredito::with(['deudas', 'archivos'])->findOrFail($id);
    
    // Solo se puede editar si está pendiente
    if ($solicitud->estado != 'pendiente') {
        return redirect()->route('admin.solicitud-credito.show', $id)
            ->with('error', 'Solo se pueden editar solicitudes en estado PENDIENTE.');
    }
    
    $usuarios = Usuario::where('rol_id', 3)
                      ->where('activo', true)
                      ->orderBy('nombre_completo')
                      ->get();
    
    $oficialCredito = Auth::user()->nombre_completo; // <-- Agregar esta línea
    
    return view('admin.solicitud-credito.edit', compact('solicitud', 'usuarios', 'oficialCredito')); // <-- Agregar 'oficialCredito'
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $solicitud = SolicitudCredito::findOrFail($id);
        
        // Solo se puede editar si está pendiente
        if ($solicitud->estado != 'pendiente') {
            return redirect()->route('admin.solicitud-credito.show', $id)
                ->with('error', 'Solo se pueden editar solicitudes en estado PENDIENTE.');
        }
        
        // Validación similar a store (puedes reutilizar)
        $validated = $request->validate([
            // ... misma validación que en store
        ]);
        
        // Actualizar solicitud
        $solicitud->update($validated);
        
        // Actualizar deudas (eliminar anteriores y crear nuevas)
        $solicitud->deudas()->delete();
        if ($request->filled('deudas')) {
            foreach ($request->deudas as $deuda) {
                if (!empty($deuda['institucion']) && $deuda['monto'] > 0) {
                    DeudaSolicitud::create([
                        'solicitud_credito_id' => $solicitud->id,
                        'institucion' => $deuda['institucion'],
                        'monto' => $deuda['monto']
                    ]);
                }
            }
        }
        
        return redirect()->route('admin.solicitud-credito.show', $solicitud->id)
            ->with('success', 'Solicitud actualizada exitosamente.');
    }

    /**
     * Aprobar una solicitud.
     */
    public function aprobar(Request $request, $id)
    {
        $solicitud = SolicitudCredito::findOrFail($id);
        
        if ($solicitud->estado != 'pendiente') {
            return back()->with('error', 'Solo se pueden aprobar solicitudes pendientes.');
        }
        
        $solicitud->update([
            'estado' => 'aprobada',
            'fecha_aprobacion' => now(),
            'autorizado_por' => Auth::user()->nombre_completo
        ]);
        
        return back()->with('success', 'Solicitud aprobada exitosamente.');
    }

    /**
     * Rechazar una solicitud.
     */
    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500'
        ]);
        
        $solicitud = SolicitudCredito::findOrFail($id);
        
        if ($solicitud->estado != 'pendiente') {
            return back()->with('error', 'Solo se pueden rechazar solicitudes pendientes.');
        }
        
        $solicitud->update([
            'estado' => 'rechazada',
            'datos_laborales' => array_merge(
                $solicitud->datos_laborales ?? [],
                ['motivo_rechazo' => $request->motivo_rechazo]
            )
        ]);
        
        return back()->with('success', 'Solicitud rechazada exitosamente.');
    }

    /**
     * Generar PDF de la solicitud.
     */
    public function generarPDF($id)
    {
        $solicitud = SolicitudCredito::with(['usuario', 'deudas'])->findOrFail($id);
        
        $pdf = Pdf::loadView('admin.solicitud-credito.pdf', compact('solicitud'))
                  ->setPaper('letter', 'portrait');
        
        return $pdf->download("solicitud-credito-{$solicitud->numero_solicitud}.pdf");
    }

    /**
     * Crear préstamo desde solicitud aprobada.
     */
    public function crearPrestamo($id)
    {
        $solicitud = SolicitudCredito::with('usuario')->findOrFail($id);
        
        if (!$solicitud->estaAprobada()) {
            return back()->with('error', 'Solo se puede crear préstamo desde solicitudes aprobadas.');
        }
        
        if ($solicitud->tienePrestamo()) {
            return back()->with('error', 'Esta solicitud ya tiene un préstamo generado.');
        }
        
        // Redirigir al formulario de creación de préstamo con datos precargados
        return redirect()->route('admin.prestamos.create', [
            'usuario_id' => $solicitud->usuario_id,
            'solicitud_id' => $solicitud->id,
            'monto' => $solicitud->monto_solicitado
        ]);
    }

    /**
     * Helper para determinar tipo de archivo.
     */
    private function determinarTipoArchivo($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (str_contains($filename, 'ci') || str_contains($filename, 'carnet') || str_contains($filename, 'identidad')) {
            return 'ci';
        } elseif (str_contains($filename, 'recibo') || str_contains($filename, 'sueldo') || str_contains($filename, 'ingreso')) {
            return 'comprobante_ingresos';
        } elseif (str_contains($filename, 'servicio') || str_contains($filename, 'luz') || str_contains($filename, 'agua')) {
            return 'servicios';
        } else {
            return 'otro';
        }
    }
}