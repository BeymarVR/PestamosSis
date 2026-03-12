<?php

namespace App\Services;

use App\Models\LogActividad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityLogger
{
    /**
     * Registra un log de actividad.
     *
     * @param string $accion
     * @param string|null $descripcion
     * @param object|null $modelo
     * @param array|null $valoresAnteriores
     * @param array|null $valoresNuevos
     * @return void
     */
    public static function log($accion, $descripcion = null, $modelo = null, $valoresAnteriores = null, $valoresNuevos = null)
    {
        LogActividad::create([
            'usuario_id' => Auth::id(),
            'accion' => $accion,
            'descripcion' => $descripcion,
            'modelo_tipo' => $modelo ? get_class($modelo) : null,
            'modelo_id' => $modelo ? $modelo->id : null,
            'valores_anteriores' => $valoresAnteriores,
            'valores_nuevos' => $valoresNuevos,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
    }
}
