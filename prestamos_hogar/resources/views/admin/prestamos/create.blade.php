@extends('layouts.app')

@section('page-title', 'Registrar Nuevo Préstamo')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Registrar Nuevo Préstamo</h1>
            <p class="mt-1 text-sm text-slate-600">Completa la información para registrar un nuevo préstamo en el sistema</p>
        </div>
        <a href="{{ route('admin.prestamos.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Volver</span>
        </a>
    </div>

    @if($solicitud)
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <div class="flex-1">
                <h5 class="font-semibold text-blue-800">Creando Préstamo desde Solicitud Aprobada</h5>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-2 text-sm">
                    <div>
                        <span class="text-blue-600">N° Solicitud:</span>
                        <span class="font-medium ml-1">{{ $solicitud->numero_solicitud }}</span>
                    </div>
                    <div>
                        <span class="text-blue-600">Cliente:</span>
                        <span class="font-medium ml-1">{{ $solicitud->usuario->nombre_completo }}</span>
                    </div>
                    <div>
                        <span class="text-blue-600">Monto Solicitado:</span>
                        <span class="font-medium ml-1">Bs. {{ number_format($solicitud->monto_solicitado, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-blue-600">Producto:</span>
                        <span class="font-medium ml-1">{{ ucfirst($solicitud->producto) }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.solicitud-credito.show', $solicitud->id) }}" class="inline-flex items-center mt-3 text-blue-600 hover:text-blue-800 font-medium text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Ver Solicitud Completa
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Información del Préstamo</h3>
            <p class="text-sm text-slate-600">Los campos marcados con * son obligatorios</p>
            <div class="mt-2 bg-blue-50 border-l-4 border-blue-500 p-2 rounded-r">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium text-blue-800">Capital disponible: Bs. {{ number_format($capitalDisponible, 2) }}</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.prestamos.store') }}" id="prestamoForm" class="p-6 space-y-6">
            @csrf

            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="text-red-800 font-medium">Por favor corrige los siguientes errores:</span>
                    </div>
                    <ul class="text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Campo oculto para autorizado_por_id -->
            <input type="hidden" name="autorizado_por_id" id="autorizadoPorId" value="">

            <!-- Campo oculto para solicitud_id -->
            @if($solicitud)
            <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">
            @endif

            <!-- Cliente Section -->
            <div class="space-y-6">
                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="text-lg font-medium text-slate-900">Información del Cliente</h4>
                    <p class="text-sm text-slate-600">Selecciona el usuario que solicita el préstamo</p>
                </div>

                <div class="space-y-2">
                    <label for="usuario_id" class="block text-sm font-medium text-slate-700">
                        Seleccionar Cliente *
                    </label>
                    @if($usuarioSeleccionado)
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input type="text" readonly value="{{ $usuarioSeleccionado->nombre_completo }} - CI: {{ $usuarioSeleccionado->ci }} (Desde solicitud {{ $solicitud->numero_solicitud ?? '' }})" 
                                   class="w-full pl-10 pr-3 py-3 border border-slate-300 bg-slate-50 rounded-lg text-slate-700">
                            <input type="hidden" name="usuario_id" value="{{ $usuarioSeleccionado->id }}">
                        </div>
                    @else
                        <select name="usuario_id" id="usuario_id" required
                                class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('usuario_id') border-red-300 @enderror">
                            <option value="">Seleccionar cliente...</option>
                            @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nombre_completo }} - CI: {{ $usuario->ci }}
                            </option>
                            @endforeach
                        </select>
                    @endif
                    @error('usuario_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Detalles del Préstamo -->
            <div class="space-y-6">
                <div class="border-l-4 border-green-500 pl-4">
                    <h4 class="text-lg font-medium text-slate-900">Términos del Préstamo</h4>
                    <p class="text-sm text-slate-600">Define los montos, plazos y condiciones del préstamo</p>
                </div>

                <!-- Monto -->
                <div class="space-y-2">
                    <label for="monto" class="block text-sm font-medium text-slate-700">
                        Monto del Préstamo (Bs.) *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">Bs.</span>
                        </div>
                        <input type="number" name="monto" id="monto" 
                               value="{{ old('monto', $montoPrecargado ?? '') }}" 
                               step="0.01" min="100" required
                               class="w-full pl-12 pr-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('monto') border-red-300 @enderror"
                               oninput="validarMonto(this)">
                        @error('monto')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div id="monto-error" class="hidden mt-1 p-2 bg-red-50 border border-red-200 text-red-700 text-sm rounded"></div>
                    
                    <!-- Capital Restante -->
                    <div id="capital-restante-container" class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-blue-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-blue-800">Capital disponible: <span class="font-bold">Bs. {{ number_format($capitalDisponible, 2) }}</span></p>
                                <p id="capital-restante" class="text-blue-600 text-sm mt-1">
                                    Capital restante después del préstamo: <span class="font-semibold">Bs. {{ number_format($capitalDisponible, 2) }}</span>
                                </p>
                                <p class="text-xs text-blue-500 mt-2">
                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Este valor determina si es posible otorgar nuevos préstamos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasa y Plazo -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tasa de interés -->
                    <div class="space-y-2">
                        <label for="tasa_interes_mensual" class="block text-sm font-medium text-slate-700">
                            Tasa de Interés Mensual (%) *
                        </label>
                        <div class="relative">
                            <input type="number" name="tasa_interes_mensual" id="tasa_interes_mensual" 
                                   value="{{ old('tasa_interes_mensual', 5) }}" step="0.01" min="0" max="100" required
                                   class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('tasa_interes_mensual') border-red-300 @enderror"
                                   oninput="actualizarResumen()">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">%</span>
                            </div>
                        </div>
                        @error('tasa_interes_mensual')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Plazo -->
                    <div class="space-y-2">
                        <label for="plazo_meses" class="block text-sm font-medium text-slate-700">
                            Plazo (meses) *
                        </label>
                        <select name="plazo_meses" id="plazo_meses" required
                                class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('plazo_meses') border-red-300 @enderror"
                                onchange="actualizarResumen()">
                            <option value="1" {{ old('plazo_meses') == 1 ? 'selected' : '' }}>1 mes</option>
                            <option value="2" {{ old('plazo_meses') == 2 ? 'selected' : '' }}>2 meses</option>
                            <option value="3" {{ old('plazo_meses') == 3 ? 'selected' : '' }} selected>3 meses</option>
                        </select>
                        @error('plazo_meses')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Frecuencia y Fecha -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Frecuencia de pago -->
                    <div class="space-y-2">
                        <label for="frecuencia_pago" class="block text-sm font-medium text-slate-700">
                            Frecuencia de Pago *
                        </label>
                        <select name="frecuencia_pago" id="frecuencia_pago" required
                                class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('frecuencia_pago') border-red-300 @enderror"
                                onchange="actualizarResumen()">
                            <option value="diario" {{ old('frecuencia_pago') == 'diario' ? 'selected' : '' }}>Diario</option>
                            <option value="semanal" {{ old('frecuencia_pago') == 'semanal' ? 'selected' : '' }}>Semanal</option>
                            <option value="quincenal" {{ old('frecuencia_pago') == 'quincenal' ? 'selected' : '' }} selected>Quincenal</option>
                            <option value="mensual" {{ old('frecuencia_pago') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                        </select>
                        @error('frecuencia_pago')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de desembolso -->
                    <div class="space-y-2">
                        <label for="fecha_desembolso" class="block text-sm font-medium text-slate-700">
                            Fecha de Desembolso *
                        </label>
                        <input type="date" name="fecha_desembolso" id="fecha_desembolso" 
                               value="{{ old('fecha_desembolso', date('Y-m-d')) }}"
                               class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('fecha_desembolso') border-red-300 @enderror"
                               required>
                        @error('fecha_desembolso')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Referencia celular -->
                <div class="space-y-2">
                    <label for="referencia_celular" class="block text-sm font-medium text-slate-700">
                        Teléfono de Referencia
                    </label>
                    <input type="text" name="referencia_celular" id="referencia_celular"
                           value="{{ old('referencia_celular') }}"
                           placeholder="Ej: 70012345"
                           class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('referencia_celular') border-red-300 @enderror">
                    @error('referencia_celular')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Resumen del Préstamo -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h4 class="text-lg font-medium text-blue-800 mb-3">Resumen del Préstamo</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="text-slate-600">Monto solicitado:</div>
                    <div id="resumen-monto" class="font-medium text-right">Bs. {{ number_format($montoPrecargado ?? 0, 2) }}</div>
                    
                    <div class="text-slate-600">Tasa de interés:</div>
                    <div id="resumen-interes" class="font-medium text-right">{{ old('tasa_interes_mensual', 5) }}% mensual</div>
                    
                    <div class="text-slate-600">Plazo total:</div>
                    <div id="resumen-plazo" class="font-medium text-right">{{ old('plazo_meses', 3) }} meses</div>
                    
                    <div class="text-slate-600">Frecuencia de pagos:</div>
                    <div id="resumen-frecuencia" class="font-medium text-right">Quincenal</div>
                    
                    <div class="text-slate-600">Número de cuotas:</div>
                    <div id="resumen-cuotas" class="font-medium text-right">6</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.prestamos.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors duration-200">
                    Cancelar
                </a>
                <button type="button" id="submit-rfid-btn" onclick="showRFIDVerification()"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Registrar Préstamo</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Verificación RFID (CSS y HTML personalizado) -->
<div id="rfidModal" class="rfid-modal" style="display: none;">
    <div class="rfid-modal-content">
        <div class="rfid-modal-header">
            <h3 class="rfid-modal-title">
                <span style="margin-right: 8px;">🔐</span>Verificación RFID Requerida
            </h3>
            <button type="button" class="rfid-close-btn" onclick="closeRFIDModal()">&times;</button>
        </div>
        <div class="rfid-modal-body">
            <!-- Estado: Esperando -->
            <div id="rfidStatusWaiting">
                <div class="rfid-loader-container">
                    <div class="rfid-loader">
                        <div class="rfid-antenna"></div>
                        <div class="rfid-card">
                            <span>💳</span>
                        </div>
                    </div>
                </div>
                <h4 class="rfid-status-title">En espera de escaneo</h4>
                <p class="rfid-status-text">
                    Para crear un préstamo, acerque la tarjeta de administrador/gestor al lector RFID
                </p>
                <div class="rfid-info-box">
                    <span style="margin-right: 8px;">ℹ️</span>
                    Solo personal autorizado puede realizar esta acción
                </div>
                
                <div class="rfid-permissions-grid">
                    <div class="rfid-permission-card authorized">
                        <span style="color: #28a745; margin-right: 6px;">✓</span>
                        <strong>Autorizados:</strong> Admin/Gestor
                    </div>
                    <div class="rfid-permission-card denied">
                        <span style="color: #dc3545; margin-right: 6px;">✗</span>
                        <strong>No autorizados:</strong> Usuarios regulares
                    </div>
                </div>
            </div>
            
            <!-- Estado: Autorizado -->
            <div id="rfidStatusAuthorized" style="display: none;">
                <div class="rfid-success-icon">
                    <span style="font-size: 80px; color: #28a745;">✓</span>
                </div>
                <h4 class="rfid-success-title">¡Acceso Autorizado!</h4>
                <div class="rfid-user-card">
                    <div class="rfid-user-info">
                        <p><strong>Usuario:</strong> <span id="authUserName"></span></p>
                        <p><strong>Rol:</strong> <span id="authUserRole"></span></p>
                        <p><strong>Tarjeta:</strong> <span id="authCardUID" class="rfid-tag"></span></p>
                    </div>
                </div>
                <div class="rfid-success-message">
                    <span style="margin-right: 6px;">✅</span>
                    Puede proceder con la creación del préstamo
                </div>
            </div>
            
            <!-- Estado: Error -->
            <div id="rfidStatusError" style="display: none;">
                <div class="rfid-error-icon">
                    <span style="font-size: 80px; color: #dc3545;">✗</span>
                </div>
                <h4 class="rfid-error-title">Acceso Denegado</h4>
                <p id="errorMessage" class="rfid-error-text"></p>
                <div class="rfid-error-message">
                    <span style="margin-right: 6px;">⚠️</span>
                    No tiene permisos suficientes para crear préstamos
                </div>
            </div>
        </div>
        <div class="rfid-modal-footer">
            <button id="btnContinue" type="button" class="rfid-btn-success" style="display: none;" onclick="continueWithLoan()">
                <span style="margin-right: 6px;">✅</span>Continuar con Préstamo
            </button>
            
            <button id="btnRetry" type="button" class="rfid-btn-warning" style="display: none;" onclick="retryScan()">
                <span style="margin-right: 6px;">🔄</span>Reintentar Escaneo
            </button>
            
            <button type="button" class="rfid-btn-secondary" onclick="cancelVerification()">
                <span style="margin-right: 6px;">❌</span>Cancelar
            </button>
        </div>
    </div>
</div>
<!-- Pop-up de Acceso Denegado -->
<div id="deniedPopup" class="denied-popup">
    <div class="denied-popup-content">
        <div class="denied-popup-icon">
            ⚠️
        </div>
        <div class="denied-popup-text">
            <h4 class="denied-popup-title">ACCESO DENEGADO</h4>
            <p class="denied-popup-message" id="deniedMessage"></p>
            <p class="denied-popup-uid" id="deniedUID"></p>
        </div>
        <button class="denied-popup-close" onclick="hideDeniedPopup()">&times;</button>
    </div>
</div>

<style>
/* Estilos del Modal RFID (Sin Bootstrap) */
.rfid-modal {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.rfid-modal-content {
    background-color: white;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: modalFadeIn 0.3s;
}

@keyframes modalFadeIn {
    from { opacity: 0; transform: translateY(-50px); }
    to { opacity: 1; transform: translateY(0); }
}

.rfid-modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.rfid-modal-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.rfid-close-btn {
    background: none;
    border: none;
    color: white;
    font-size: 28px;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.rfid-close-btn:hover {
    opacity: 0.8;
}

.rfid-modal-body {
    padding: 30px;
    text-align: center;
}

.rfid-loader-container {
    margin-bottom: 20px;
}

.rfid-loader {
    position: relative;
    width: 120px;
    height: 80px;
    margin: 0 auto;
}

.rfid-antenna {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 40px;
    background: linear-gradient(to bottom, #667eea, #764ba2);
    animation: scan 2s infinite;
    border-radius: 2px;
}

.rfid-card {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 40px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

@keyframes scan {
    0%, 100% { height: 40px; opacity: 0.5; }
    50% { height: 60px; opacity: 1; }
}

.rfid-status-title {
    color: #4a5568;
    margin-bottom: 10px;
    font-size: 1.25rem;
}

.rfid-status-text {
    color: #718096;
    margin-bottom: 20px;
    line-height: 1.5;
}

.rfid-info-box {
    background-color: #e6f7ff;
    border: 1px solid #91d5ff;
    border-radius: 6px;
    padding: 12px;
    margin: 20px 0;
    color: #1890ff;
    font-size: 0.9rem;
}

.rfid-permissions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: 20px;
}

.rfid-permission-card {
    padding: 12px;
    border-radius: 8px;
    font-size: 0.85rem;
}

.rfid-permission-card.authorized {
    background-color: #f6ffed;
    border: 1px solid #b7eb8f;
    color: #52c41a;
}

.rfid-permission-card.denied {
    background-color: #fff2f0;
    border: 1px solid #ffccc7;
    color: #ff4d4f;
}

/* Estados de éxito y error */
.rfid-success-icon, .rfid-error-icon {
    margin-bottom: 20px;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.rfid-success-title {
    color: #28a745;
    margin-bottom: 20px;
}

.rfid-error-title {
    color: #dc3545;
    margin-bottom: 20px;
}

.rfid-user-card {
    background-color: #f8f9fa;
    border: 2px solid #28a745;
    border-radius: 10px;
    padding: 20px;
    margin: 20px 0;
    text-align: left;
}

.rfid-user-info p {
    margin: 10px 0;
    color: #495057;
}

.rfid-tag {
    display: inline-block;
    background-color: #17a2b8;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-family: monospace;
}

.rfid-success-message {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 12px;
    border-radius: 6px;
    margin-top: 20px;
}

.rfid-error-text {
    color: #721c24;
    margin: 20px 0;
    font-weight: 500;
}

.rfid-error-message {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 12px;
    border-radius: 6px;
    margin-top: 20px;
}

/* Botones del modal */
.rfid-modal-footer {
    padding: 20px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.rfid-btn-success, .rfid-btn-warning, .rfid-btn-secondary {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.rfid-btn-success {
    background-color: #28a745;
    color: white;
}

.rfid-btn-success:hover {
    background-color: #218838;
}

.rfid-btn-warning {
    background-color: #ffc107;
    color: #212529;
}

.rfid-btn-warning:hover {
    background-color: #e0a800;
}

.rfid-btn-secondary {
    background-color: #6c757d;
    color: white;
}

.rfid-btn-secondary:hover {
    background-color: #5a6268;
}

/* Responsive */
@media (max-width: 640px) {
    .rfid-modal-content {
        width: 95%;
        margin: 10px;
    }
    
    .rfid-permissions-grid {
        grid-template-columns: 1fr;
    }
    
    .rfid-modal-footer {
        flex-direction: column;
    }
    
    .rfid-btn-success, .rfid-btn-warning, .rfid-btn-secondary {
        width: 100%;
        margin-bottom: 8px;
    }
}

/* ===== POP-UP DE ACCESO DENEGADO ===== */
.denied-popup {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-left: 5px solid #dc3545;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    padding: 16px 20px;
    z-index: 9999;
    min-width: 320px;
    max-width: 400px;
    display: none;
    animation: slideInRight 0.4s ease forwards;
}

.denied-popup.show {
    display: block;
}

.denied-popup-content {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.denied-popup-icon {
    font-size: 28px;
    color: #dc3545;
    flex-shrink: 0;
}

.denied-popup-text {
    flex: 1;
}

.denied-popup-title {
    margin: 0 0 4px 0;
    color: #dc3545;
    font-weight: 600;
    font-size: 16px;
}

.denied-popup-message {
    margin: 0 0 6px 0;
    color: #721c24;
    font-size: 14px;
    line-height: 1.4;
}

.denied-popup-uid {
    margin: 0;
    color: #6c757d;
    font-size: 12px;
    font-family: monospace;
    background: #f8f9fa;
    padding: 4px 8px;
    border-radius: 4px;
    display: inline-block;
}

.denied-popup-close {
    background: none;
    border: none;
    color: #6c757d;
    font-size: 18px;
    cursor: pointer;
    padding: 0;
    line-height: 1;
    margin-left: 8px;
}

.denied-popup-close:hover {
    color: #dc3545;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>

<script>
// Variables globales
let scanInterval = null;
let deniedPopupTimeout = null;

// Limpiar timeout cuando se cierra el modal
function cancelVerification() {
    if (scanInterval) {
        clearInterval(scanInterval);
        scanInterval = null;
    }
    
    // Limpiar timeout del pop-up
    if (deniedPopupTimeout) {
        clearTimeout(deniedPopupTimeout);
        deniedPopupTimeout = null;
    }
    
    // Limpiar escaneo
    fetch('{{ route("rfid.clear.scan") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    
    // Ocultar modal
    closeRFIDModal();
    
    // Ocultar pop-up de denegado si está visible
    hideDeniedPopup();
}

// Mostrar modal de verificación RFID
function showRFIDVerification() {
    // Primero validar el formulario
    if (!validateForm()) {
        alert('Por favor complete todos los campos requeridos correctamente.');
        return;
    }
    
    // Mostrar modal
    document.getElementById('rfidModal').style.display = 'flex';
    
    // Resetear estados
    resetModal();
    
    // Iniciar verificación
    startRFIDCheck();
}

function validateForm() {
    const form = document.getElementById('prestamoForm');
    const requiredFields = form.querySelectorAll('[required]');
    
    for (let field of requiredFields) {
        if (!field.value.trim()) {
            field.focus();
            return false;
        }
    }
    
    // Validar monto específicamente
    const monto = parseFloat(document.getElementById('monto').value) || 0;
    const capitalDisponible = parseFloat("{{ $capitalDisponible }}");
    
    if (monto > capitalDisponible) {
        alert('El monto excede el capital disponible');
        return false;
    }
    
    return true;
}

function showDeniedPopup(message, uid = '') {
    const popup = document.getElementById('deniedPopup');
    const deniedMessage = document.getElementById('deniedMessage');
    const deniedUID = document.getElementById('deniedUID');
    
    // Configurar mensajes
    deniedMessage.textContent = message;
    
    if (uid) {
        deniedUID.textContent = `UID: ${uid}`;
        deniedUID.style.display = 'block';
    } else {
        deniedUID.style.display = 'none';
    }
    
    // Mostrar pop-up
    popup.style.display = 'block';
    popup.classList.add('show');
    
    // Ocultar automáticamente después de 5 segundos
    setTimeout(hideDeniedPopup, 5000);
}

function hideDeniedPopup() {
    const popup = document.getElementById('deniedPopup');
    if (popup) {
        popup.classList.remove('show');
        setTimeout(() => {
            popup.style.display = 'none';
        }, 400);
    }
}

function closeRFIDModal() {
    document.getElementById('rfidModal').style.display = 'none';
    if (scanInterval) {
        clearInterval(scanInterval);
        scanInterval = null;
    }
}

function resetModal() {
    document.getElementById('rfidStatusWaiting').style.display = 'block';
    document.getElementById('rfidStatusAuthorized').style.display = 'none';
    document.getElementById('rfidStatusError').style.display = 'none';
    document.getElementById('btnContinue').style.display = 'none';
    document.getElementById('btnRetry').style.display = 'none';
}

function startRFIDCheck() {
    if (scanInterval) {
        clearInterval(scanInterval);
    }
    
    // Verificar cada 2 segundos
    scanInterval = setInterval(checkRFIDScan, 2000);
    
    // Primera verificación inmediata
    setTimeout(checkRFIDScan, 500);
}

function checkRFIDScan() {
    if (document.getElementById('rfidModal').style.display !== 'flex') {
        clearInterval(scanInterval);
        return;
    }
    
    fetch('{{ route("rfid.check.scan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ check: true })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta RFID:', data);
        
        if (data.success === true) {
            // Usuario autorizado
            showAuthorized(data.user, data.uid);
        } else if (data.message !== 'Esperando escaneo de tarjeta...') {
            // Error específico - pasar mensaje y UID si está disponible
            showError(data.message, data.uid || '');
        }
    })
    .catch(error => {
        console.error('Error en verificación:', error);
        showError('Error de conexión con el servidor');
    });
}

function showAuthorized(user, uid) {
    // Detener intervalo
    if (scanInterval) {
        clearInterval(scanInterval);
        scanInterval = null;
    }
    
    // Actualizar UI
    document.getElementById('rfidStatusWaiting').style.display = 'none';
    document.getElementById('rfidStatusAuthorized').style.display = 'block';
    
    document.getElementById('authUserName').textContent = user.nombre;
    document.getElementById('authUserRole').textContent = user.rol;
    document.getElementById('authCardUID').textContent = uid;
    
    // Mostrar botón continuar
    document.getElementById('btnContinue').style.display = 'inline-block';
    document.getElementById('btnRetry').style.display = 'none';
    
    // Guardar ID del autorizador en el campo oculto
    document.getElementById('autorizadoPorId').value = user.id;
    
    // NO mostrar pop-up de denegado cuando es exitoso
    hideDeniedPopup();
}

function showError(message, uid = '') {
    // Detener intervalo de escaneo
    if (scanInterval) {
        clearInterval(scanInterval);
        scanInterval = null;
    }
    
    // Actualizar UI del modal
    document.getElementById('rfidStatusWaiting').style.display = 'none';
    document.getElementById('rfidStatusAuthorized').style.display = 'none';
    document.getElementById('rfidStatusError').style.display = 'block';
    
    document.getElementById('errorMessage').textContent = message;
    
    // Mostrar botón reintentar
    document.getElementById('btnContinue').style.display = 'none';
    document.getElementById('btnRetry').style.display = 'inline-block';
    
    // Mostrar pop-up de denegado (solo si hay un mensaje específico)
    if (message !== 'Esperando escaneo de tarjeta...') {
        showDeniedPopup(message, uid);
    }
}

// Continuar con el préstamo
function continueWithLoan() {
    // Limpiar escaneo
    fetch('{{ route("rfid.clear.scan") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    
    // Enviar formulario
    document.getElementById('prestamoForm').submit();
}

// Reintentar escaneo
function retryScan() {
    resetModal();
    startRFIDCheck();
}

// Cancelar verificación
function cancelVerification() {
    if (scanInterval) {
        clearInterval(scanInterval);
        scanInterval = null;
    }
    
    // Limpiar escaneo
    fetch('{{ route("rfid.clear.scan") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    
    // Ocultar modal
    closeRFIDModal();
}

// Validación en tiempo real del monto (funciones originales)
function validarMonto(input) {
    const monto = parseFloat(input.value) || 0;
    const capitalDisponible = parseFloat("{{ $capitalDisponible }}");
    const errorElement = document.getElementById('monto-error');
    const submitBtn = document.getElementById('submit-rfid-btn');
    const capitalRestante = document.getElementById('capital-restante');

    if (monto > capitalDisponible) {
        errorElement.textContent = 'El monto excede el capital disponible';
        errorElement.classList.remove('hidden');
        submitBtn.disabled = true;
    } else {
        errorElement.classList.add('hidden');
        submitBtn.disabled = false;
    }

    // Actualizar capital restante
    const restante = capitalDisponible - monto;
    capitalRestante.textContent = `Capital restante después del préstamo: Bs. ${restante.toLocaleString('es-BO', {minimumFractionDigits: 2})}`;

    // Actualizar resumen
    actualizarResumen();
}

// Calcular número de cuotas
function calcularCuotas() {
    const plazo = parseInt(document.getElementById('plazo_meses').value);
    const frecuencia = document.getElementById('frecuencia_pago').value;
    
    switch(frecuencia) {
        case 'diario': return plazo * 30;
        case 'semanal': return plazo * 4;
        case 'quincenal': return plazo * 2;
        case 'mensual': return plazo;
        default: return plazo;
    }
}

// Actualizar resumen del préstamo
function actualizarResumen() {
    const monto = parseFloat(document.getElementById('monto').value) || 0;
    const tasa = document.getElementById('tasa_interes_mensual').value;
    const plazo = document.getElementById('plazo_meses').value;
    const frecuencia = document.getElementById('frecuencia_pago');
    const frecuenciaText = frecuencia.options[frecuencia.selectedIndex].text;
    const cuotas = calcularCuotas();
    
    document.getElementById('resumen-monto').textContent = 
        `Bs. ${monto.toLocaleString('es-BO', {minimumFractionDigits: 2})}`;
    
    document.getElementById('resumen-interes').textContent = 
        `${tasa}% mensual`;
    
    document.getElementById('resumen-plazo').textContent = 
        `${plazo} meses`;
    
    document.getElementById('resumen-frecuencia').textContent = 
        frecuenciaText;
        
    document.getElementById('resumen-cuotas').textContent = 
        cuotas;
}

// Inicializar eventos
document.addEventListener('DOMContentLoaded', function() {
    // Event listeners para actualizar el resumen
    document.getElementById('tasa_interes_mensual').addEventListener('input', actualizarResumen);
    document.getElementById('plazo_meses').addEventListener('change', actualizarResumen);
    document.getElementById('frecuencia_pago').addEventListener('change', actualizarResumen);
    document.getElementById('monto').addEventListener('input', actualizarResumen);
    
    // Inicializar el resumen al cargar la página
    actualizarResumen();
    
    // Validar monto inicial si hay valor
    const montoInput = document.getElementById('monto');
    if (montoInput.value) {
        validarMonto(montoInput);
    }
});
</script>
@endsection