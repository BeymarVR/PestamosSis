<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUsuarioController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\PlanPagoController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\CapitalController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\SolicitudCreditoController; // <-- IMPORTANTE: Agregar este use
use App\Models\PlanPago;
use App\Models\Mora;
use Carbon\Carbon;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\ScoreFlaskController;
use App\Http\Controllers\ReportePrestamoController;
use App\Http\Middleware\RolMiddleware;
use App\Http\Controllers\GestorUsuarioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;

// Ruta raíz redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// ======================= AUTENTICACIÓN =======================
Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'login']);
Route::get('/register', [AuthController::class , 'showRegister'])->name('register');
Route::post('/register', [AuthController::class , 'register']);
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

// Dashboard genérico según rol
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class , 'index'])->middleware('auth')->name('dashboard');
});

// ======================= RUTAS ADMINISTRADOR =======================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // ---------- Usuarios ----------
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
            Route::get('/', [AdminUsuarioController::class , 'index'])->name('index');
            Route::get('/crear', [AdminUsuarioController::class , 'create'])->name('create');
            Route::post('/', [AdminUsuarioController::class , 'store'])->name('store');
            Route::get('/{id}/editar', [AdminUsuarioController::class , 'edit'])->name('edit');
            Route::put('/{id}', [AdminUsuarioController::class , 'update'])->name('update');
            Route::post('{id}/activar', [AdminUsuarioController::class , 'activar'])->name('activar');
            Route::post('{id}/desactivar', [AdminUsuarioController::class , 'desactivar'])->name('desactivar');
            Route::get('/{id}/historial', [AdminUsuarioController::class , 'historial'])->name('historial');
            Route::get('/exportar', [AdminUsuarioController::class , 'exportarPDF'])->name('exportar');
            Route::get('/{id}', [AdminUsuarioController::class , 'show'])->name('show');
        }
        );

        // ---------- Solicitudes de Crédito ----------
        Route::prefix('solicitud-credito')->name('solicitud-credito.')->group(function () {
            Route::get('/', [SolicitudCreditoController::class , 'index'])->name('index');
            Route::get('/exportar', [SolicitudCreditoController::class , 'exportarListaPDF'])->name('exportar');
            Route::get('/crear', [SolicitudCreditoController::class , 'create'])->name('create');
            Route::post('/', [SolicitudCreditoController::class , 'store'])->name('store');
            Route::get('/{id}', [SolicitudCreditoController::class , 'show'])->name('show');
            Route::get('/{id}/editar', [SolicitudCreditoController::class , 'edit'])->name('edit');
            Route::put('/{id}', [SolicitudCreditoController::class , 'update'])->name('update');
            Route::put('/{id}/aprobar', [SolicitudCreditoController::class , 'aprobar'])->name('aprobar');
            Route::put('/{id}/rechazar', [SolicitudCreditoController::class , 'rechazar'])->name('rechazar');
            Route::get('/{id}/pdf', [SolicitudCreditoController::class , 'generarPDF'])->name('pdf');
            Route::get('/{id}/crear-prestamo', [SolicitudCreditoController::class , 'crearPrestamo'])->name('crear-prestamo');
        }
        );

        // ---------- Préstamos (CON MIDDLEWARE PARA SOLICITUD APROBADA) ----------
        Route::prefix('prestamos')->name('prestamos.')->group(function () {
            Route::get('/', [PrestamoController::class , 'index'])->name('index');
            Route::get('/crear', [PrestamoController::class , 'create'])->middleware('requiere.solicitud.aprobada')->name('create');
            Route::post('/', [PrestamoController::class , 'store'])->middleware('requiere.solicitud.aprobada')->name('store');
            Route::get('/{id}/editar', [PrestamoController::class , 'edit'])->name('edit');
            Route::put('/{id}', [PrestamoController::class , 'update'])->name('update');
            Route::delete('/{id}', [PrestamoController::class , 'destroy'])->name('destroy');
            Route::get('/{id}/plan-pagos', [PrestamoController::class , 'showPlanPagos'])->name('plan-pagos');
            Route::get('/{id}/plan-pagos/pdf', [PrestamoController::class , 'generarPlanPagosPDF'])->name('plan-pagos.pdf');
            Route::get('/exportar', [ReportePrestamoController::class , 'exportarPDF'])->name('exportar');
            Route::get('/{id}', [PrestamoController::class , 'show'])->name('show');
        }
        );

        // ---------- Planes de Pago ----------
        Route::prefix('plan-pagos')->name('plan-pagos.')->group(function () {
            Route::get('/{id}/monto', [PlanPagoController::class , 'getMontoCuota']);
            Route::post('/pagar', [PlanPagoController::class , 'registrarPago'])->name('pagar');
            Route::post('/aplicar-mora', [PlanPagoController::class , 'aplicarMora'])->name('aplicar-mora');
            Route::delete('/admin/prestamos/{id}', [PrestamoController::class , 'destroy'])->name('admin.prestamos.destroy');
        }
        );

        // ---------- Pagos ----------
        Route::prefix('pagos')->name('pagos.')->group(function () {
            Route::post('/', [PagoController::class , 'store'])->name('store');
            Route::get('/{id}', [PagoController::class , 'show'])->name('show');
            Route::get('/plan-pago/{planPagoId}', [PagoController::class , 'getByPlanPago'])->name('by-plan-pago');
            Route::delete('/{id}', [PagoController::class , 'destroy'])->name('destroy');
        }
        );

        // ---------- Notificaciones ----------
        Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
            Route::get('/', [NotificacionController::class , 'index'])->name('index');
            Route::post('/{id}/leida', [NotificacionController::class , 'marcarLeida'])->name('marcar-leida');
        }
        );

        // ---------- Capital ----------
        Route::prefix('capital')->name('capital.')->group(function () {
            Route::get('/', [CapitalController::class , 'index'])->name('index');
            Route::post('/', [CapitalController::class , 'store'])->name('store');
            Route::post('/retirar', [CapitalController::class , 'retirar'])->name('retirar');
            Route::get('/exportar', [CapitalController::class , 'exportarPDF'])->name('exportar');
        }
        );

        // ---------- Bitácora (Logs) ----------
        Route::prefix('bitacora')->name('bitacora.')->group(function () {
            Route::get('/', [\App\Http\Controllers\BitacoraController::class , 'index'])->name('index');
            Route::get('/{id}', [\App\Http\Controllers\BitacoraController::class , 'show'])->name('show');
            Route::get('/{id}/pdf', [\App\Http\Controllers\BitacoraController::class , 'exportarPDF'])->name('pdf');
        }
        );
    });

