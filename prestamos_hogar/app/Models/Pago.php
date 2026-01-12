<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'plan_pago_id',
        'monto',
        'fecha_pago',
        'metodo_pago',
        'comprobante',
        'observaciones',
        'usuario_registrador_id'
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto' => 'decimal:2'
    ];

    public function planPago()
    {
        return $this->belongsTo(PlanPago::class);
    }

    public function usuarioRegistrador()
    {
        return $this->belongsTo(Usuario::class, 'usuario_registrador_id');
    }
}