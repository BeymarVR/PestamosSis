<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminUsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::with('rol');

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre_completo', 'like', '%' . $request->buscar . '%')
                    ->orWhere('correo', 'like', '%' . $request->buscar . '%');
            });
        }

        if ($request->filled('rol')) {
            $query->whereHas('rol', function ($q) use ($request) {
                $q->where('nombre', $request->rol);
            });
        }

        if ($request->filled('estado')) {
            $activo = $request->estado === 'activo' ? 1 : 0;
            $query->where('activo', $activo);
        }

        $usuarios = $query->paginate(10);

        $totalAdmin = Usuario::whereHas('rol', fn($q) => $q->where('nombre', 'admin'))->count();
        $totalGestor = Usuario::whereHas('rol', fn($q) => $q->where('nombre', 'gestor'))->count();
        $totalUsuario = Usuario::whereHas('rol', fn($q) => $q->where('nombre', 'usuario'))->count();

        return view('admin.usuarios.index', compact(
            'usuarios', 'totalAdmin', 'totalGestor', 'totalUsuario'
        ));
    }


    public function create()
    {
        $roles = Rol::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:6|confirmed',
            'ci' => 'required|unique:usuarios,ci',
            'expedido' => 'nullable|string|max:5',
            'celular' => 'nullable|string|max:20',
            'rol_id' => 'required|exists:roles,id',
        ]);

        Usuario::create([
            'nombre_completo' => $validated['nombre_completo'],
            'correo' => $validated['correo'],
            'contrasena' => Hash::make($validated['contrasena']),
            'ci' => $validated['ci'],
            'expedido' => $validated['expedido'],
            'celular' => $validated['celular'],
            'rol_id' => $validated['rol_id'],
        ]);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Rol::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'correo' => "required|email|unique:usuarios,correo,$id",
            'ci' => "required|unique:usuarios,ci,$id",
            'expedido' => 'nullable|string|max:5',
            'celular' => 'nullable|string|max:20',
            'rol_id' => 'required|exists:roles,id',
            'contrasena' => 'nullable|min:6|confirmed',
        ]);

        $usuario = Usuario::findOrFail($id);
        $data = [
            'nombre_completo' => $validated['nombre_completo'],
            'correo' => $validated['correo'],
            'ci' => $validated['ci'],
            'expedido' => $validated['expedido'],
            'celular' => $validated['celular'],
            'rol_id' => $validated['rol_id'],
        ];

        if ($request->filled('contrasena')) {
            $data['contrasena'] = Hash::make($validated['contrasena']);
        }

        $valoresAnteriores = $usuario->only(['nombre_completo', 'correo', 'ci', 'rol_id', 'activo']);
        $usuario->update($data);
        $valoresNuevos = $usuario->only(['nombre_completo', 'correo', 'ci', 'rol_id', 'activo']);

        \App\Services\ActivityLogger::log('actualizacion', "Actualización de datos del usuario: $usuario->nombre_completo", $usuario, $valoresAnteriores, $valoresNuevos);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    // Método adicional para eliminar usuarios (opcional)
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    // Mostrar detalles de un usuario
    public function show($id)
    {
        $usuario = Usuario::with('rol')->findOrFail($id);
        return view('admin.usuarios.show', compact('usuario'));
    }

    // Desactivar usuario
    public function desactivar($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->activo = false;
        $usuario->save();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario desactivado correctamente.');
    }

    // (Opcional) Historial: podrías mostrar cambios o préstamos
    public function historial($id)
    {
        $usuario = Usuario::with('prestamos.planPagos')->findOrFail($id);
        return view('admin.usuarios.historial', compact('usuario'));
    }

    public function activar($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->activo = true;
        $usuario->save();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario activado correctamente.');
    }
    public function exportarPDF(Request $request)
    {
        $query = Usuario::with('rol');

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre_completo', 'like', '%' . $request->buscar . '%')
                    ->orWhere('correo', 'like', '%' . $request->buscar . '%');
            });
        }

        if ($request->filled('rol')) {
            $query->whereHas('rol', function ($q) use ($request) {
                $q->where('nombre', $request->rol);
            });
        }

        if ($request->filled('estado')) {
            $activo = $request->estado === 'activo' ? 1 : 0;
            $query->where('activo', $activo);
        }

        $usuarios = $query->get();

        $pdf = Pdf::loadView('admin.usuarios.pdf', compact('usuarios'));
        return $pdf->download('usuarios_filtrados.pdf');
    }

}