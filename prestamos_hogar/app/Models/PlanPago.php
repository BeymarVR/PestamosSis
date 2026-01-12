<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'prestamo_id',
        'numero_cuota',
        'fecha_vencimiento',
        'monto_cuota',
        'capital',
        'interes',
        'saldo',
        'estado',
        'fecha_pago',
        'mora',
        'observaciones'
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'date',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function estaPagado()
    {
        return $this->pagos()->sum('monto') >= $this->monto_cuota;
    }

     public function mora()
    {
        return $this->hasOne(\App\Models\Mora::class);
    }

public function planPagos()
{
    return $this->hasMany(\App\Models\PlanPago::class);
}

}