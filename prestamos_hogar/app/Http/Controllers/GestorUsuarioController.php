<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class GestorUsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::with('rol')->whereHas('rol', fn($q) => $q->where('nombre', 'usuario'));

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre_completo', 'like', '%' . $request->buscar . '%')
                    ->orWhere('correo', 'like', '%' . $request->buscar . '%');
            });
        }

        if ($request->filled('estado')) {
            $activo = $request->estado === 'activo' ? 1 : 0;
            $query->where('activo', $activo);
        }

        $usuarios = $query->paginate(10);

        $totalUsuario = Usuario::whereHas('rol', fn($q) => $q->where('nombre', 'usuario'))->count();

        return view('gestor.usuarios.index', compact('usuarios', 'totalUsuario'));
    }

    public function create()
    {
        return view('gestor.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios',
            'contrasena' => 'required|min:6',
            'ci' => 'required|string|max:20',
            'expedido' => 'required|string|max:5',
            'celular' => 'required|string|max:20',
        ]);

        if (\App\Models\Usuario::all()->contains('ci', $request->ci)) {
            return back()->withInput()->withErrors(['ci' => 'El CI ya está registrado.']);
        }

        Usuario::create([
            'nombre_completo' => $request->nombre_completo,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
            'ci' => $request->ci,
            'expedido' => $request->expedido,
            'celular' => $request->celular,
            'rol_id' => Rol::where('nombre', 'usuario')->first()->id,
        ]);

        return redirect()->route('gestor.usuarios.index')->with('success', 'Usuario registrado correctamente.');
    }

    public function show($id)
    {
        $usuario = Usuario::with('rol')->findOrFail($id);
        return view('gestor.usuarios.show', compact('usuario'));
    }

    public function historial($id)
    {
        $usuario = Usuario::with('prestamos.planPagos')->findOrFail($id);
        return view('gestor.usuarios.historial', compact('usuario'));
    }

    public function verPlanPagos($id)
    {
        $usuario = Usuario::with(['prestamos.planPagos'])->findOrFail($id);
        return view('gestor.usuarios.plan_pagos', compact('usuario'));
    }

    public function exportarPDF(Request $request)
    {
        $query = Usuario::with('rol')->whereHas('rol', fn($q) => $q->where('nombre', 'usuario'));

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre_completo', 'like', '%' . $request->buscar . '%')
                    ->orWhere('correo', 'like', '%' . $request->buscar . '%');
            });
        }

        if ($request->filled('estado')) {
            $activo = $request->estado === 'activo' ? 1 : 0;
            $query->where('activo', $activo);
        }

        $usuarios = $query->get();

        $pdf = Pdf::loadView('gestor.usuarios.pdf', compact('usuarios'));
        return $pdf->download('reporte_clientes_filtrado.pdf');
    }
}
