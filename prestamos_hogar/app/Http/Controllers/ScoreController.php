<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

class ScoreController extends Controller
{
    public function show($id)
    {
        $usuario = Usuario::with('prestamos.planPagos.pagos', 'prestamos.planPagos.mora')->findOrFail($id);
        $score = $usuario->calcularScoreCrediticio();

        return view('admin.usuarios.score', compact('usuario', 'score'));
    }
}

