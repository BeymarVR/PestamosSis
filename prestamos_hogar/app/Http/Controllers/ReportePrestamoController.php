<?php


namespace App\Http\Controllers;

use App\Models\Prestamo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportePrestamoController extends Controller
{
    public function exportarPDF(Request $request)
    {
        $query = Prestamo::with('usuario');

        if ($request->filled('buscar')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('nombre_completo', 'like', '%' . $request->buscar . '%')
                    ->orWhere('correo', 'like', '%' . $request->buscar . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('monto_min')) {
            $query->where('monto', '>=', $request->monto_min);
        }

        if ($request->filled('orden')) {
            switch ($request->orden) {
                case 'monto_asc':
                    $query->orderBy('monto', 'asc');
                    break;
                case 'monto_desc':
                    $query->orderBy('monto', 'desc');
                    break;
                case 'fecha_asc':
                    $query->orderBy('fecha_desembolso', 'asc');
                    break;
                case 'fecha_desc':
                    $query->orderBy('fecha_desembolso', 'desc');
                    break;
                default:
                    $query->latest();
            }
        }
        else {
            $query->latest();
        }

        $prestamos = $query->get();

        $pdf = Pdf::loadView('admin.prestamos.pdf.reporte-prestamos', compact('prestamos'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('reporte_prestamos_filtrado.pdf');
    }
}
