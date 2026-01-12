<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property \Illuminate\Database\Eloquent\Collection $prestamos
 * @property \Illuminate\Database\Eloquent\Collection $notificaciones
 */
class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'correo',
        'contrasena',
        'ci',
        'expedido',
        'celular',
        'rol_id'
    ];

    protected $hidden = [
        'contrasena',
    ];

    /**
     * Relación con el rol del usuario.
     *
     * @return BelongsTo
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class);
    }

    /**
     * Usado por Laravel para saber qué campo es la contraseña.
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Relación con los préstamos del usuario.
     *
     * @return HasMany
     */
    public function prestamos(): HasMany
    {
        return $this->hasMany(\App\Models\Prestamo::class);
    }

    /**
     * Relación con las notificaciones.
     *
     * @return HasMany
     */
    public function notificaciones(): HasMany
    {
        return $this->hasMany(\App\Models\Notificacion::class);
    }

    /**
     * Notificaciones que aún no han sido leídas.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function notificacionesNoLeidas()
    {
        return $this->notificaciones()->where('leida', false);
    }

    /**
     * Cálculo del puntaje crediticio del usuario.
     *
     * @return int
     */
    public function calcularScoreCrediticio(): int
    {
        $prestamos = $this->prestamos()->with('planPagos.pagos', 'planPagos.mora')->get();

        $totalCuotas = 0;
        $cuotasATiempo = 0;

        foreach ($prestamos as $prestamo) {
            foreach ($prestamo->planPagos as $cuota) {
                $totalCuotas++;
                $fechaPago = optional($cuota->pagos->first())->fecha_pago;
                if ($fechaPago && $fechaPago <= $cuota->fecha_vencimiento) {
                    $cuotasATiempo++;
                }
            }
        }

        $porcentajePuntualidad = $totalCuotas > 0 ? ($cuotasATiempo / $totalCuotas) * 40 : 40;

        $cantidadMoras = $prestamos->flatMap->planPagos->filter(fn($c) => $c->mora)->count();
        $penalizacionMoras = min($cantidadMoras * 5, 15); // -5 por mora, máx -15

        $primerPrestamo = $this->prestamos()->orderBy('created_at')->first();
        $antiguedadMeses = $primerPrestamo ? now()->diffInMonths($primerPrestamo->created_at) : 0;
        $puntosAntiguedad = min($antiguedadMeses * 2, 20);

        $totalPrestamos = $this->prestamos()->count();
        $puntosHistorial = min($totalPrestamos * 5, 15);

        $promedioMonto = $this->prestamos()->avg('monto');
        $puntosMonto = $promedioMonto < 2000 ? 10 : ($promedioMonto < 5000 ? 5 : 0);

        $score = $porcentajePuntualidad - $penalizacionMoras + $puntosAntiguedad + $puntosHistorial + $puntosMonto;

        return max(min(round($score), 100), 0);
    }

    /**
 * Relación con las solicitudes de crédito
 *
 * @return HasMany
 */
    public function solicitudesCredito(): HasMany
    {
        return $this->hasMany(SolicitudCredito::class);
    }
}
