<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
     protected $table = 'capital'; // Forzar nombre en español

    protected $fillable = [
        'monto_inicial',
        'monto_actual',
        'descripcion',
        'usuario_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}