@extends('layouts.app')

@section('page-title', 'Mi Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl shadow-lg">
        <div class="px-6 py-8 sm:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">¡Bienvenido, {{ Auth::user()->nombre_completo }}!</h1>
                    <p class="mt-2 text-purple-100">Aquí verás tus cuotas, fechas y estado de pagos</p>
                </div>
                <div class="hidden sm:block">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $prestamoActivo = Auth::user()->prestamos->where('estado', 'vigente')->first();
        $proximoPago = null;
        $saldoPendiente = 0;
        
        if($prestamoActivo) {
            $proximoPago = $prestamoActivo->planPagos()
                ->whereDoesntHave('pagos')
                ->orderBy('fecha_vencimiento')
                ->first();
            $saldoPendiente = $prestamoActivo->planPagos()
                ->whereDoesntHave('pagos')
                ->sum('monto_cuota');
        }
    @endphp

    <!-- Loan Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Monto del Préstamo</p>
                    <p class="text-3xl font-bold text-slate-900 mt-2">
                        Bs {{ $prestamoActivo ? number_format($prestamoActivo->monto, 2) : '0.00' }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Saldo Pendiente</p>
                    <p class="text-3xl font-bold text-slate-900 mt-2">
                        Bs {{ number_format($saldoPendiente, 2) }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Próximo Pago</p>
                    <p class="text-3xl font-bold text-slate-900 mt-2">
                        Bs {{ $proximoPago ? number_format($proximoPago->monto_cuota, 2) : '0.00' }}
                    </p>
                    @if($proximoPago)
                        <p class="text-sm {{ $proximoPago->fecha_vencimiento < now() ? 'text-red-600' : 'text-purple-600' }} mt-1">
                            Vence: {{ $proximoPago->fecha_vencimiento->format('d/m/Y') }}
                        </p>
                    @endif
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @if($prestamoActivo)
    <!-- Payment Schedule -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Cronograma de Pagos</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('usuario.prestamo.plan-pagos', $prestamoActivo->id) }}" 
                       class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                        Ver Plan Completo
                    </a>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-3 px-4 font-medium text-slate-600">Cuota</th>
                            <th class="text-left py-3 px-4 font-medium text-slate-600">Fecha Vencimiento</th>
                            <th class="text-left py-3 px-4 font-medium text-slate-600">Monto</th>
                            <th class="text-left py-3 px-4 font-medium text-slate-600">Estado</th>
                            {{-- <th class="text-left py-3 px-4 font-medium text-slate-600">Acciones</th> --}}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($prestamoActivo->planPagos->take(5) as $cuota)
                            @php
                                $estaPagado = $cuota->pagos && $cuota->pagos->isNotEmpty();
                                $estaVencido = !$estaPagado && $cuota->fecha_vencimiento < now();
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors duration-200">
                                <td class="py-4 px-4 text-sm font-medium text-slate-900">{{ $cuota->numero_cuota ?? $loop->iteration }}</td>
                                <td class="py-4 px-4 text-sm text-slate-600">
                                    {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
                                </td>
                                <td class="py-4 px-4 text-sm text-slate-900 font-medium">
                                    Bs {{ number_format($cuota->monto_cuota ?? $cuota->saldo, 2) }}
                                </td>
                                <td class="py-4 px-4">
                                    @if($estaPagado)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Pagado
                                        </span>
                                    @elseif($estaVencido)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                            Vencido
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Pendiente
                                        </span>
                                    @endif
                                </td>
                                {{-- <td class="py-4 px-4">
                                    @if($estaPagado)
                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">
                                            Ver Recibo
                                        </button>
                                    @elseif(!$estaPagado)
                                        <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors duration-200">
                                            Pagar Ahora
                                        </button>
                                    @endif
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Acciones Rápidas</h3>
            <div class="space-y-3">
                {{-- @if($prestamoActivo)
                    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <span>Realizar Pago</span>
                    </button>
                @endif --}}
                <a href="{{ route('usuario.prestamos') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Ver Mis Préstamos</span>
                </a>
                {{-- <button class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Solicitar Nuevo Préstamo</span>
                </button> --}}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Información de Contacto</h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-900">Teléfono</p>
                        <p class="text-sm text-slate-600">+591 70123456</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-900">Email</p>
                        <p class="text-sm text-slate-600">soporte@prestamosfacil.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!$prestamoActivo)
    <!-- No Active Loans -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-slate-900 mb-2">No tienes préstamos activos</h3>
        <p class="text-slate-500 mb-6">Solicita tu primer préstamo para comenzar a construir tu historial crediticio</p>
        <button class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
            Solicitar Préstamo
        </button>
    </div>
    @endif
</div>
@endsection