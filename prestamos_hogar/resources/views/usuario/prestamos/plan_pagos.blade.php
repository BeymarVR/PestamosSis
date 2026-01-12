@extends('layouts.app')

@section('page-title', 'Plan de Pagos')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('usuario.prestamos') }}" 
               class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Plan de Pagos</h1>
                <p class="text-sm text-slate-600">Préstamo: {{ $prestamo->codigo ?? 'PR-' . str_pad($prestamo->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('usuario.prestamos.pdf', $prestamo->id) }}" 
   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded flex items-center">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    Exportar PDF
</a>

        </div>
    </div>

    <!-- Loan Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200">
            <h3 class="font-semibold text-purple-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
                Detalles del Préstamo
            </h3>
            <div class="space-y-2">
                <p class="text-sm"><span class="font-medium">Monto:</span> Bs {{ number_format($prestamo->monto, 2) }}</p>
                <p class="text-sm"><span class="font-medium">Interés:</span> {{ $prestamo->tasa_interes_mensual ?? '2.5' }}% mensual</p>
                <p class="text-sm"><span class="font-medium">Plazo:</span> {{ $prestamo->plazo_meses ?? 'N/A' }} meses</p>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
            <h3 class="font-semibold text-green-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v2m-6 0a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H10z"></path>
                </svg>
                Fechas Clave
            </h3>
            <div class="space-y-2">
                <p class="text-sm"><span class="font-medium">Desembolso:</span> {{ optional($prestamo->fecha_desembolso)->format('d/m/Y') ?? $prestamo->created_at->format('d/m/Y') }}</p>
                <p class="text-sm"><span class="font-medium">Estado:</span> 
                    <span class="ml-2 px-2 py-1 rounded-full text-xs font-medium 
                        {{ $prestamo->estado === 'vigente' ? 'bg-blue-100 text-blue-800' : 
                           ($prestamo->estado === 'cancelado' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($prestamo->estado) }}
                    </span>
                </p>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 p-6 rounded-xl border border-yellow-200">
            <h3 class="font-semibold text-yellow-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Totales
            </h3>
            <div class="space-y-2">
                <p class="text-sm"><span class="font-medium">Cuotas:</span> {{ $prestamo->planPagos->count() }}</p>
                <p class="text-sm"><span class="font-medium">Pagadas:</span> {{ $prestamo->planPagos->filter(function($cuota) { return $cuota->pagos && $cuota->pagos->isNotEmpty(); })->count() }}</p>
                <p class="text-sm"><span class="font-medium">Pendientes:</span> {{ $prestamo->planPagos->filter(function($cuota) { return !$cuota->pagos || $cuota->pagos->isEmpty(); })->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Payment Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h3 class="text-lg font-semibold text-slate-900">Cronograma Detallado</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm"># Cuota</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Vencimiento</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Monto (Bs)</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Estado</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Fecha Pago</th>
                        {{-- <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Acciones</th> --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @php $totalGeneral = 0; @endphp
                    @foreach($prestamo->planPagos as $cuota)
                        @php
                            $estaPagado = $cuota->pagos && $cuota->pagos->isNotEmpty();
                            $estaVencido = !$estaPagado && $cuota->fecha_vencimiento < now();
                            $monto = $cuota->monto_cuota ?? $cuota->saldo;
                            $totalGeneral += $monto;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors duration-200 
                            {{ $estaPagado ? 'bg-green-50' : ($estaVencido ? 'bg-red-50' : '') }}">
                            <td class="py-4 px-6 text-sm font-medium text-slate-900">{{ $loop->iteration }}</td>
                            <td class="py-4 px-6 text-sm text-slate-600">{{ optional($cuota->fecha_vencimiento)->format('d/m/Y') ?? '—' }}</td>
                            <td class="py-4 px-6 text-sm font-medium text-slate-900">Bs {{ number_format($monto, 2) }}</td>
                            <td class="py-4 px-6">
                                @if($estaPagado)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Pagado
                                    </span>
                                @elseif($estaVencido)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        Vencido
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Pendiente
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600">
                                @php
                                    $primerPago = $cuota->pagos->first();
                                @endphp
                                {{ $primerPago?->fecha_pago?->format('d/m/Y') ?? '—' }}
                            </td>
                            {{-- <td class="py-4 px-6">
                                @if($estaPagado)
                                    <button class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">
                                        Ver Recibo
                                    </button>
                                @else
                                    <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors duration-200">
                                        Pagar Ahora
                                    </button>
                                @endif
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-purple-50 font-bold">
                    <tr>
                        <td colspan="2" class="text-right py-4 px-6 text-slate-700">TOTAL GENERAL:</td>
                        <td class="text-purple-700 text-lg py-4 px-6">Bs {{ number_format($totalGeneral, 2) }}</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection