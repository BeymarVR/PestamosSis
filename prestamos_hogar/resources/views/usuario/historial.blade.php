@extends('layouts.app')

@section('page-title', 'Mi Historial de Préstamos')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Mi Historial de Préstamos</h1>
        <p class="mt-1 text-sm text-slate-600">Revisa el historial completo de todos tus préstamos</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h3 class="text-lg font-semibold text-slate-900">Historial de Préstamos</h3>
        </div>

        <div class="p-6">
            @forelse ($prestamos->sortByDesc('created_at') as $prestamo)
                <div class="relative pl-8 {{ !$loop->last ? 'pb-8 border-l-2 border-slate-200 ml-4' : 'ml-4' }}">
                    <div class="absolute -left-2 top-0 w-4 h-4 rounded-full border-2 border-white shadow-sm
                        {{ $prestamo->estado == 'vigente' ? 'bg-green-500' :
                           ($prestamo->estado == 'cancelado' ? 'bg-blue-500' : 'bg-red-500') }}">
                    </div>

                    <div class="bg-slate-50 rounded-lg p-6 hover:bg-slate-100 transition-colors duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-3">
                                    <h4 class="text-lg font-semibold text-slate-900">Bs {{ number_format($prestamo->monto, 2) }}</h4>

                                    @php
                                        $estadoConfig = [
                                            'vigente' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                                            'cancelado' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                            'completado' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                            'vencido' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                            'mora' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                            'pendiente' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800']
                                        ];
                                        $config = $estadoConfig[$prestamo->estado] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
                                    @endphp

                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                        @if($prestamo->estado === 'vigente' || $prestamo->estado === 'cancelado' || $prestamo->estado === 'completado')
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        @endif
                                        {{ ucfirst($prestamo->estado) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-slate-600">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v2m-6 0a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H10z"></path>
                                        </svg>
                                        <span>{{ $prestamo->created_at->format('d/m/Y H:i') }}</span>
                                    </div>

                                    @if($prestamo->plazo_meses)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Plazo: {{ $prestamo->plazo_meses }} meses</span>
                                    </div>
                                    @endif

                                    @if($prestamo->tasa_interes_mensual)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                        </svg>
                                        <span>Interés: {{ $prestamo->tasa_interes_mensual }}%</span>
                                    </div>
                                    @endif
                                </div>

                                @if($prestamo->descripcion)
                                    <p class="mt-2 text-sm text-slate-600">{{ $prestamo->descripcion }}</p>
                                @endif
                            </div>

                            <div class="flex items-center space-x-2 ml-4">
                                <a href="{{ route('usuario.prestamo.plan-pagos', $prestamo->id) }}" 
                                   class="p-2 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200" 
                                   title="Ver plan de pagos">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Aún no tienes préstamos registrados</h3>
                    <p class="text-slate-500">Puedes solicitarlos cuando estés listo.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection