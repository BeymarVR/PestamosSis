@extends('layouts.app')

@section('page-title', 'Monitor de Seguridad (NIST)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Monitor de Seguridad y Prevención</h1>
            <p class="mt-1 text-sm text-slate-600">Visualización simplificada basada en el estándar internacional de ciberseguridad NIST CSF 2.0</p>
        </div>
    </div>

    <!-- Info banner para no-técnicos -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start space-x-3">
        <svg class="h-6 w-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm text-blue-800">
            <strong>¿Qué significa esto?</strong> Este tablero traduce conceptos técnicos de seguridad a indicadores entendibles para la administración de préstamos. Te ayuda a ver de un vistazo si la plataforma está segura, si hay morosidades anómalas, y cómo están configurados los permisos.
        </p>
    </div>

    <!-- NIST Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- GOVERN (GV) -->
        <div class="bg-white rounded-xl shadow-sm border border-orange-200 overflow-hidden relative group hover:shadow-md transition-shadow">
            <div class="absolute top-0 left-0 w-1 h-full bg-orange-500"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                            <!-- Icon Group -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">Administración de Accesos <span class="text-xs text-orange-500 font-normal ml-1 border rounded-lg px-2 border-orange-200 bg-orange-50">(Govern)</span></h2>
                    </div>
                </div>
                <p class="text-sm text-slate-600 mb-4 h-10">Muestra cuántos empleados tienen poder sobre la plataforma.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-orange-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-2xl font-black text-orange-700">{{ $stats['gv']['admins'] }}</span>
                        <span class="text-xs text-orange-600 font-medium leading-tight mt-1 block">Super Administradores</span>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-2xl font-black text-orange-700">{{ $stats['gv']['gestores'] }}</span>
                        <span class="text-xs text-orange-600 font-medium leading-tight mt-1 block">Cajeros / Gestores</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- IDENTIFY (ID) -->
        <div class="bg-white rounded-xl shadow-sm border border-emerald-200 overflow-hidden relative group hover:shadow-md transition-shadow">
            <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                            <!-- Icon Users -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">Perfil de Clientes <span class="text-xs text-emerald-500 font-normal ml-1 border rounded-lg px-2 border-emerald-200 bg-emerald-50">(Identify)</span></h2>
                    </div>
                </div>
                <p class="text-sm text-slate-600 mb-4 h-10">Vigila el volumen de tus clientes y aquellos con peor calificación crediticia.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-emerald-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-2xl font-black text-emerald-700">{{ $stats['id']['clientes'] }}</span>
                        <span class="text-xs text-emerald-600 font-medium leading-tight mt-1 block">Clientes<br> Registrados</span>
                    </div>
                    <div class="bg-emerald-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-2xl font-black text-emerald-700">{{ $stats['id']['riesgo_alto'] }}</span>
                        <span class="text-xs text-emerald-600 font-medium leading-tight mt-1 block">Clientes de<br> Alto Riesgo</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PROTECT (PR) -->
        <div class="bg-white rounded-xl shadow-sm border border-purple-200 overflow-hidden relative group hover:shadow-md transition-shadow">
            <div class="absolute top-0 left-0 w-1 h-full bg-purple-500"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">Protección de Datos <span class="text-xs text-purple-500 font-normal ml-1 border rounded-lg px-2 border-purple-200 bg-purple-50">(Protect)</span></h2>
                    </div>
                </div>
                <p class="text-sm text-slate-600 mb-4 h-10">Indica cómo se protege la privacidad de tu información sensible hoy.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-purple-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-2xl font-black text-purple-700">{{ $stats['pr']['sesiones_24h'] }}</span>
                        <span class="text-xs text-purple-600 font-medium leading-tight mt-1 block">Inicios de sesión (Hoy)</span>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-xl font-black text-green-600 mt-1 flex justify-center items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Activo
                        </span>
                        <span class="text-xs text-purple-600 font-medium leading-tight mt-1 block">Ocultamiento de CI / Celular</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- DETECT (DE) -->
        <div class="bg-white rounded-xl shadow-sm border border-yellow-200 overflow-hidden relative group hover:shadow-md transition-shadow">
            <div class="absolute top-0 left-0 w-1 h-full bg-yellow-400"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                            <!-- Icon search / Eye -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">Alertas y Bitácora <span class="text-xs text-yellow-600 font-normal ml-1 border rounded-lg px-2 border-yellow-200 bg-yellow-50">(Detect)</span></h2>
                    </div>
                </div>
                <p class="text-sm text-slate-600 mb-4 h-10">Rastrea la aparición de cuotas impagas y evalúa el registro de actividades técnicas.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-yellow-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-2xl font-black text-yellow-700">{{ $stats['de']['alertas_mora'] }}</span>
                        <span class="text-xs text-yellow-600 font-medium leading-tight mt-1 block">Cuotas actualmente en MORA</span>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-2xl font-black text-yellow-700">{{ $stats['de']['logs_7d'] }}</span>
                        <span class="text-xs text-yellow-600 font-medium leading-tight mt-1 block">Acciones registradas (1 sem)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESPOND (RS) -->
        <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden relative group hover:shadow-md transition-shadow">
            <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-red-50 rounded-lg text-red-600">
                            <!-- Icon Alert -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">Atención de Incidentes <span class="text-xs text-red-500 font-normal ml-1 border rounded-lg px-2 border-red-200 bg-red-50">(Respond)</span></h2>
                    </div>
                </div>
                <p class="text-sm text-slate-600 mb-4 h-10">Muestra qué problemas están esperando recibir atención por parte de la administración.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-red-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-2xl font-black text-red-700">{{ $stats['rs']['notis_pendientes'] }}</span>
                        <span class="text-xs text-red-600 font-medium leading-tight mt-1 block">Notificaciones No Leídas</span>
                    </div>
                    <div class="bg-red-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-xl font-black text-green-600 mt-1 flex justify-center items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Estable
                        </span>
                        <span class="text-xs text-red-600 font-medium leading-tight mt-1 block">Estado del Servidor</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RECOVER (RC) -->
        <div class="bg-white rounded-xl shadow-sm border border-blue-200 overflow-hidden relative group hover:shadow-md transition-shadow">
            <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                            <!-- Icon Cash/Recover -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">Recuperación Financiera <span class="text-xs text-blue-500 font-normal ml-1 border rounded-lg px-2 border-blue-200 bg-blue-50">(Recover)</span></h2>
                    </div>
                </div>
                <p class="text-sm text-slate-600 mb-4 h-10">Mide la salud tras incidentes; en este caso, qué tanto capital fue pagado y recuperado exitosamente.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-3 rounded-lg text-center shadow-inner">
                        <span class="block text-2xl font-black text-blue-700"><span class="text-sm text-blue-500 mr-1">Bs</span>{{ number_format($stats['rc']['recuperado_30d'], 0) }}</span>
                        <span class="text-xs text-blue-600 font-medium leading-tight mt-1 block">Capital Pagado / Rescatado (30d)</span>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg text-center shadow-inner flex flex-col items-center justify-center">
                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 mt-1 text-sm font-semibold text-green-700">En línea</span>
                        <span class="text-xs text-blue-600 font-medium leading-tight mt-2 block">Respaldos Diarios</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
