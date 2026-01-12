<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\Usuario;

class NotificacionService
{
    public function crear($data)
    {
        // Notifica a todos los administradores por defecto
        $usuarios = Usuario::whereHas('rol', function ($q) {
            $q->whereIn('nombre', ['admin', 'gestor']);
        })->get();

        foreach ($usuarios as $usuario) {
            Notificacion::create([
                'usuario_id' => $usuario->id,
                'plan_pago_id' => $data['plan_pago_id'] ?? null,
                'tipo' => $data['tipo'],
                'mensaje' => $data['mensaje'],
                'fecha_vencimiento' => $data['fecha_vencimiento'] ?? null,
            ]);
        }
    }
}