// Rutas adicionales admin
Route::get('/admin/plan-pagos/{id}/detalle', [App\Http\Controllers\PagoController::class , 'detalleCuota']);
Route::get('/admin/prestamos/{id}/contrato-pdf', [PrestamoController::class , 'generarContratoPDF'])->name('admin.prestamos.contrato-pdf');

// ======================= Scoring =======================
Route::middleware(['web'])->group(function () {
    Route::get('/admin/usuarios/{id}/score-ia', [ScoreFlaskController::class , 'mostrarScore'])
        ->name('admin.usuarios.scoreia');
});

// ======================= RUTAS GESTOR =======================
Route::middleware(['auth'])->prefix('gestor')->name('gestor.')->group(function () {
    Route::get('/dashboard', function () {
            return view('gestor.dashboard');
        }
        )->name('dashboard');

        // ---------- Usuarios: solo puede registrar con rol cliente ----------
        Route::resource('usuarios', App\Http\Controllers\GestorUsuarioController::class)->only(['index', 'create', 'store']);

        // ---------- Solicitudes de Crédito para gestores ----------
        Route::prefix('solicitud-credito')->name('solicitud-credito.')->group(function () {
            Route::get('/', [SolicitudCreditoController::class , 'index'])->name('index');
            Route::get('/crear', [SolicitudCreditoController::class , 'create'])->name('create');
            Route::post('/', [SolicitudCreditoController::class , 'store'])->name('store');
            Route::get('/{id}', [SolicitudCreditoController::class , 'show'])->name('show');
            Route::get('/{id}/editar', [SolicitudCreditoController::class , 'edit'])->name('edit');
            Route::put('/{id}', [SolicitudCreditoController::class , 'update'])->name('update');
            // Los gestores no pueden aprobar/rechazar, solo admin
            Route::get('/{id}/pdf', [SolicitudCreditoController::class , 'generarPDF'])->name('pdf');
        }
        );

        // ---------- Préstamos (CON MIDDLEWARE PARA SOLICITUD APROBADA) ----------
        Route::prefix('prestamos')->name('prestamos.')->group(function () {
            Route::get('/', [PrestamoController::class , 'index'])->name('index');
            Route::get('/crear', [PrestamoController::class , 'create'])->middleware('requiere.solicitud.aprobada')->name('create');
            Route::post('/', [PrestamoController::class , 'store'])->middleware('requiere.solicitud.aprobada')->name('store');
            Route::get('/{id}/editar', [PrestamoController::class , 'edit'])->name('edit');
            Route::put('/{id}', [PrestamoController::class , 'update'])->name('update');
            // Gestores no pueden eliminar préstamos
            Route::get('/{id}/plan-pagos', [PrestamoController::class , 'showPlanPagos'])->name('plan-pagos');
            Route::get('/{id}/contrato-pdf', [PrestamoController::class , 'generarContratoPDF'])->name('contrato-pdf');
            Route::get('/{id}', [PrestamoController::class , 'show'])->name('show');
        }
        );

        // ---------- Plan de pagos y pagos ----------
        Route::post('/plan-pagos/pagar', [App\Http\Controllers\PlanPagoController::class , 'registrarPago'])->name('plan-pagos.pagar');
        Route::post('/plan-pagos/aplicar-mora', [App\Http\Controllers\PlanPagoController::class , 'aplicarMora'])->name('plan-pagos.aplicar-mora');

        // ---------- Capital ----------
        Route::get('/capital', [App\Http\Controllers\CapitalController::class , 'index'])->name('capital.index');
        Route::post('/capital', [App\Http\Controllers\CapitalController::class , 'store'])->name('capital.store');
        Route::post('/capital/retirar', [App\Http\Controllers\CapitalController::class , 'retirar'])->name('capital.retirar');

        // ---------- Usuarios adicionales ----------
        Route::get('/usuarios/{id}/plan-pagos', [App\Http\Controllers\GestorUsuarioController::class , 'verPlanPagos'])->name('usuarios.plan-pagos');
        Route::get('/usuarios/exportar', [GestorUsuarioController::class , 'exportarPDF'])->name('usuarios.exportar');
        Route::get('/usuarios/{id}/historial', [GestorUsuarioController::class , 'historial'])->name('usuarios.historial');
        Route::get('/usuarios/{id}', [GestorUsuarioController::class , 'show'])->name('usuarios.show');
    });

// ======================= RUTAS USUARIO =======================
Route::middleware(['auth'])->prefix('usuario')->name('usuario.')->group(function () {
    Route::get('/dashboard', function () {
            return view('usuario.dashboard');
        }
        )->name('dashboard');
        Route::get('/prestamos', [UsuarioController::class , 'listaPrestamos'])->name('prestamos');
        Route::get('/prestamo/{id}/plan-pagos', [UsuarioController::class , 'verPlanPagos'])->name('prestamo.plan-pagos');
        Route::get('/historial', [UsuarioController::class , 'historial'])->name('historial');
        Route::get('/perfil', [UsuarioController::class , 'perfil'])->name('perfil');
        Route::get('/prestamos/{id}/plan-pagos/pdf', [UsuarioController::class , 'exportarPlanPagosPDF'])
            ->name('prestamos.pdf');
        // ---------- Solicitud de Crédito para usuarios ----------
        Route::prefix('solicitud-credito')->name('solicitud-credito.')->group(function () {
            Route::get('/crear', [SolicitudCreditoController::class , 'create'])->name('create');
            Route::post('/', [SolicitudCreditoController::class , 'store'])->name('store');
            Route::get('/', [SolicitudCreditoController::class , 'index'])->name('index');
            Route::get('/{id}', [SolicitudCreditoController::class , 'show'])->name('show');
            Route::get('/{id}/pdf', [SolicitudCreditoController::class , 'generarPDF'])->name('pdf');
        }
        );
    });