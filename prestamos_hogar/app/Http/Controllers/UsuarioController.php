<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Prestamo;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function dashboard()
    {
        $usuario = Auth::user();
        $prestamo = Prestamo::where('usuario_id', $usuario->id)
                            ->latest()
                            ->first();

        return view('usuario.dashboard', compact('usuario', 'prestamo'));
    }

    public function prestamo()
{
    $usuario = Auth::user();
    $prestamo = Prestamo::where('usuario_id', $usuario->id)
                        ->latest()
                        ->first();

    if (!$prestamo) {
        return redirect()->route('usuario.dashboard')
                         ->with('error', 'Aún no tienes préstamos registrados.');
    }

    return view('usuario.prestamo', compact('prestamo'));
}


   public function listaPrestamos()
{
    $usuario = Auth::user();
    $prestamos = Prestamo::where('usuario_id', $usuario->id)->with('planPagos')->get();

    return view('usuario.prestamos.index', compact('prestamos'));
}

public function verPlanPagos($id)
{
    $usuario = Auth::user();

    $prestamo = Prestamo::with('planPagos.pagos')
        ->where('usuario_id', $usuario->id)
        ->where('id', $id)
        ->firstOrFail();

    return view('usuario.prestamos.plan_pagos', compact('prestamo'));
}

   public function historial()
{
    $usuario = Auth::user();
    $prestamos = $usuario->prestamos()->with('planPagos')->get();

    return view('usuario.historial', compact('prestamos'));
}


    public function perfil()
    {
        $usuario = Auth::user();
        return view('usuario.perfil', compact('usuario'));
    }

    public function contratoPDF()
    {
        $usuario = Auth::user();
        $prestamo = Prestamo::with('usuario')
                            ->where('usuario_id', $usuario->id)
                            ->latest()
                            ->first();

        $pdf = Pdf::loadView('usuario.contrato_pdf', compact('prestamo'));
        return $pdf->download('contrato_prestamo.pdf');
    }

public function exportarPlanPagosPDF($id)
{
    $usuario = Auth::user();

    $prestamo = $usuario->prestamos()
        ->with('planPagos.pagos')
        ->findOrFail($id);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('usuario.prestamos.plan_pagos_pdf', compact('prestamo'));
    return $pdf->download("plan_pagos_prestamo_{$id}.pdf");
}

}
