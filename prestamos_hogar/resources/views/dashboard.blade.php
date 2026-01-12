@extends('layouts.app')

@section('page-title', 'Dashboard Administrativo')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg">
        <div class="px-6 py-8 sm:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">¡Bienvenido, {{ auth()->user()->nombre_completo }}!</h1>
                    <p class="mt-2 text-blue-100">Administra tu sistema de préstamos desde aquí</p>
                </div>
                <div class="hidden sm:block">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Capital Disponible -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Capital Disponible</p>
                    <p class="text-3xl font-bold text-blue-600">
                        Bs. {{ number_format($capital->monto_actual ?? 0, 2) }}
                    </p>
                    <p class="text-sm text-slate-500 mt-1">
                        <span class="{{ $porcentajeUsado > 80 ? 'text-red-600' : 'text-green-600' }}">
                            {{ number_format($porcentajeUsado, 2) }}% usado
                        </span>
                    </p>
                </div>
                <a href="{{ route('admin.capital.index') }}" class="text-blue-500 hover:text-blue-600 text-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Total Préstamos -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Préstamos</p>
                    <p class="text-3xl font-bold text-slate-900">{{ \App\Models\Prestamo::count() }}</p>
                    <p class="text-sm text-slate-500">
                        Activos: <span class="font-medium">{{ \App\Models\Prestamo::where('estado', 'vigente')->count() }}</span>
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Monto en Préstamos -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Monto en Préstamos</p>
                    <p class="text-3xl font-bold text-slate-900">
                        Bs. {{ number_format(\App\Models\Prestamo::where('estado', 'vigente')->sum('monto'), 2) }}
                    </p>
                    <p class="text-sm text-slate-500">
                        <span class="{{ $porcentajeUsado > 80 ? 'text-red-600' : 'text-green-600' }}">
                            {{ number_format($prestamosActivos, 2) }} Bs.
                        </span>
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Usuarios -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Usuarios</p>
                    <p class="text-3xl font-bold text-slate-900">{{ \App\Models\Usuario::count() }}</p>
                    <p class="text-sm text-slate-500">
                        Activos: {{ \App\Models\Usuario::has('prestamos')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Últimos Préstamos</h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse(\App\Models\Prestamo::with('usuario')->latest()->take(5)->get() as $prestamo)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $prestamo->codigo }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $prestamo->usuario->nombre_completo }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Bs. {{ number_format($prestamo->monto, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $prestamo->estado == 'vigente' ? 'bg-green-100 text-green-800' : 
                                           ($prestamo->estado == 'cancelado' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($prestamo->estado) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay préstamos registrados
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Acciones Rápidas</h3>
            </div>
            <div class="p-6 space-y-4">
                <a href="{{ route('admin.prestamos.create') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg font-medium transition-colors duration-200">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nuevo Préstamo
                </a>
                
                <a href="{{ route('admin.usuarios.create') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-3 px-4 rounded-lg font-medium transition-colors duration-200">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Nuevo Usuario
                </a>
                
                <a href="{{ route('admin.capital.index') }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-3 px-4 rounded-lg font-medium transition-colors duration-200">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Gestionar Capital
                </a>
            </div>
        </div>
    </div>

    <!-- Gráficas Mejoradas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Gráfico: Préstamos por Estado -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Distribución de Préstamos</h3>
                    <p class="text-sm text-slate-600 mt-1">Estado actual de la cartera</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="relative h-80">
                <div id="graficoPrestamosEstado"></div>
            </div>
        </div>

        <!-- Gráfico: Estado Global de Pagos -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Estado de Pagos</h3>
                    <p class="text-sm text-slate-600 mt-1">Situación de las cuotas</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="relative h-80">
                <div id="graficoPagosEstado"></div>
            </div>
        </div>
    </div>

    <!-- Gráfico: Préstamos por mes -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Tendencia de Préstamos</h3>
                <p class="text-sm text-slate-600 mt-1">Préstamos otorgados en los últimos 6 meses</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-gradient-to-r from-violet-500 to-purple-600 rounded-full"></div>
                    <span class="text-sm text-slate-600 font-medium">Préstamos mensuales</span>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-violet-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="relative h-96">
            <div id="graficoPrestamosPorMes"></div>
        </div>
    </div>

    <!-- Gráfico: Top 5 Clientes con Más Deuda Pendiente -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mt-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-4">Top 5 Clientes con Más Deuda Pendiente</h3>
        <div class="relative h-80">
            <div id="graficoTopDeudores"></div>
        </div>
    </div>

    <!-- Nuevos Gráficos Avanzados -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Gráfico 1: Pronóstico de Solicitudes con Suavización Exponencial -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Pronóstico de Solicitudes</h3>
                    <p class="text-sm text-slate-600 mt-1">Suavización Exponencial (α=0.3)</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="relative h-80">
                <div id="graficoPronostico"></div>
            </div>
        </div>

        <!-- Gráfico 2: Modelo EOQ para Capital -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Modelo EOQ para Capital</h3>
                    <p class="text-sm text-slate-600 mt-1">Gestión óptima de capital disponible</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-teal-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="relative h-80">
                <div id="graficoEOQ"></div>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <div class="text-sm text-slate-600">Capital Óptimo (EOQ)</div>
                    <div class="text-xl font-bold text-blue-700">Bs. {{ number_format($datosEOQ['eoq']['eoq'], 2) }}</div>
                </div>
                <div class="p-3 bg-green-50 rounded-lg">
                    <div class="text-sm text-slate-600">Punto de Reorden (ROP)</div>
                    <div class="text-xl font-bold text-green-700">Bs. {{ number_format($datosEOQ['rop'], 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Gráfico 3: Asignación Óptima de Capital -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Asignación Óptima de Capital</h3>
                    <p class="text-sm text-slate-600 mt-1">Distribución por segmento de riesgo</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="relative h-80">
                <div id="graficoAsignacionCapital"></div>
            </div>
            <div class="mt-4 p-3 bg-blue-50 rounded-lg text-center">
                <div class="text-sm text-slate-600">Rentabilidad Esperada</div>
                <div class="text-xl font-bold text-blue-700">Bs. {{ number_format($asignacionOptima['rentabilidad_esperada'], 2) }} (ROI: {{ number_format($asignacionOptima['roi'], 2) }}%)</div>
            </div>
        </div>

        <!-- Gráfico 4: Clasificación ABC de Clientes -->
        {{-- <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Clasificación ABC de Clientes</h3>
                    <p class="text-sm text-slate-600 mt-1">Análisis de rentabilidad por cliente</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="relative h-80">
                <div id="graficoABC"></div>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                <div class="p-2 bg-red-50 rounded-lg">
                    <div class="text-sm text-slate-600">Clientes A</div>
                    <div class="font-bold text-red-700">{{ count($analisisABC['categorias']['A']['clientes']) }}</div>
                </div>
                <div class="p-2 bg-yellow-50 rounded-lg">
                    <div class="text-sm text-slate-600">Clientes B</div>
                    <div class="font-bold text-yellow-700">{{ count($analisisABC['categorias']['B']['clientes']) }}</div>
                </div>
                <div class="p-2 bg-green-50 rounded-lg">
                    <div class="text-sm text-slate-600">Clientes C</div>
                    <div class="font-bold text-green-700">{{ count($analisisABC['categorias']['C']['clientes']) }}</div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Configuración global de ApexCharts
        Apex.colors = [
            '#6366f1', '#8b5cf6', '#ec4899', '#f43f5e', '#f97316', 
            '#eab308', '#22c55e', '#14b8a6', '#06b6d4', '#0ea5e9'
        ];
        
        // Gráfico: Préstamos por Estado
        var optionsPrestamosEstado = {
            series: [{
                name: 'Préstamos',
                data: [
                    {{ \App\Models\Prestamo::where('estado', 'vigente')->count() }},
                    {{ \App\Models\Prestamo::where('estado', 'cancelado')->count() }},
                    {{ \App\Models\Prestamo::where('estado', 'mora')->count() }}
                ]
            }],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['Vigentes', 'Cancelados', 'En Mora'],
            },
            yaxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            fill: {
                opacity: 1,
                colors: ['#22c55e', '#94a3b8', '#ef4444']
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " préstamos"
                    }
                }
            }
        };
        
        var chartPrestamosEstado = new ApexCharts(document.querySelector("#graficoPrestamosEstado"), optionsPrestamosEstado);
        chartPrestamosEstado.render();
        
        // Gráfico: Estado de Pagos
        var optionsPagosEstado = {
            series: [{{ $pagados }}, {{ $pendientes }}, {{ $enMora }}],
            chart: {
                type: 'donut',
                height: 320,
            },
            labels: ['Pagados', 'Pendientes', 'En Mora'],
            colors: ['#10b981', '#fbbf24', '#ef4444'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                dropShadow: {
                    enabled: false
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " cuotas"
                    }
                }
            }
        };
        
        var chartPagosEstado = new ApexCharts(document.querySelector("#graficoPagosEstado"), optionsPagosEstado);
        chartPagosEstado.render();
        
        // Gráfico: Préstamos por Mes
        var optionsPrestamosPorMes = {
            series: [{
                name: 'Préstamos',
                data: {!! json_encode($conteos) !!}
            }],
            chart: {
                type: 'line',
                height: 384,
                toolbar: {
                    show: false
                }
            },
            stroke: {
                curve: 'smooth',
                width: 4,
                colors: ['#8b5cf6']
            },
            xaxis: {
                categories: {!! json_encode($meses) !!},
            },
            yaxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#ddd6fe'],
                    inverseColors: false,
                    opacityFrom: 0.8,
                    opacityTo: 0.2,
                    stops: [0, 100]
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " préstamos"
                    }
                }
            }
        };
        
        var chartPrestamosPorMes = new ApexCharts(document.querySelector("#graficoPrestamosPorMes"), optionsPrestamosPorMes);
        chartPrestamosPorMes.render();
        
        // Gráfico: Top 5 Deudores
        var optionsTopDeudores = {
            series: [{
                name: 'Deuda',
                data: {!! json_encode($topDeudores->pluck('deuda_total')) !!}
            }],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: {!! json_encode($topDeudores->pluck('nombre')) !!},
            },
            yaxis: {
                title: {
                    text: 'Bs.'
                }
            },
            colors: ['#6366f1'],
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Bs. " + val.toFixed(2)
                    }
                }
            }
        };
        
        var chartTopDeudores = new ApexCharts(document.querySelector("#graficoTopDeudores"), optionsTopDeudores);
        chartTopDeudores.render();
        
        // Gráfico 1: Pronóstico de Solicitudes con Suavización Exponencial
        var optionsPronostico = {
            series: [
                {
                    name: 'Histórico',
                    data: {!! json_encode(array_column($pronostico['historico'], 'valor')) !!}
                },
                {
                    name: 'Pronóstico',
                    data: [
                        null, null, null, null, null, null, null, null, null, null, null, null,
                        ...{!! json_encode(array_column($pronostico['pronostico'], 'valor')) !!}
                    ]
                },
                {
                    name: 'Límite Superior',
                    type: 'line',
                    dashArray: 5,
                    data: [
                        null, null, null, null, null, null, null, null, null, null, null, null,
                        ...{!! json_encode($pronostico['confianza_superior']) !!}
                    ]
                },
                {
                    name: 'Límite Inferior',
                    type: 'line',
                    dashArray: 5,
                    data: [
                        null, null, null, null, null, null, null, null, null, null, null, null,
                        ...{!! json_encode($pronostico['confianza_inferior']) !!}
                    ]
                }
            ],
            chart: {
                height: 320,
                type: 'line',
                toolbar: {
                    show: false
                }
            },
            stroke: {
                width: [3, 3, 2, 2],
                curve: 'smooth',
                dashArray: [0, 0, 5, 5]
            },
            xaxis: {
                categories: [
                    ...{!! json_encode(array_column($pronostico['historico'], 'mes')) !!},
                    ...{!! json_encode(array_column($pronostico['pronostico'], 'mes')) !!}
                ]
            },
            yaxis: {
                title: {
                    text: 'Solicitudes'
                }
            },
            colors: ['#8b5cf6', '#6366f1', '#10b981', '#ef4444'],
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " solicitudes"
                    }
                }
            },
            legend: {
                position: 'top'
            }
        };
        
        var chartPronostico = new ApexCharts(document.querySelector("#graficoPronostico"), optionsPronostico);
        chartPronostico.render();
        
        // Gráfico 2: Modelo EOQ para Capital
        var optionsEOQ = {
            series: [{
                name: 'Capital',
                data: [
                    {{ $datosEOQ['capital_actual'] }},
                    {{ $datosEOQ['rop'] }},
                    {{ $datosEOQ['eoq']['eoq'] }}
                ]
            }],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: false,
                    columnWidth: '60%',
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['Capital Actual', 'Punto de Reorden', 'Capital Óptimo (EOQ)'],
            },
            yaxis: {
                title: {
                    text: 'Bs.'
                }
            },
            colors: ['#22c55e', '#f59e0b', '#6366f1'],
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Bs. " + val.toFixed(2)
                    }
                }
            }
        };
        
        var chartEOQ = new ApexCharts(document.querySelector("#graficoEOQ"), optionsEOQ);
        chartEOQ.render();
        
        // Gráfico 3: Asignación Óptima de Capital
        var optionsAsignacionCapital = {
            series: [{
                name: 'Capital Asignado',
                data: [
                    {{ $asignacionOptima['segmentos']['bajo_riesgo']['asignacion'] }},
                    {{ $asignacionOptima['segmentos']['medio_riesgo']['asignacion'] }},
                    {{ $asignacionOptima['segmentos']['alto_riesgo']['asignacion'] }}
                ]
            }],
            chart: {
                type: 'bar',
                height: 320,
                stacked: true,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: false,
                    columnWidth: '60%',
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['Bajo Riesgo', 'Medio Riesgo', 'Alto Riesgo'],
            },
            yaxis: {
                title: {
                    text: 'Bs.'
                }
            },
            colors: ['#22c55e', '#f59e0b', '#ef4444'],
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Bs. " + val.toFixed(2)
                    }
                }
            },
            fill: {
                opacity: 1
            }
        };
        
        var chartAsignacionCapital = new ApexCharts(document.querySelector("#graficoAsignacionCapital"), optionsAsignacionCapital);
        chartAsignacionCapital.render();
        
        // Gráfico 4: Clasificación ABC de Clientes
        var optionsABC = {
            series: [
                {
                    name: 'Rentabilidad',
                    data: {!! json_encode(array_slice(array_column($analisisABC['clientes'], 'rentabilidad'), 0, 20)) !!}
                }
            ],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: {!! json_encode(array_slice(array_column($analisisABC['clientes'], 'nombre'), 0, 20)) !!},
            },
            yaxis: {
                title: {
                    text: 'Bs.'
                }
            },
            colors: function({ value, seriesIndex, w }) {
                const index = w.globals.series[0].indexOf(value);
                const clientes = {!! json_encode($analisisABC['clientes']) !!};
                if (index < clientes.length) {
                    const categoria = clientes[index].categoria;
                    if (categoria === 'A') return '#ef4444';
                    if (categoria === 'B') return '#f59e0b';
                    return '#22c55e';
                }
                return '#6366f1';
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Bs. " + val.toFixed(2)
                    }
                }
            }
        };
        
        var chartABC = new ApexCharts(document.querySelector("#graficoABC"), optionsABC);
        chartABC.render();
    });
</script>
@endsection