@extends('layouts.app')

@section('page-title', 'Detalle del Préstamo')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.prestamos.index') }}" 
                   class="p-3 text-slate-500 hover:text-slate-700 hover:bg-white rounded-xl transition-all duration-200 shadow-sm border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">Préstamo #{{ $prestamo->id }}</h1>
                    <p class="mt-1 text-slate-600">Información detallada del préstamo</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.prestamos.edit', $prestamo->id) }}" 
                   class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Editar</span>
                </a>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="bg-white hover:bg-slate-50 text-slate-700 px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center space-x-2 shadow-lg border border-slate-200">
                        <span>Más acciones</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="open" 
                         @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-slate-200 py-3 z-20">
                        
                        <a href="#" class="flex items-center px-5 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Generar reporte
                        </a>
                        
                        <a href="#" class="flex items-center px-5 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H9.414a1 1 0 01-.707-.293l-2-2H4a2 2 0 00-2 2v7a2 2 0 002 2h2m3 0h6m-3-4h4"></path>
                            </svg>
                            Archivar préstamo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estado del Préstamo -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
            @php
                $estadoConfig = [
                    'activo' => [
                        'bg' => 'from-emerald-500 via-emerald-600 to-teal-600',
                        'text' => 'text-emerald-800',
                        'badge' => 'bg-emerald-100',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    'completado' => [
                        'bg' => 'from-blue-500 via-blue-600 to-indigo-600',
                        'text' => 'text-blue-800',
                        'badge' => 'bg-blue-100',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    'vencido' => [
                        'bg' => 'from-red-500 via-red-600 to-rose-600',
                        'text' => 'text-red-800',
                        'badge' => 'bg-red-100',
                        'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    'pendiente' => [
                        'bg' => 'from-violet-500 via-purple-600 to-indigo-600',
                        'text' => 'text-violet-800',
                        'badge' => 'bg-violet-100',
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    'mora' => [
                        'bg' => 'from-orange-500 via-red-500 to-red-600',
                        'text' => 'text-orange-800',
                        'badge' => 'bg-orange-100',
                        'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ]
                ];
                $config = $estadoConfig[$prestamo->estado] ?? $estadoConfig['pendiente'];
            @endphp
            
            <div class="bg-gradient-to-r {{ $config['bg'] }} px-8 py-10 relative overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
                
                <div class="relative flex items-center justify-between">
                    <div class="text-white">
                        <div class="flex items-center space-x-4 mb-3">
                            <h2 class="text-5xl font-bold tracking-tight">Bs {{ number_format($prestamo->monto, 2) }}</h2>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-white bg-opacity-20 text-black backdrop-blur-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                </svg>
                                {{ ucfirst($prestamo->estado) }}
                            </span>
                        </div>
                        <p class="text-xl font-medium opacity-90 mb-1">Préstamo #{{ $prestamo->id }}</p>
                        <p class="text-lg opacity-75">{{ $prestamo->usuario->nombre_completo }}</p>
                    </div>
                    <div class="text-right text-black">
                        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6">
                            <p class="text-sm opacity-75 mb-1">Fecha de desembolso</p>
                            <p class="text-2xl font-bold">{{ \Carbon\Carbon::parse($prestamo->fecha_desembolso)->format('d/m/Y') }}</p>
                            @if($prestamo->fecha_vencimiento)
                                <p class="text-sm opacity-75 mt-4 mb-1">Vencimiento</p>
                                <p class="text-xl font-semibold">{{ \Carbon\Carbon::parse($prestamo->fecha_vencimiento)->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información Principal -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Detalles del Préstamo -->
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
                    <h3 class="text-2xl font-bold text-slate-800 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        Detalles Financieros
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl border border-slate-200">
                                <span class="text-sm font-semibold text-slate-600">Monto Principal</span>
                                <span class="text-xl font-bold text-slate-900">Bs {{ number_format($prestamo->monto, 2) }}</span>
                            </div>
                            
                            @if($prestamo->tasa_interes)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl border border-slate-200">
                                <span class="text-sm font-semibold text-slate-600">Tasa de Interés</span>
                                <span class="text-xl font-bold text-slate-900">{{ $prestamo->tasa_interes }}%</span>
                            </div>
                            @endif
                            
                            @if($prestamo->plazo_meses)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl border border-slate-200">
                                <span class="text-sm font-semibold text-slate-600">Plazo</span>
                                <span class="text-xl font-bold text-slate-900">{{ $prestamo->plazo_meses }} meses</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="space-y-4">
                            @if($prestamo->cuota_mensual)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                                <span class="text-sm font-semibold text-blue-700">Cuota Mensual</span>
                                <span class="text-xl font-bold text-blue-800">Bs {{ number_format($prestamo->cuota_mensual, 2) }}</span>
                            </div>
                            @endif
                            
                            @if($prestamo->monto_total)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-200">
                                <span class="text-sm font-semibold text-emerald-700">Monto Total</span>
                                <span class="text-xl font-bold text-emerald-800">Bs {{ number_format($prestamo->monto_total, 2) }}</span>
                            </div>
                            @endif
                            
                            @if($prestamo->saldo_pendiente)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-violet-50 to-purple-50 rounded-xl border border-violet-200">
                                <span class="text-sm font-semibold text-violet-700">Saldo Pendiente</span>
                                <span class="text-xl font-bold text-violet-800">Bs {{ number_format($prestamo->saldo_pendiente, 2) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información del Usuario -->
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
                    <h3 class="text-2xl font-bold text-slate-800 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Información del Cliente
                    </h3>
                    
                    <div class="flex items-center space-x-6 p-6 bg-gradient-to-r from-slate-50 to-slate-100 rounded-2xl border border-slate-200">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <span class="text-2xl font-bold text-white">{{ strtoupper(substr($prestamo->usuario->nombre_completo, 0, 2)) }}</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xl font-bold text-slate-900">{{ $prestamo->usuario->nombre_completo }}</h4>
                            <p class="text-slate-600 text-lg">{{ $prestamo->usuario->correo }}</p>
                            <p class="text-sm text-slate-500 mt-1">CI: {{ $prestamo->usuario->ci }} - {{ $prestamo->usuario->expedido ?? '' }}</p>
                        </div>
                        <a href="{{ route('admin.usuarios.show', $prestamo->usuario->id) }}" 
                           class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Ver Perfil
                        </a>
                    </div>
                </div>

                <!-- Historial de Pagos -->
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-slate-800 flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-violet-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Historial de Pagos
                            </h3>
                            <button class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Registrar Pago
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        @if($prestamo->pagos && $prestamo->pagos->count() > 0)
                            <div class="space-y-4">
                                @foreach($prestamo->pagos->take(5) as $pago)
                                    <div class="flex items-center justify-between p-5 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-200">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900 text-lg">Bs {{ number_format($pago->monto, 2) }}</p>
                                                <p class="text-sm text-slate-500">{{ $pago->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <span class="text-sm font-semibold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">{{ $pago->metodo_pago ?? 'Efectivo' }}</span>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($prestamo->pagos->count() > 5)
                                <div class="text-center mt-6">
                                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                                        Ver todos los pagos ({{ $prestamo->pagos->count() }})
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-600 text-lg font-semibold">No hay pagos registrados</p>
                                <p class="text-sm text-slate-500">Los pagos aparecerán aquí una vez registrados</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Progreso del Préstamo -->
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        Progreso del Préstamo
                    </h3>
                    
                    @php
                        $progreso = 0;
                        if ($prestamo->monto > 0 && $prestamo->saldo_pendiente !== null) {
                            $pagado = $prestamo->monto - $prestamo->saldo_pendiente;
                            $progreso = ($pagado / $prestamo->monto) * 100;
                        }
                    @endphp
                    
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-slate-600 mb-3">
                            <span class="font-semibold">Pagado</span>
                            <span class="font-bold">{{ number_format($progreso, 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-4 shadow-inner">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-4 rounded-full transition-all duration-1000 ease-out shadow-lg" 
                                 style="width: {{ $progreso }}%"></div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl">
                            <span class="text-emerald-700 font-semibold">Monto pagado</span>
                            <span class="font-bold text-emerald-800">Bs {{ number_format($prestamo->monto - ($prestamo->saldo_pendiente ?? 0), 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm p-3 bg-gradient-to-r from-violet-50 to-purple-50 rounded-xl">
                            <span class="text-violet-700 font-semibold">Saldo pendiente</span>
                            <span class="font-bold text-violet-800">Bs {{ number_format($prestamo->saldo_pendiente ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-slate-500 to-slate-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Información Adicional
                    </h3>
                    
                    <div class="space-y-5">
                        <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl">
                            <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v2m-6 0a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H10z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Fecha de creación</p>
                                <p class="text-slate-900 font-bold">{{ $prestamo->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl">
                            <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Última actualización</p>
                                <p class="text-slate-900 font-bold">{{ $prestamo->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                {{-- <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-violet-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        Acciones Rápidas
                    </h3>
                    
                    <div class="space-y-4">
                        <button class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Registrar Pago
                        </button>
                        
                        <button class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Generar Reporte
                        </button>
                        
                        <a href="{{ route('admin.usuarios.show', $prestamo->usuario->id) }}" 
                           class="w-full flex items-center justify-center px-6 py-4 bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Ver Cliente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!-- Alpine.js -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
