<?php

namespace App\Http\Controllers;

use App\Models\LogActividad;
use App\Models\Usuario;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index(Request $request)
    {
        $query = LogActividad::with('usuario.rol')->latest();

        // Filtro por usuario
        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        // Filtro por acción
        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        // Filtro por fecha
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $logs = $query->paginate(20);
        $usuarios = Usuario::whereHas('rol', function ($q) {
            $q->whereIn('nombre', ['admin', 'gestor']);
        })->get();

        return view('admin.logs.index', compact('logs', 'usuarios'));
    }

    public function show($id)
    {
        $log = LogActividad::with('usuario.rol')->findOrFail($id);
        return view('admin.logs.show', compact('log'));
    }

    public function exportarPDF($id)
    {
        $log = LogActividad::with('usuario.rol')->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.logs.pdf', compact('log'))
            ->setPaper('letter', 'portrait');

        return $pdf->download("auditoria-log-{$log->id}.pdf");
    }
}
