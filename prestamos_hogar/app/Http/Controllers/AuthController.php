<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:6|confirmed',
            'ci' => 'required|unique:usuarios,ci',
            'expedido' => 'nullable|string|max:5',
            'celular' => 'nullable|string|max:20',
        ]);

        $usuario = Usuario::create([
            'nombre_completo' => $request->nombre_completo,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
            'ci' => $request->ci,
            'expedido' => $request->expedido,
            'celular' => $request->celular,
            'rol_id' => Rol::where('nombre', 'usuario')->first()->id, // todos los registrados por esta vía serán usuarios
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }

    public function login(Request $request)    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required',
        ]);

        $usuario = \App\Models\Usuario::where('correo', $request->correo)->first();

        if ($usuario && Hash::check($request->contrasena, $usuario->contrasena)) {
            Auth::login($usuario); // Inicia sesión manualmente

            if ($usuario->rol->nombre === 'admin') {
                \App\Services\ActivityLogger::log('login', 'Inicio de sesión - Administrador');
                return redirect()->route('dashboard');
            }
            elseif ($usuario->rol->nombre === 'gestor') {
                \App\Services\ActivityLogger::log('login', 'Inicio de sesión - Gestor');
                return redirect()->route('gestor.dashboard');
            }
            else {
                \App\Services\ActivityLogger::log('login', 'Inicio de sesión - Usuario');
                return redirect()->route('usuario.dashboard');
            }
        }

        return back()->withErrors(['correo' => 'Credenciales incorrectas.']);    }


    public function logout()
    {
        \App\Services\ActivityLogger::log('logout', 'Cierre de sesión');
        Auth::logout();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    public function dashboard()
    {
        $usuario = Auth::user();
        return view('dashboard', compact('usuario'));
    }
}
