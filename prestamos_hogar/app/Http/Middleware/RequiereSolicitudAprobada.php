<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SolicitudCredito;

class RequiereSolicitudAprobada
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo aplica a creación de préstamos sin parámetros
        if ($request->route()->named('admin.prestamos.create') || 
            $request->route()->named('gestor.prestamos.create')) {
            
            // Verificar si viene de una solicitud aprobada
            $solicitudId = $request->query('solicitud_id');
            
            if (!$solicitudId) {
                // Si no viene de una solicitud, verificar si hay solicitudes aprobadas disponibles
                $solicitudesAprobadas = SolicitudCredito::where('estado', 'aprobada')
                    ->whereNull('prestamo_id')
                    ->count();
                
                if ($solicitudesAprobadas === 0) {
                    // Redirigir a la lista de solicitudes
                    $user = $request->user();
                    if ($user->rol->nombre === 'admin') {
                        return redirect()->route('admin.solicitud-credito.index')
                            ->with('info', 'No hay solicitudes aprobadas disponibles. Primero aprueba una solicitud de crédito.');
                    } elseif ($user->rol->nombre === 'gestor') {
                        return redirect()->route('gestor.solicitud-credito.index')
                            ->with('info', 'No hay solicitudes aprobadas disponibles. Contacta al administrador para aprobar solicitudes.');
                    }
                }
                
                // Si hay solicitudes aprobadas, redirigir a la lista para seleccionar
                if ($request->user()->rol->nombre === 'admin') {
                    return redirect()->route('admin.solicitud-credito.index')
                        ->with('info', 'Selecciona una solicitud aprobada para crear el préstamo.');
                } elseif ($request->user()->rol->nombre === 'gestor') {
                    return redirect()->route('gestor.solicitud-credito.index')
                        ->with('info', 'Selecciona una solicitud aprobada para crear el préstamo.');
                }
            } else {
                // Verificar que la solicitud existe y está aprobada
                $solicitud = SolicitudCredito::find($solicitudId);
                
                if (!$solicitud || $solicitud->estado !== 'aprobada' || $solicitud->prestamo_id) {
                    $user = $request->user();
                    if ($user->rol->nombre === 'admin') {
                        return redirect()->route('admin.solicitud-credito.index')
                            ->with('error', 'La solicitud seleccionada no está aprobada o ya tiene un préstamo.');
                    } elseif ($user->rol->nombre === 'gestor') {
                        return redirect()->route('gestor.solicitud-credito.index')
                            ->with('error', 'La solicitud seleccionada no está aprobada o ya tiene un préstamo.');
                    }
                }
            }
        }
        
        return $next($request);
    }
}