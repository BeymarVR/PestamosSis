<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones'; // Forzar nombre en español

    protected $fillable = [
        'usuario_id',
        'plan_pago_id',
        'tipo',
        'mensaje',
        'leida',
        'fecha_vencimiento'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function planPago()
    {
        return $this->belongsTo(PlanPago::class);
    }
}