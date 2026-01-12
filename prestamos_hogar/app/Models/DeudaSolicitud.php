<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeudaSolicitud extends Model
{
    protected $table = 'deudas_solicitud';

    protected $fillable = [
        'solicitud_credito_id',
        'institucion',
        'monto'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(SolicitudCredito::class);
    }
}