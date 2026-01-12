@extends('layouts.app')

@section('page-title', 'Detalle de Solicitud: ' . $solicitud->numero_solicitud)

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Solicitud de Crédito</h1>
            <p class="mt-1 text-sm text-slate-600">Detalle completo de la solicitud #{{ $solicitud->numero_solicitud }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.solicitud-credito.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Volver</span>
            </a>
            
            <!-- Dropdown de Acciones -->
            <div class="relative">
                <button id="actions-dropdown-button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                    <span>Acciones</span>
                </button>
                
                <div id="actions-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-slate-200 z-10">
                    <div class="py-1">
                        @if($solicitud->estado == 'pendiente')
                            <a href="{{ route('admin.solicitud-credito.edit', $solicitud->id) }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <button type="button" onclick="openApproveModal()" class="w-full text-left flex items-center px-4 py-2 text-sm text-green-600 hover:bg-green-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Aprobar
                            </button>
                            <button type="button" onclick="openRejectModal()" class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Rechazar
                            </button>
                        @endif
                        @if($solicitud->estaAprobada() && !$solicitud->tienePrestamo())
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="{{ route('admin.solicitud-credito.crear-prestamo', $solicitud->id) }}" class="flex items-center px-4 py-2 text-sm text-blue-600 hover:bg-blue-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Crear Préstamo
                            </a>
                        @endif
                        <div class="border-t border-slate-100 my-1"></div>
                        <a href="{{ route('admin.solicitud-credito.pdf', $solicitud->id) }}" target="_blank" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Generar PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estado y Resumen -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Tarjeta de Estado -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Estado de la Solicitud</h3>
                @if($solicitud->estado == 'pendiente')
                    <span class="px-3 py-1 bg-amber-100 text-amber-800 text-sm font-medium rounded-full">Pendiente</span>
                @elseif($solicitud->estado == 'aprobada')
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">Aprobada</span>
                @else
                    <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">Rechazada</span>
                @endif
            </div>
            
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-slate-600">N° Solicitud</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->numero_solicitud }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Fecha de Solicitud</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->fecha_solicitud->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Oficial de Crédito</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->oficial_credito }}</p>
                </div>
                @if($solicitud->fecha_aprobacion)
                <div>
                    <p class="text-sm text-slate-600">Fecha Aprobación</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->fecha_aprobacion->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Autorizado por</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->autorizado_por }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Información del Cliente -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Información del Cliente</h3>
            
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-slate-600">Nombre Completo</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->usuario->nombre_completo ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">CI</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->usuario->ci ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Producto</p>
                    <p class="font-medium text-slate-900">{{ ucfirst($solicitud->producto) }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Monto Solicitado</p>
                    <p class="font-medium text-slate-900">Bs. {{ number_format($solicitud->monto_solicitado, 2) }}</p>
                </div>
                @if($solicitud->tienePrestamo())
                <div>
                    <p class="text-sm text-slate-600">Préstamo Generado</p>
                    <a href="{{ route('admin.prestamos.show', $solicitud->prestamo_id) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full hover:bg-blue-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Ver Préstamo
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Información de Contacto -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Información de Contacto</h3>
            
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-slate-600">Teléfono Fijo</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->telefono_fijo ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Celular</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->celular_solicitante ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Correo Electrónico</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->correo_solicitante ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Domicilio</p>
                    <p class="font-medium text-slate-900">{{ $solicitud->domicilio ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas de Detalle -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <!-- Navegación de pestañas -->
        <div class="border-b border-slate-200">
            <nav class="flex space-x-1 overflow-x-auto" id="detail-tabs">
                <button type="button" data-tab="datos" class="tab-detail-button flex items-center px-4 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent transition-all duration-200 whitespace-nowrap active">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Datos Personales
                </button>
                <button type="button" data-tab="laboral" class="tab-detail-button flex items-center px-4 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent transition-all duration-200 whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Datos Laborales
                </button>
                <button type="button" data-tab="deudas" class="tab-detail-button flex items-center px-4 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent transition-all duration-200 whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Deudas
                </button>
                <button type="button" data-tab="documentos" class="tab-detail-button flex items-center px-4 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent transition-all duration-200 whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Documentos
                </button>
            </nav>
        </div>

        <!-- Contenido de pestañas -->
        <div class="p-6">
            <!-- DATOS PERSONALES -->
            <div id="datos-content" class="tab-detail-content active">
                <!-- Encabezado -->
                <div class="mb-6">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">I. DATOS GENERALES DEL SOLICITANTE</h3>
                            <p class="text-sm text-slate-600">Información personal básica del solicitante</p>
                        </div>
                    </div>
                </div>

                <!-- Información personal en tabla -->
                <div class="overflow-hidden rounded-lg border border-slate-200 mb-6">
                    <table class="min-w-full divide-y divide-slate-200">
                        <tbody class="bg-white divide-y divide-slate-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50 w-1/3">
                                    Nombre Completo
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $solicitud->usuario->nombre_completo ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    CI
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $solicitud->usuario->ci ?? 'N/A' }} 
                                    @if($solicitud->usuario->expedido)
                                        Exp: {{ $solicitud->usuario->expedido }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    Fecha Nacimiento
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $solicitud->fecha_nacimiento ? $solicitud->fecha_nacimiento->format('d/m/Y') : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    Edad
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $solicitud->edad ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    Estado Civil
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $solicitud->estado_civil ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    Teléfono Fijo
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $solicitud->telefono_fijo ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    Celular
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $solicitud->celular_solicitante ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    Domicilio
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $solicitud->domicilio ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    Tipo de Vivienda
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ ucfirst($solicitud->tipo_vivienda ?? 'N/A') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    Monto Vivienda
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $solicitud->monto_vivienda ? 'Bs. ' . number_format($solicitud->monto_vivienda, 2) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    Tiempo en la Vivienda
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    @if($solicitud->tiempo_permanencia_anios || $solicitud->tiempo_permanencia_meses)
                                        {{ $solicitud->tiempo_permanencia_anios ?? 0 }} años 
                                        {{ $solicitud->tiempo_permanencia_meses ?? 0 }} meses
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                    Correo Electrónico
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $solicitud->correo_solicitante ?? 'N/A' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Cónyuge -->
                @if($solicitud->conyuge_nombre_completo)
                <div class="mb-6">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">II. DATOS PERSONALES DEL CÓNYUGE</h3>
                            <p class="text-sm text-slate-600">Información del cónyuge del solicitante</p>
                        </div>
                    </div>
                    
                    <div class="overflow-hidden rounded-lg border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200">
                            <tbody class="bg-white divide-y divide-slate-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50 w-1/3">
                                        Nombre Completo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->conyuge_nombre_completo }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        CI
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->conyuge_ci }} 
                                        @if($solicitud->conyuge_expedido)
                                            Exp: {{ $solicitud->conyuge_expedido }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Fecha Nacimiento
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->conyuge_fecha_nacimiento ? $solicitud->conyuge_fecha_nacimiento->format('d/m/Y') : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Edad
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->conyuge_edad ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Estado Civil
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->conyuge_estado_civil ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Teléfono Fijo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->conyuge_telefono_fijo ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Celular
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->conyuge_celular ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Domicilio
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->conyuge_domicilio ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Tipo de Vivienda
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ ucfirst($solicitud->conyuge_tipo_vivienda ?? 'N/A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Monto Vivienda
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->conyuge_monto_vivienda ? 'Bs. ' . number_format($solicitud->conyuge_monto_vivienda, 2) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Correo Electrónico
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->conyuge_correo ?? 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Garante -->
                @if($solicitud->garante_nombre_completo)
                <div class="mb-6">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">III. DATOS DEL GARANTE</h3>
                            <p class="text-sm text-slate-600">Información del garante del crédito</p>
                        </div>
                    </div>
                    
                    <div class="overflow-hidden rounded-lg border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200">
                            <tbody class="bg-white divide-y divide-slate-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50 w-1/3">
                                        Nombre Completo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->garante_nombre_completo }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        CI
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->garante_ci }} 
                                        @if($solicitud->garante_expedido)
                                            Exp: {{ $solicitud->garante_expedido }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Fecha Nacimiento
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->garante_fecha_nacimiento ? $solicitud->garante_fecha_nacimiento->format('d/m/Y') : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Edad
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->garante_edad ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Estado Civil
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->garante_estado_civil ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Teléfono Fijo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->garante_telefono_fijo ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Celular
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->garante_celular ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Domicilio
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->garante_domicilio ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Tipo de Vivienda
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ ucfirst($solicitud->garante_tipo_vivienda ?? 'N/A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Monto Vivienda
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->garante_monto_vivienda ? 'Bs. ' . number_format($solicitud->garante_monto_vivienda, 2) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Correo Electrónico
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $solicitud->garante_correo ?? 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <!-- DATOS LABORALES -->
            <div id="laboral-content" class="tab-detail-content hidden">
                @if($solicitud->datos_laborales)
                    @php $lab = $solicitud->datos_laborales; @endphp
                    
                    <!-- Encabezado -->
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">IV. DATOS LABORALES</h3>
                                <p class="text-sm text-slate-600">Información laboral y económica del solicitante</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información laboral -->
                    <div class="overflow-hidden rounded-lg border border-slate-200 mb-6">
                        <table class="min-w-full divide-y divide-slate-200">
                            <tbody class="bg-white divide-y divide-slate-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50 w-1/3">
                                        Tipo de Empleo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ ucfirst($lab['tipo'] ?? 'N/A') }}
                                    </td>
                                </tr>
                                
                                @if($lab['tipo'] == 'dependiente')
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Profesión u Ocupación
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $lab['profesion_ocupacion'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Empresa
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $lab['empresa_trabaja'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Cargo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $lab['cargo_desempena'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Fecha de Ingreso
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ isset($lab['fecha_ingreso']) ? \Carbon\Carbon::parse($lab['fecha_ingreso'])->format('d/m/Y') : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Fecha Pago Sueldo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $lab['fecha_pago_sueldo'] ? 'Día ' . $lab['fecha_pago_sueldo'] : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Salario Actual
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ isset($lab['salario_actual']) ? 'Bs. ' . number_format($lab['salario_actual'], 2) : 'N/A' }}
                                    </td>
                                </tr>
                                @elseif($lab['tipo'] == 'independiente')
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Descripción del Negocio
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $lab['descripcion_negocio'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Dirección del Negocio
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $lab['direccion_negocio'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Antigüedad del Negocio
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $lab['antiguedad_negocio'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Teléfono del Negocio
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $lab['telefono_negocio'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                        Ingreso Promedio Mensual
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ isset($lab['ingreso_promedio_mes']) ? 'Bs. ' . number_format($lab['ingreso_promedio_mes'], 2) : 'N/A' }}
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Flujo de efectivo -->
                    @if(isset($lab['ingresos_gastos']))
                    <div class="mb-6">
                        <h4 class="text-md font-semibold text-slate-800 mb-4">Flujo de Efectivo Mensual</h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Ingresos -->
                            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="font-semibold text-blue-800">INGRESOS</h5>
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-blue-700">Ventas</p>
                                        <p class="text-lg font-medium text-blue-900">Bs. {{ number_format($lab['ingresos_gastos']['ventas'] ?? 0, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-blue-700">Otros Ingresos</p>
                                        <p class="text-lg font-medium text-blue-900">Bs. {{ number_format($lab['ingresos_gastos']['otros_ingresos'] ?? 0, 2) }}</p>
                                    </div>
                                    <div class="pt-3 border-t border-blue-200">
                                        <p class="text-sm font-medium text-blue-800">Total Ingresos</p>
                                        <p class="text-xl font-bold text-blue-900">Bs. {{ number_format($lab['ingresos_gastos']['total_ingresos'] ?? 0, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Gastos -->
                            <div class="bg-amber-50 p-6 rounded-lg border border-amber-200">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="font-semibold text-amber-800">GASTOS</h5>
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-amber-700">Canasta Familiar</p>
                                        <p class="text-lg font-medium text-amber-900">Bs. {{ number_format($lab['ingresos_gastos']['canasta_familiar'] ?? 0, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-amber-700">Vaticos</p>
                                        <p class="text-lg font-medium text-amber-900">Bs. {{ number_format($lab['ingresos_gastos']['vaticos'] ?? 0, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-amber-700">Servicios Básicos</p>
                                        <p class="text-lg font-medium text-amber-900">Bs. {{ number_format($lab['ingresos_gastos']['servicios_basicos'] ?? 0, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-amber-700">Alquiler</p>
                                        <p class="text-lg font-medium text-amber-900">Bs. {{ number_format($lab['ingresos_gastos']['alquiler'] ?? 0, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-amber-700">Otros Gastos</p>
                                        <p class="text-lg font-medium text-amber-900">Bs. {{ number_format($lab['ingresos_gastos']['otros_gastos'] ?? 0, 2) }}</p>
                                    </div>
                                    <div class="pt-3 border-t border-amber-200">
                                        <p class="text-sm font-medium text-amber-800">Total Gastos</p>
                                        <p class="text-xl font-bold text-amber-900">Bs. {{ number_format($lab['ingresos_gastos']['total_gastos'] ?? 0, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Solicitud de Crédito -->
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">VI. SOLICITUD DE CRÉDITO</h3>
                                <p class="text-sm text-slate-600">Detalles de la solicitud de financiamiento</p>
                            </div>
                        </div>
                        
                        <div class="overflow-hidden rounded-lg border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200">
                                <tbody class="bg-white divide-y divide-slate-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50 w-1/3">
                                            Monto Solicitado
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                            Bs. {{ number_format($solicitud->monto_solicitado, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                            Moneda
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                            {{ $solicitud->moneda }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                            Monto en Letras
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                            {{ $solicitud->monto_literal ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                            Tipo de Cambio
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                            {{ $solicitud->tipo_cambio ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                            Objetivo del Crédito
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                            {{ $solicitud->objetivo_credito ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 bg-slate-50">
                                            Autorización Buró
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                            @if($solicitud->autorizacion_buro)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Sí autoriza</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">No autoriza</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r">
                    <div class="flex">
                        <svg class="w-5 h-5 text-amber-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-amber-800">No se registraron datos laborales.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- DEUDAS -->
            <div id="deudas-content" class="tab-detail-content hidden">
                <!-- Encabezado -->
                <div class="mb-6">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">V. DEUDAS EN OTRAS INSTITUCIONES</h3>
                            <p class="text-sm text-slate-600">Deudas registradas en otras instituciones financieras</p>
                        </div>
                    </div>
                </div>

                @if($solicitud->deudas->count() > 0)
                <div class="overflow-hidden rounded-lg border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                    Institución
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                    Monto (Bs.)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @php $totalDeudas = 0; @endphp
                            @foreach($solicitud->deudas as $index => $deuda)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    {{ $deuda->institucion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    Bs. {{ number_format($deuda->monto, 2) }}
                                </td>
                            </tr>
                            @php $totalDeudas += $deuda->monto; @endphp
                            @endforeach
                            <tr class="bg-blue-50">
                                <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 text-right">
                                    TOTAL DEUDAS:
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">
                                    Bs. {{ number_format($totalDeudas, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-blue-800">No se registraron deudas en otras instituciones.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- DOCUMENTOS -->
            <div id="documentos-content" class="tab-detail-content hidden">
                <!-- Encabezado -->
                <div class="mb-6">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">DOCUMENTOS ADJUNTOS</h3>
                            <p class="text-sm text-slate-600">Documentos de respaldo adjuntos a la solicitud</p>
                        </div>
                    </div>
                </div>

                @if($solicitud->archivos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($solicitud->archivos as $archivo)
                    <div class="bg-white rounded-lg border border-slate-200 p-4 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start space-x-3">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $archivo->nombre_archivo }}</p>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ strtoupper($archivo->tipo) }}
                                </p>
                                <div class="mt-3">
                                    <a href="{{ Storage::url($archivo->ruta) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full hover:bg-blue-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Descargar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-blue-800">No se adjuntaron documentos.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Aprobar (Tailwind) -->
<div id="approveModal" class="hidden fixed inset-0 bg-slate-500 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Aprobar Solicitud</h3>
        </div>
        <form action="{{ route('admin.solicitud-credito.aprobar', $solicitud->id) }}" method="POST">
            @csrf
             @method('PUT')
            <div class="px-6 py-4">
                <p class="text-slate-700 mb-4">¿Está seguro de aprobar esta solicitud de crédito?</p>
                <div class="space-y-2 mb-4">
                    <p><strong class="text-slate-900">Cliente:</strong> {{ $solicitud->usuario->nombre_completo }}</p>
                    <p><strong class="text-slate-900">Monto:</strong> Bs. {{ number_format($solicitud->monto_solicitado, 2) }}</p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                <button type="button" onclick="closeApproveModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">
                    Aprobar Solicitud
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Rechazar (Tailwind) -->
<div id="rejectModal" class="hidden fixed inset-0 bg-slate-500 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Rechazar Solicitud</h3>
        </div>
        <form action="{{ route('admin.solicitud-credito.rechazar', $solicitud->id) }}" method="POST">
            @csrf
             @method('PUT')
            <div class="px-6 py-4">
                <p class="text-slate-700 mb-4">¿Está seguro de rechazar esta solicitud de crédito?</p>
                <div class="space-y-2">
                    <label for="motivo_rechazo" class="block text-sm font-medium text-slate-700">Motivo del Rechazo *</label>
                    <textarea name="motivo_rechazo" id="motivo_rechazo" class="w-full px-3 py-2 border border-slate-300 rounded-lg" rows="4" required placeholder="Describa el motivo del rechazo..."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium">
                    Rechazar Solicitud
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de pestañas de detalle
    const tabButtons = document.querySelectorAll('.tab-detail-button');
    const tabContents = document.querySelectorAll('.tab-detail-content');

    function showDetailTab(tabId) {
        // Ocultar todos los contenidos
        tabContents.forEach(content => {
            content.classList.remove('active');
            content.classList.add('hidden');
        });

        // Desactivar todos los botones
        tabButtons.forEach(button => {
            button.classList.remove('active', 'border-blue-500', 'text-blue-700');
            button.classList.add('text-slate-500', 'hover:text-slate-700');
        });

        // Mostrar contenido actual
        document.getElementById(`${tabId}-content`).classList.remove('hidden');
        document.getElementById(`${tabId}-content`).classList.add('active');

        // Activar botón actual
        const currentButton = document.querySelector(`[data-tab="${tabId}"]`);
        currentButton.classList.remove('text-slate-500', 'hover:text-slate-700');
        currentButton.classList.add('active', 'border-blue-500', 'text-blue-700');
    }

    // Navegación por clic en pestañas
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            showDetailTab(button.dataset.tab);
        });
    });

    // Dropdown de acciones
    const actionsButton = document.getElementById('actions-dropdown-button');
    const actionsDropdown = document.getElementById('actions-dropdown');

    if (actionsButton) {
        actionsButton.addEventListener('click', function(e) {
            e.stopPropagation();
            actionsDropdown.classList.toggle('hidden');
        });

        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!actionsButton.contains(e.target) && !actionsDropdown.contains(e.target)) {
                actionsDropdown.classList.add('hidden');
            }
        });
    }
});

// Funciones para modales
function openApproveModal() {
    document.getElementById('approveModal').classList.remove('hidden');
    document.getElementById('actions-dropdown').classList.add('hidden');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
}

function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('actions-dropdown').classList.add('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Cerrar modales al hacer clic fuera
document.addEventListener('click', function(e) {
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');
    
    if (approveModal && !approveModal.contains(e.target) && approveModal.classList.contains('hidden') === false) {
        if (!e.target.closest('[onclick*="openApproveModal"]')) {
            closeApproveModal();
        }
    }
    
    if (rejectModal && !rejectModal.contains(e.target) && rejectModal.classList.contains('hidden') === false) {
        if (!e.target.closest('[onclick*="openRejectModal"]')) {
            closeRejectModal();
        }
    }
});

// Cerrar modales con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeApproveModal();
        closeRejectModal();
    }
});
</script>

<style>
.tab-detail-button {
    border-bottom-width: 2px;
    border-bottom-style: solid;
}

.tab-detail-button.active {
    border-bottom-color: #3b82f6;
    color: #1d4ed8;
    background-color: #eff6ff;
}

.tab-detail-button:not(.active):hover {
    border-bottom-color: #cbd5e1;
}

.tab-detail-content {
    display: none;
}

.tab-detail-content.active {
    display: block;
}
</style>
@endsection