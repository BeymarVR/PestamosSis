<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RFIDController;

// Las rutas en api.php ya tienen prefijo '/api' automáticamente
// en Laravel 11 cuando usas ->withRouting(api: ...)

Route::post('/verify-rfid', [RFIDController::class, 'verify']);
Route::post('/rfid-check-scan', [RFIDController::class, 'checkScan'])->name('rfid.check.scan');
Route::post('/rfid-clear-scan', [RFIDController::class, 'clearScan'])->name('rfid.clear.scan');

// También puedes agregar una ruta de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});