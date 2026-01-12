<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivoSolicitud extends Model
{
    protected $table = 'archivos_solicitud';

    protected $fillable = [
        'solicitud_credito_id',
        'nombre_archivo',
        'ruta',
        'tipo'
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(SolicitudCredito::class);
    }
}