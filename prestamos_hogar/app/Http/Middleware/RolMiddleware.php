<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, $rol)
    {
        $usuario = Auth::user();

        // Verifica si el usuario está autenticado y tiene el rol requerido
        if (!$usuario || $usuario->rol->nombre !== $rol) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
