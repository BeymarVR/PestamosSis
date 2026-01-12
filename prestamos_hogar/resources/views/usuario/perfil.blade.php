@extends('layouts.app')

@section('page-title', 'Mi Perfil')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Mi Perfil</h1>
        <p class="mt-1 text-sm text-slate-600">Administra tu información personal</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <!-- Header del perfil -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-8 rounded-t-xl">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <span class="text-2xl font-bold text-white">
                        {{ strtoupper(substr($usuario->nombre_completo, 0, 2)) }}
                    </span>
                </div>
                <div class="text-white">
                    <h2 class="text-2xl font-bold">{{ $usuario->nombre_completo }}</h2>
                    <p class="text-purple-100">{{ $usuario->correo }}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Cuenta Activa
                    </span>
                </div>
            </div>
        </div>

        <!-- Información del usuario -->
        <div class="p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Información Personal</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 p-4 bg-slate-50 rounded-lg">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-600">Nombre Completo</dt>
                            <dd class="text-lg font-semibold text-slate-900">{{ $usuario->nombre_completo }}</dd>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-4 bg-slate-50 rounded-lg">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-600">Cédula de Identidad</dt>
                            <dd class="text-lg font-semibold text-slate-900">{{ $usuario->ci }} - {{ $usuario->expedido }}</dd>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-4 bg-slate-50 rounded-lg">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-600">Teléfono</dt>
                            <dd class="text-lg font-semibold text-slate-900">{{ $usuario->celular ?? 'No registrado' }}</dd>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3 p-4 bg-slate-50 rounded-lg">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-600">Correo Electrónico</dt>
                            <dd class="text-lg font-semibold text-slate-900">{{ $usuario->correo }}</dd>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-4 bg-slate-50 rounded-lg">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-600">Rol</dt>
                            <dd class="text-lg font-semibold text-slate-900 capitalize">{{ $usuario->rol->nombre }}</dd>
                        </div>
                    </div>

                    <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-purple-800">Estado de la cuenta</h3>
                                <p class="text-xs text-purple-600">Tu cuenta está verificada y activa</p>
                            </div>
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas del Usuario -->
            <div class="mt-8 pt-6 border-t border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Resumen de Actividad</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-600">Total Préstamos</p>
                                <p class="text-2xl font-bold text-blue-700">{{ $usuario->prestamos->count() }}</p>
                            </div>
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-600">Préstamos Activos</p>
                                <p class="text-2xl font-bold text-green-700">{{ $usuario->prestamos->where('estado', 'vigente')->count() }}</p>
                            </div>
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-600">Monto Total</p>
                                <p class="text-2xl font-bold text-purple-700">Bs {{ number_format($usuario->prestamos->sum('monto'), 0) }}</p>
                            </div>
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-200">
                {{-- <div class="flex space-x-3">
                    <button class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                        Editar Perfil
                    </button>
                    <button class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                        Cambiar Contraseña
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection