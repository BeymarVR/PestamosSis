<?php
 
namespace App\Http\Controllers;

use App\Models\Prestamo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportePrestamoController extends Controller
{
    public function exportarPDF()
    {
        $prestamos = Prestamo::with('usuario')->get();

        $pdf = Pdf::loadView('admin.prestamos.pdf.reporte-prestamos', compact('prestamos'))
                  ->setPaper('A4', 'landscape');

        return $pdf->download('reporte_prestamos.pdf');
    }
}
