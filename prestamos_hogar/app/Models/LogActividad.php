<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogActividad extends Model
{
    protected $table = 'logs_actividad';

    protected $fillable = [
        'usuario_id',
        'accion',
        'descripcion',
        'modelo_tipo',
        'modelo_id',
        'valores_anteriores',
        'valores_nuevos',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'valores_anteriores' => 'array',
        'valores_nuevos' => 'array',
    ];

    /**
     * Relación con el usuario que realizó la acción.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class , 'usuario_id');
    }

    /**
     * Formatear los cambios para auditoría.
     */
    public function getCambiosFormateadosAttribute()
    {
        if (!$this->valores_anteriores && !$this->valores_nuevos)
            return [];

        $cambios = [];
        $anteriores = $this->valores_anteriores ?? [];
        $nuevos = $this->valores_nuevos ?? [];

        // Combinar todas las llaves
        $keys = array_unique(array_merge(array_keys($anteriores), array_keys($nuevos)));

        foreach ($keys as $key) {
            $valAnterior = $anteriores[$key] ?? null;
            $valNuevo = $nuevos[$key] ?? null;

            if ($valAnterior != $valNuevo) {
                // Resolver nombres para IDs (evitar mostrar IDs feos)
                if (str_ends_with($key, '_id') || in_array($key, ['creado_por', 'autorizado_por', 'oficial_credito'])) {
                    $valAnterior = $this->resolverNombreId($key, $valAnterior);
                    $valNuevo = $this->resolverNombreId($key, $valNuevo);
                }

                // Detectar y formatear fechas/horas
                $valAnterior = $this->intentarFormatearFecha($key, $valAnterior);
                $valNuevo = $this->intentarFormatearFecha($key, $valNuevo);

                $cambios[] = [
                    'campo' => $this->traducirCampo($key),
                    'anterior' => $valAnterior,
                    'nuevo' => $valNuevo
                ];
            }
        }

        return $cambios;
    }

    /**
     * Intenta detectar si un valor es una fecha/hora y lo formatea amigablemente.
     */
    private function intentarFormatearFecha($campo, $valor)
    {
        if (is_null($valor) || empty($valor))
            return $valor;

        // Si el campo tiene 'fecha' o 'at' (como created_at), o el valor tiene formato de timestamp
        if (str_contains($campo, 'fecha') || str_ends_with($campo, '_at') || preg_match('/^\d{4}-\d{2}-\d{2}/', $valor)) {
            try {
                return \Carbon\Carbon::parse($valor)->translatedFormat('d \d\e F, Y - H:i');
            }
            catch (\Exception $e) {
                return $valor;
            }
        }

        return $valor;
    }

    /**
     * Intenta encontrar el nombre descriptivo de un ID relacionado.
     */
    private function resolverNombreId($campo, $id)
    {
        if (is_null($id) || empty($id))
            return null;

        try {
            // Limpiar el campo para la búsqueda (p.ej. 'creado_por' -> 'usuario_id')
            $userFields = ['usuario_id', 'cliente_id', 'autorizado_por', 'creado_por', 'oficial_credito', 'solicitante_id', 'usuario_registrador'];
            $buscaUser = in_array($campo, $userFields);

            if ($buscaUser) {
                $entidad = \App\Models\Usuario::find($id);
                return $entidad ? "{$entidad->nombre_completo} (ID: $id)" : "ID: $id";
            }

            switch ($campo) {
                case 'rol_id':
                    $entidad = \App\Models\Rol::find($id);
                    return $entidad ? "{$entidad->nombre}" : "ID: $id";

                case 'prestamo_id':
                    $entidad = \App\Models\Prestamo::find($id);
                    return $entidad ? "Préstamo #{$entidad->codigo}" : "ID: $id";

                case 'solicitud_id':
                    $entidad = \App\Models\SolicitudCredito::find($id);
                    return $entidad ? "Solicitud {$entidad->numero_solicitud}" : "ID: $id";

                case 'pago_id':
                    $entidad = \App\Models\Pago::find($id);
                    return $entidad ? "Pago #$id" : "ID: $id";

                case 'plan_pago_id':
                    $entidad = \App\Models\PlanPago::with('prestamo.usuario')->find($id);
                    if ($entidad && $entidad->prestamo) {
                        $cliente = $entidad->prestamo->usuario ? $entidad->prestamo->usuario->nombre_completo : 'N/A';
                        return "Cuota #{$entidad->numero_cuota} del Préstamo {$entidad->prestamo->codigo} (Cliente: $cliente)";
                    }
                    return "ID: $id";
            }
        }
        catch (\Exception $e) {
        // Ignorar errores y devolver solo el ID
        }

        return "ID: $id";
    }

    /**
     * Devuelve una descripción legible de la entidad afectada.
     */
    public function getEntidadDescriptivaAttribute()
    {
        if (!$this->modelo_tipo || !$this->modelo_id)
            return 'N/A';

        $nombreClase = class_basename($this->modelo_tipo);
        $descripcion = $this->resolverNombreId(strtolower($nombreClase) . '_id', $this->modelo_id);

        // Si el resolver devolvió algo bonito, úsalo, si no, usa el formato estándar
        return $nombreClase . ' (' . $descripcion . ')';
    }

    private function traducirCampo($campo)
    {
        $diccionario = [
            'monto' => 'Monto',
            'estado' => 'Estado / Fase',
            'tasa_interes_mensual' => 'Tasa de Interés (%)',
            'plazo_meses' => 'Plazo (Meses)',
            'frecuencia_pago' => 'Frecuencia de Repago',
            'fecha_desembolso' => 'Fecha de Desembolso',
            'usuario_id' => 'Usuario Responsable',
            'cliente_id' => 'Cliente Asociado',
            'rol_id' => 'Rol Asignado',
            'referencia_celular' => 'Celular de Referencia',
            'metodo_pago' => 'Método de Pago',
            'fecha_pago' => 'Fecha de Operación',
            'observaciones' => 'Observaciones / Notas',
            'numero_solicitud' => 'Nro. de Solicitud',
            'monto_solicitado' => 'Monto Solicitado',
            'producto' => 'Producto / Servicio',
            'conyuge_nombre_completo' => 'Nombre del Cónyuge',
            'garante_nombre_completo' => 'Nombre del Garante',
            'objetivo_credito' => 'Objetivo del Crédito',
            'autorizado_por' => 'Autorizado Por',
            'creado_por' => 'Registrado Por',
            'usuario_registrador' => 'Usuario Registrador',
            'prestamo_id' => 'Préstamo Vinculado',
            'plan_pago_id' => 'Cuota / Plan de Pagos',
            'numero_cuota' => 'Número de la Cuota',
            'fecha_vencimiento' => 'Vencimiento de la Cuota',
            'monto_cuota' => 'Valor de la Cuota',
            'capital_pagado' => 'Capital Amortizado',
            'password' => 'Contraseña (Encriptada)',
            'deleted_at' => 'Fecha de Eliminación',
        ];

        return $diccionario[$campo] ?? ucfirst(str_replace(['_', 'id'], [' ', ' '], $campo));
    }
}
