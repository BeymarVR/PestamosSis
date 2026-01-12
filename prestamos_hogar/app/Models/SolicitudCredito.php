<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolicitudCredito extends Model
{
    use SoftDeletes;

    protected $table = 'solicitud_creditos';

    protected $fillable = [
        'usuario_id',
        'oficial_credito',
        'numero_solicitud',
        'fecha_solicitud',
        'producto',
        // Datos solicitante
        'fecha_nacimiento',
        'edad',
        'estado_civil',
        'telefono_fijo',
        'celular_solicitante',
        'domicilio',
        'tipo_vivienda',
        'monto_vivienda',
        'tiempo_permanencia_anios',
        'tiempo_permanencia_meses',
        'correo_solicitante',
        // Datos cónyuge
        'conyuge_nombre_completo',
        'conyuge_ci',
        'conyuge_expedido',
        'conyuge_fecha_nacimiento',
        'conyuge_edad',
        'conyuge_estado_civil',
        'conyuge_telefono_fijo',
        'conyuge_celular',
        'conyuge_domicilio',
        'conyuge_tipo_vivienda',
        'conyuge_monto_vivienda',
        'conyuge_tiempo_permanencia_anios',
        'conyuge_tiempo_permanencia_meses',
        'conyuge_correo',
        // Datos garante
        'garante_nombre_completo',
        'garante_ci',
        'garante_expedido',
        'garante_fecha_nacimiento',
        'garante_edad',
        'garante_estado_civil',
        'garante_telefono_fijo',
        'garante_celular',
        'garante_domicilio',
        'garante_tipo_vivienda',
        'garante_monto_vivienda',
        'garante_tiempo_permanencia_anios',
        'garante_tiempo_permanencia_meses',
        'garante_correo',
        // Datos laborales
        'datos_laborales',
        // Solicitud
        'monto_solicitado',
        'moneda',
        'monto_literal',
        'tipo_cambio',
        'objetivo_credito',
        // Términos
        'autorizacion_buro',
        'firma_solicitante',
        'firma_conyuge',
        'firma_garante',
        // Aprobación
        'estado',
        'fecha_aprobacion',
        'autorizado_por',
        'fecha_firma_contrato',
        'prestamo_id',
        'archivos_adjuntos',
        'creado_por'
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_nacimiento' => 'date',
        'conyuge_fecha_nacimiento' => 'date',
        'garante_fecha_nacimiento' => 'date',
        'fecha_aprobacion' => 'date',
        'fecha_firma_contrato' => 'date',
        'monto_solicitado' => 'decimal:2',
        'monto_vivienda' => 'decimal:2',
        'conyuge_monto_vivienda' => 'decimal:2',
        'garante_monto_vivienda' => 'decimal:2',
        'tipo_cambio' => 'decimal:4',
        'datos_laborales' => 'array',
        'archivos_adjuntos' => 'array',
    ];

    /**
     * Relación con el usuario (cliente)
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relación con el usuario creador (admin/gestor)
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    /**
     * Relación con el préstamo generado
     */
    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class);
    }

    /**
     * Deudas en otras instituciones
     */
    public function deudas(): HasMany
    {
        return $this->hasMany(DeudaSolicitud::class);
    }

    /**
     * Archivos adjuntos
     */
    public function archivos(): HasMany
    {
        return $this->hasMany(ArchivoSolicitud::class);
    }

    /**
     * Generar número de solicitud único
     */
    public static function generarNumeroSolicitud(): string
    {
        $prefix = 'SOL-';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        
        return $prefix . $date . '-' . $random;
    }

    /**
     * Verificar si está aprobada
     */
    public function estaAprobada(): bool
    {
        return $this->estado === 'aprobada';
    }

    /**
     * Verificar si tiene préstamo generado
     */
    public function tienePrestamo(): bool
    {
        return !is_null($this->prestamo_id);
    }
}