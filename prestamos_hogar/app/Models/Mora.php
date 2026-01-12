<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mora extends Model
{
    protected $fillable = [
        'plan_pago_id',
        'interes_mora',
        'dias_atraso',
        'fecha_calculo',
        'estado',
    ];

    public function planPago()
    {
        return $this->belongsTo(PlanPago::class);
    }
}
