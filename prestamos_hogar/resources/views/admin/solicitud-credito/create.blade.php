@extends('layouts.app')

@section('page-title', 'Nueva Solicitud de Crédito')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Nueva Solicitud de Crédito</h1>
            <p class="mt-1 text-sm text-slate-600">Complete toda la información para registrar una nueva solicitud de crédito</p>
        </div>
        <a href="{{ route('admin.solicitud-credito.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Volver</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.solicitud-credito.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Pestañas -->
            <div class="border-b border-slate-200">
                <nav class="flex space-x-1 overflow-x-auto" aria-label="Tabs">
                    <button type="button" data-tab="datos-generales" class="tab-button flex items-center px-4 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent transition-all duration-200 whitespace-nowrap active">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Datos Generales
                    </button>
                    <button type="button" data-tab="conyuge" class="tab-button flex items-center px-4 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent transition-all duration-200 whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Cónyuge
                    </button>
                    <button type="button" data-tab="garante" class="tab-button flex items-center px-4 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent transition-all duration-200 whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Garante
                    </button>
                    <button type="button" data-tab="laboral" class="tab-button flex items-center px-4 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent transition-all duration-200 whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Datos Laborales
                    </button>
                    <button type="button" data-tab="credito" class="tab-button flex items-center px-4 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent transition-all duration-200 whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Solicitud de Crédito
                    </button>
                    <button type="button" data-tab="documentos" class="tab-button flex items-center px-4 py-3 text-sm font-medium rounded-t-lg border-b-2 border-transparent transition-all duration-200 whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Documentos
                    </button>
                </nav>
            </div>

            <!-- Contenido del formulario -->
            <div class="p-6 space-y-6">
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

                <!-- DATOS GENERALES -->
                <div id="datos-generales-content" class="tab-content active">
                    <!-- Encabezado de sección -->
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

                    <!-- Campos superiores -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Oficial de Crédito *</label>
                            <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg bg-slate-50" value="{{ $oficialCredito ?? auth()->user()->nombre_completo }}" readonly>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Fecha de Solicitud *</label>
                            <input type="date" name="fecha_solicitud" class="w-full px-3 py-2 border border-slate-300 rounded-lg" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Producto *</label>
                            <select name="producto" class="w-full px-3 py-2 border border-slate-300 rounded-lg" required>
                                <option value="">Seleccionar...</option>
                                <option value="mensual">Mensual</option>
                                <option value="semanal">Semanal</option>
                                <option value="diario">Diario</option>
                            </select>
                        </div>
                    </div>

                    <!-- Cliente -->
                    <div class="space-y-2 mb-6">
                        <label class="block text-sm font-medium text-slate-700">Cliente *</label>
                        <select name="usuario_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg" required>
                            <option value="">Seleccionar cliente...</option>
                            @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">
                                {{ $usuario->nombre_completo }} - CI: {{ $usuario->ci }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Información personal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Edad</label>
                            <input type="number" name="edad" class="w-full px-3 py-2 border border-slate-300 rounded-lg" min="18" max="100">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Estado Civil</label>
                            <input type="text" name="estado_civil" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: Soltero, Casado">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Teléfono Fijo</label>
                            <input type="text" name="telefono_fijo" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: 22123456">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Celular</label>
                            <input type="text" name="celular_solicitante" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: 71234567">
                        </div>
                    </div>

                    <div class="space-y-2 mb-6">
                        <label class="block text-sm font-medium text-slate-700">Domicilio (Zona, Calle, Número)</label>
                        <textarea name="domicilio" class="w-full px-3 py-2 border border-slate-300 rounded-lg" rows="2"></textarea>
                    </div>

                    <!-- Información de vivienda -->
                    <div class="bg-slate-50 p-4 rounded-lg mb-6">
                        <h4 class="text-md font-semibold text-slate-800 mb-3">Información de Vivienda</h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Tipo de Vivienda</label>
                                <select name="tipo_vivienda" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                                    <option value="">Seleccionar...</option>
                                    <option value="propia">Propia</option>
                                    <option value="alquiler">Alquiler</option>
                                    <option value="familiar">Familiar</option>
                                    <option value="anticretico">Anticretico</option>
                                    <option value="otra">Otra</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Monto Bs.</label>
                                <input type="number" name="monto_vivienda" class="w-full px-3 py-2 border border-slate-300 rounded-lg" step="0.01" min="0">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Tiempo (Años)</label>
                                <input type="number" name="tiempo_permanencia_anios" class="w-full px-3 py-2 border border-slate-300 rounded-lg" min="0">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Tiempo (Meses)</label>
                                <input type="number" name="tiempo_permanencia_meses" class="w-full px-3 py-2 border border-slate-300 rounded-lg" min="0" max="11">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700">Correo Electrónico</label>
                        <input type="email" name="correo_solicitante" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                    </div>
                </div>

               <!-- CONYUGE -->
<div id="conyuge-content" class="tab-content hidden">
    <!-- Encabezado -->
    <div class="mb-6">
        <div class="flex items-center space-x-3 mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-slate-900">II. DATOS PERSONALES DEL CÓNYUGE</h3>
                <p class="text-sm text-slate-600">Información del cónyuge del solicitante (opcional)</p>
            </div>
        </div>
    </div>

    <!-- Información personal del cónyuge -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Nombre Completo</label>
            <input type="text" name="conyuge_nombre_completo" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">CI</label>
            <div class="grid grid-cols-3 gap-2">
                <input type="text" name="conyuge_ci" class="col-span-2 px-3 py-2 border border-slate-300 rounded-lg" placeholder="Número">
                <input type="text" name="conyuge_expedido" class="px-3 py-2 border border-slate-300 rounded-lg" placeholder="Exp." maxlength="5">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Fecha de Nacimiento</label>
            <input type="date" name="conyuge_fecha_nacimiento" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Edad</label>
            <input type="number" name="conyuge_edad" class="w-full px-3 py-2 border border-slate-300 rounded-lg" min="0">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Estado Civil</label>
            <input type="text" name="conyuge_estado_civil" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: Soltero, Casado">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Teléfono Fijo</label>
            <input type="text" name="conyuge_telefono_fijo" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: 22123456">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Celular</label>
            <input type="text" name="conyuge_celular" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: 71234567">
        </div>
    </div>

    <div class="space-y-2 mb-6">
        <label class="block text-sm font-medium text-slate-700">Domicilio (Zona, Calle, Número)</label>
        <textarea name="conyuge_domicilio" class="w-full px-3 py-2 border border-slate-300 rounded-lg" rows="2"></textarea>
    </div>

    <!-- Información de vivienda del cónyuge -->
    <div class="bg-slate-50 p-4 rounded-lg mb-6">
        <h4 class="text-md font-semibold text-slate-800 mb-3">Información de Vivienda del Cónyuge</h4>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700">Tipo de Vivienda</label>
                <select name="conyuge_tipo_vivienda" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                    <option value="">Seleccionar...</option>
                    <option value="propia">Propia</option>
                    <option value="alquiler">Alquiler</option>
                    <option value="familiar">Familiar</option>
                    <option value="anticretico">Anticretico</option>
                    <option value="otra">Otra</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700">Monto Bs.</label>
                <input type="number" name="conyuge_monto_vivienda" class="w-full px-3 py-2 border border-slate-300 rounded-lg" step="0.01" min="0">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700">Tiempo (Años)</label>
                <input type="number" name="conyuge_tiempo_permanencia_anios" class="w-full px-3 py-2 border border-slate-300 rounded-lg" min="0">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700">Tiempo (Meses)</label>
                <input type="number" name="conyuge_tiempo_permanencia_meses" class="w-full px-3 py-2 border border-slate-300 rounded-lg" min="0" max="11">
            </div>
        </div>
    </div>

    <div class="space-y-2">
        <label class="block text-sm font-medium text-slate-700">Correo Electrónico</label>
        <input type="email" name="conyuge_correo" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
    </div>
</div>

                <!-- GARANTE -->
<div id="garante-content" class="tab-content hidden">
    <!-- Encabezado -->
    <div class="mb-6">
        <div class="flex items-center space-x-3 mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-slate-900">III. DATOS DEL GARANTE</h3>
                <p class="text-sm text-slate-600">Información del garante del crédito (opcional)</p>
            </div>
        </div>
    </div>

    <!-- Información personal del garante -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Nombre Completo</label>
            <input type="text" name="garante_nombre_completo" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">CI</label>
            <div class="grid grid-cols-3 gap-2">
                <input type="text" name="garante_ci" class="col-span-2 px-3 py-2 border border-slate-300 rounded-lg" placeholder="Número">
                <input type="text" name="garante_expedido" class="px-3 py-2 border border-slate-300 rounded-lg" placeholder="Exp." maxlength="5">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Fecha de Nacimiento</label>
            <input type="date" name="garante_fecha_nacimiento" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Edad</label>
            <input type="number" name="garante_edad" class="w-full px-3 py-2 border border-slate-300 rounded-lg" min="0">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Estado Civil</label>
            <input type="text" name="garante_estado_civil" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: Soltero, Casado">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Teléfono Fijo</label>
            <input type="text" name="garante_telefono_fijo" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: 22123456">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">Celular</label>
            <input type="text" name="garante_celular" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: 71234567">
        </div>
    </div>

    <div class="space-y-2 mb-6">
        <label class="block text-sm font-medium text-slate-700">Domicilio (Zona, Calle, Número)</label>
        <textarea name="garante_domicilio" class="w-full px-3 py-2 border border-slate-300 rounded-lg" rows="2"></textarea>
    </div>

    <!-- Información de vivienda del garante -->
    <div class="bg-slate-50 p-4 rounded-lg mb-6">
        <h4 class="text-md font-semibold text-slate-800 mb-3">Información de Vivienda del Garante</h4>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700">Tipo de Vivienda</label>
                <select name="garante_tipo_vivienda" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                    <option value="">Seleccionar...</option>
                    <option value="propia">Propia</option>
                    <option value="alquiler">Alquiler</option>
                    <option value="familiar">Familiar</option>
                    <option value="anticretico">Anticretico</option>
                    <option value="otra">Otra</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700">Monto Bs.</label>
                <input type="number" name="garante_monto_vivienda" class="w-full px-3 py-2 border border-slate-300 rounded-lg" step="0.01" min="0">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700">Tiempo (Años)</label>
                <input type="number" name="garante_tiempo_permanencia_anios" class="w-full px-3 py-2 border border-slate-300 rounded-lg" min="0">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700">Tiempo (Meses)</label>
                <input type="number" name="garante_tiempo_permanencia_meses" class="w-full px-3 py-2 border border-slate-300 rounded-lg" min="0" max="11">
            </div>
        </div>
    </div>

    <div class="space-y-2">
        <label class="block text-sm font-medium text-slate-700">Correo Electrónico</label>
        <input type="email" name="garante_correo" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
    </div>
</div>

                <!-- DATOS LABORALES -->
                <div id="laboral-content" class="tab-content hidden">
                    <!-- Encabezado -->
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">IV. DATOS LABORALES DEL SOLICITANTE</h3>
                                <p class="text-sm text-slate-600">Información sobre la situación laboral del solicitante</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tipo de empleo -->
                    <div class="space-y-2 mb-6">
                        <label class="block text-sm font-medium text-slate-700">Tipo de Empleo *</label>
                        <select name="tipo_laboral" id="tipo_laboral" class="w-full px-3 py-2 border border-slate-300 rounded-lg" required>
                            <option value="">Seleccionar...</option>
                            <option value="dependiente">Dependiente</option>
                            <option value="independiente">Independiente</option>
                        </select>
                    </div>

                    <!-- Campos dependiente -->
                    <div id="dependiente-fields" class="hidden mb-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Profesión u Ocupación</label>
                                <input type="text" name="profesion_ocupacion" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Empresa en la que Trabaja</label>
                                <input type="text" name="empresa_trabaja" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Cargo que Desempeña</label>
                                <input type="text" name="cargo_desempena" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Fecha de Ingreso</label>
                                <input type="date" name="fecha_ingreso" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Fecha de Pago de Sueldo (día del mes)</label>
                                <input type="number" name="fecha_pago_sueldo" class="w-full px-3 py-2 border border-slate-300 rounded-lg" min="1" max="31">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Salario Actual (Bs.)</label>
                                <input type="number" name="salario_actual" class="w-full px-3 py-2 border border-slate-300 rounded-lg" step="0.01" min="0">
                            </div>
                        </div>
                    </div>

                    <!-- Campos independiente -->
                    <div id="independiente-fields" class="hidden mb-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Descripción del Negocio</label>
                                <textarea name="descripcion_negocio" class="w-full px-3 py-2 border border-slate-300 rounded-lg" rows="2"></textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Dirección</label>
                                <textarea name="direccion_negocio" class="w-full px-3 py-2 border border-slate-300 rounded-lg" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Antigüedad del Negocio</label>
                                <input type="text" name="antiguedad_negocio" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: 2 años">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Teléfono del Negocio</label>
                                <input type="text" name="telefono_negocio" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Ingreso Promedio por Mes (Bs.)</label>
                            <input type="number" name="ingreso_promedio_mes" class="w-full px-3 py-2 border border-slate-300 rounded-lg" step="0.01" min="0">
                        </div>
                    </div>

                    <!-- Flujo de efectivo -->
                    <div class="mb-6">
                        <h4 class="text-md font-semibold text-slate-800 mb-3">Flujo de Efectivo Mensual</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Ingresos -->
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="font-medium text-blue-800">INGRESOS</h5>
                                </div>
                                <div class="space-y-3">
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-blue-700">Ventas (Bs.)</label>
                                        <input type="number" name="ventas" class="w-full px-3 py-2 border border-blue-300 rounded-lg" step="0.01" min="0">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-blue-700">Otros Ingresos (Bs.)</label>
                                        <input type="number" name="otros_ingresos" class="w-full px-3 py-2 border border-blue-300 rounded-lg" step="0.01" min="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Gastos -->
                            <div class="bg-amber-50 p-4 rounded-lg border border-amber-200">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-2">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="font-medium text-amber-800">GASTOS</h5>
                                </div>
                                <div class="space-y-3">
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-amber-700">Canasta Familiar (Bs.)</label>
                                        <input type="number" name="canasta_familiar" class="w-full px-3 py-2 border border-amber-300 rounded-lg" step="0.01" min="0">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-amber-700">Vaticos (Bs.)</label>
                                        <input type="number" name="vaticos" class="w-full px-3 py-2 border border-amber-300 rounded-lg" step="0.01" min="0">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-amber-700">Servicios Básicos (Bs.)</label>
                                        <input type="number" name="servicios_basicos" class="w-full px-3 py-2 border border-amber-300 rounded-lg" step="0.01" min="0">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-amber-700">Alquiler (Bs.)</label>
                                        <input type="number" name="alquiler" class="w-full px-3 py-2 border border-amber-300 rounded-lg" step="0.01" min="0">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-amber-700">Otros Gastos (Bs.)</label>
                                        <input type="number" name="otros_gastos" class="w-full px-3 py-2 border border-amber-300 rounded-lg" step="0.01" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deudas -->
                    <div class="mb-6">
                        <h4 class="text-md font-semibold text-slate-800 mb-3">V. DEUDAS EN OTRAS INSTITUCIONES</h4>
                        <div id="deudas-container" class="space-y-3">
                            <div class="deuda-item flex items-center space-x-3">
                                <input type="text" name="deudas[0][institucion]" class="flex-1 px-3 py-2 border border-slate-300 rounded-lg" placeholder="Institución (Ej: Banco, Cooperativa)">
                                <input type="number" name="deudas[0][monto]" class="w-32 px-3 py-2 border border-slate-300 rounded-lg" step="0.01" min="0" placeholder="Monto (Bs.)">
                                <button type="button" class="remove-deuda bg-red-100 text-red-600 hover:bg-red-200 px-3 py-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="add-deuda" class="mt-3 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Agregar Deuda</span>
                        </button>
                    </div>
                </div>

                <!-- SOLICITUD DE CRÉDITO -->
                <div id="credito-content" class="tab-content hidden">
                    <!-- Encabezado -->
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
                    </div>

                    <!-- Monto solicitado -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Monto Solicitado (Bs.) *</label>
                            <input type="number" name="monto_solicitado" class="w-full px-3 py-2 border border-slate-300 rounded-lg" step="0.01" min="100" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Moneda *</label>
                            <select name="moneda" class="w-full px-3 py-2 border border-slate-300 rounded-lg" required>
                                <option value="BS" selected>Bolivianos (BS)</option>
                                <option value="USD">Dólares (USD)</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Tipo de Cambio</label>
                            <input type="number" name="tipo_cambio" class="w-full px-3 py-2 border border-slate-300 rounded-lg" step="0.0001" min="0">
                        </div>
                    </div>

                    <div class="space-y-2 mb-6">
                        <label class="block text-sm font-medium text-slate-700">Monto en Letras</label>
                        <input type="text" name="monto_literal" class="w-full px-3 py-2 border border-slate-300 rounded-lg" placeholder="Ej: Mil quinientos bolivianos">
                    </div>

                    <div class="space-y-2 mb-6">
                        <label class="block text-sm font-medium text-slate-700">Objetivo del Crédito</label>
                        <textarea name="objetivo_credito" class="w-full px-3 py-2 border border-slate-300 rounded-lg" rows="3" placeholder="Describa para qué utilizará el crédito..."></textarea>
                    </div>

                    <!-- Términos y condiciones -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h4 class="text-md font-semibold text-blue-800 mb-3">VII. TÉRMINOS Y CONDICIONES</h4>
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="autorizacion_buro" id="autorizacion_buro" class="mt-1" value="1" required>
                            <label for="autorizacion_buro" class="text-sm text-slate-700">
                                Autorizo a TIENDA HOGAR para solicitar información sobre mis antecedentes crediticios 
                                y otras cuentas por pagar registrados en el Buró de Información, mientras dure la 
                                relación contractual. Asimismo autorizo a incorporar los datos crediticios y de otras 
                                cuentas por pagar derivados de la relación en la base de datos de propiedad de los 
                                burós de información.
                            </label>
                        </div>
                    </div>
                </div>

                <!-- DOCUMENTOS -->
                <div id="documentos-content" class="tab-content hidden">
                    <!-- Encabezado -->
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">DOCUMENTOS ADJUNTOS</h3>
                                <p class="text-sm text-slate-600">Adjunte documentos de respaldo para la solicitud</p>
                            </div>
                        </div>
                    </div>

                    <!-- Mensaje informativo -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-blue-800">
                                    Puede adjuntar documentos como: CI, comprobantes de ingresos, servicios básicos, etc.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Archivos -->
                    <div id="archivos-container" class="space-y-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Archivo 1</label>
                            <div class="relative">
                                <input type="file" name="archivos[]" class="w-full px-3 py-2 border border-slate-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100">
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-archivo" class="mt-3 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Agregar otro archivo</span>
                    </button>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex items-center justify-between px-6 py-4 border-t border-slate-200">
                <div class="flex items-center space-x-2">
                    <button type="button" id="prev-tab" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium">
                        Anterior
                    </button>
                    <button type="button" id="next-tab" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                        Siguiente
                    </button>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.solicitud-credito.index') }}" class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Guardar Solicitud</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de pestañas
    const tabs = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    const prevBtn = document.getElementById('prev-tab');
    const nextBtn = document.getElementById('next-tab');
    const tabOrder = ['datos-generales', 'conyuge', 'garante', 'laboral', 'credito', 'documentos'];
    let currentTabIndex = 0;

    function showTab(index) {
        // Ocultar todos los contenidos
        tabContents.forEach(content => {
            content.classList.remove('active');
            content.classList.add('hidden');
        });

        // Desactivar todas las pestañas
        tabs.forEach(tab => {
            tab.classList.remove('active', 'border-blue-500', 'text-blue-700');
            tab.classList.add('text-slate-500', 'hover:text-slate-700');
        });

        // Mostrar contenido actual
        const currentTabId = tabOrder[index];
        document.getElementById(`${currentTabId}-content`).classList.remove('hidden');
        document.getElementById(`${currentTabId}-content`).classList.add('active');

        // Activar pestaña actual
        const currentTab = document.querySelector(`[data-tab="${currentTabId}"]`);
        currentTab.classList.remove('text-slate-500', 'hover:text-slate-700');
        currentTab.classList.add('active', 'border-blue-500', 'text-blue-700');

        // Actualizar botones
        prevBtn.disabled = index === 0;
        nextBtn.textContent = index === tabOrder.length - 1 ? 'Finalizar' : 'Siguiente';
        
        currentTabIndex = index;
    }

    // Navegación por clic en pestañas
    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            currentTabIndex = tabOrder.indexOf(tab.dataset.tab);
            showTab(currentTabIndex);
        });
    });

    // Botón siguiente
    nextBtn.addEventListener('click', () => {
        if (currentTabIndex < tabOrder.length - 1) {
            showTab(currentTabIndex + 1);
        } else {
            // En la última pestaña, validar y enviar
            validateAndSubmit();
        }
    });

    // Botón anterior
    prevBtn.addEventListener('click', () => {
        if (currentTabIndex > 0) {
            showTab(currentTabIndex - 1);
        }
    });

    // Mostrar/ocultar campos laborales
    const tipoLaboralSelect = document.getElementById('tipo_laboral');
    const dependienteFields = document.getElementById('dependiente-fields');
    const independienteFields = document.getElementById('independiente-fields');

    if (tipoLaboralSelect) {
        tipoLaboralSelect.addEventListener('change', function() {
            dependienteFields.classList.add('hidden');
            independienteFields.classList.add('hidden');
            
            if (this.value === 'dependiente') {
                dependienteFields.classList.remove('hidden');
            } else if (this.value === 'independiente') {
                independienteFields.classList.remove('hidden');
            }
        });
    }

    // Manejo de deudas
    let deudaCounter = 1;
    const addDeudaBtn = document.getElementById('add-deuda');
    const deudasContainer = document.getElementById('deudas-container');

    if (addDeudaBtn) {
        addDeudaBtn.addEventListener('click', function() {
            const deudaItem = document.createElement('div');
            deudaItem.className = 'deuda-item flex items-center space-x-3';
            deudaItem.innerHTML = `
                <input type="text" name="deudas[${deudaCounter}][institucion]" class="flex-1 px-3 py-2 border border-slate-300 rounded-lg" placeholder="Institución">
                <input type="number" name="deudas[${deudaCounter}][monto]" class="w-32 px-3 py-2 border border-slate-300 rounded-lg" step="0.01" min="0" placeholder="Monto (Bs.)">
                <button type="button" class="remove-deuda bg-red-100 text-red-600 hover:bg-red-200 px-3 py-2 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            deudasContainer.appendChild(deudaItem);
            deudaCounter++;
        });
    }

    // Eliminar deuda
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-deuda')) {
            const deudaItem = e.target.closest('.deuda-item');
            if (deudasContainer.children.length > 1) {
                deudaItem.remove();
            }
        }
    });

    // Manejo de archivos
    let archivoCounter = 2;
    const addArchivoBtn = document.getElementById('add-archivo');
    const archivosContainer = document.getElementById('archivos-container');

    if (addArchivoBtn) {
        addArchivoBtn.addEventListener('click', function() {
            const archivoDiv = document.createElement('div');
            archivoDiv.className = 'space-y-2';
            archivoDiv.innerHTML = `
                <label class="block text-sm font-medium text-slate-700">Archivo ${archivoCounter}</label>
                <div class="relative">
                    <input type="file" name="archivos[]" class="w-full px-3 py-2 border border-slate-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100">
                </div>
            `;
            archivosContainer.appendChild(archivoDiv);
            archivoCounter++;
        });
    }

    // Validación y envío
    function validateAndSubmit() {
        // Validar pestañas obligatorias
        const datosGenerales = document.querySelector('[name="usuario_id"]').value;
        const credito = document.querySelector('[name="monto_solicitado"]').value;
        const autorizacion = document.querySelector('[name="autorizacion_buro"]').checked;

        if (!datosGenerales || !credito || !autorizacion) {
            alert('Por favor complete al menos las pestañas de Datos Generales y Solicitud de Crédito, y acepte los términos y condiciones.');
            showTab(0); // Volver a la primera pestaña
            return;
        }

        // Enviar formulario
        document.querySelector('form').submit();
    }

    // Inicializar primera pestaña
    showTab(0);
});
</script>

<style>
.tab-button {
    border-bottom-width: 2px;
    border-bottom-style: solid;
}

.tab-button.active {
    border-bottom-color: #3b82f6;
    color: #1d4ed8;
    background-color: #eff6ff;
}

.tab-button:not(.active):hover {
    border-bottom-color: #cbd5e1;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}
</style>
@endsection