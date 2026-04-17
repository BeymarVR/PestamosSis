<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'usuario_id',
        'monto',
        'tasa_interes_mensual',
        'plazo_meses',
        'frecuencia_pago',
        'fecha_desembolso',
        'estado',
        'referencia_celular'
    ];

    protected $casts = [
        'fecha_desembolso' => 'date',
         'fecha_inicio' => 'datetime',
    'fecha_fin_estimada' => 'datetime',
        'referencia_celular' => 'encrypted',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    // Prestamo.php
    public function pagos()
    {
        return $this->hasManyThrough(\App\Models\Pago::class, \App\Models\PlanPago::class);
    }


    public function planPagos()
    {
        return $this->hasMany(PlanPago::class);
    }

    // Dentro de la clase Prestamo, agregar:
    /**
     * Relación con la solicitud de crédito
     */
    public function solicitudCredito(): BelongsTo
    {
        return $this->belongsTo(SolicitudCredito::class);
    }
}