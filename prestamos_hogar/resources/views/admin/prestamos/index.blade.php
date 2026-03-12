@extends('layouts.app')

@section('page-title', 'Gestión de Préstamos')

@section('content')
<div class="space-y-6">
    <!-- Notificaciones -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center space-x-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center space-x-3">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Gestión de Préstamos</h1>
            <p class="mt-1 text-sm text-slate-600">Administra todos los préstamos del sistema</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.prestamos.exportar', request()->query()) }}" 
   class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    <span>Exportar</span>
</a>


                {{-- <a href="{{ route('admin.prestamos.create') }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Nuevo Préstamo</span>
                </a> --}}
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Préstamos</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $prestamos->total() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Registrados en el sistema</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Préstamos Vigentes</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $prestamos->where('estado', 'vigente')->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Actualmente activos</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">En Mora</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $prestamos->where('estado', 'mora')->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Requieren atención</p>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Monto Total</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">Bs {{ number_format($prestamos->sum('monto'), 0) }}</p>
                    <p class="text-xs text-slate-500 mt-1">Capital prestado</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros Mejorados -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-900">Filtros de Búsqueda</h3>
            <a href="{{ route('admin.prestamos.index') }}" 
               class="text-sm text-slate-600 hover:text-slate-800 transition-colors duration-200">
                Limpiar filtros
            </a>
        </div>
        
        <form method="GET" action="{{ route('admin.prestamos.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Buscar por nombre -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Buscar Cliente</label>
                <div class="relative">
                    <input type="text" 
                           name="buscar" 
                           value="{{ request('buscar') }}"
                           placeholder="Nombre del cliente..."
                           class="w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Estado -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Estado</label>
                <select name="estado" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    <option value="">Todos los estados</option>
                    <option value="vigente" {{ request('estado') == 'vigente' ? 'selected' : '' }}>Vigente</option>
                    <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    <option value="mora" {{ request('estado') == 'mora' ? 'selected' : '' }}>En Mora</option>
                </select>
            </div>

            <!-- Rango de monto -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Monto Mínimo</label>
                <input type="number" 
                       name="monto_min" 
                       value="{{ request('monto_min') }}"
                       placeholder="Bs 0"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
            </div>

            <!-- Ordenar -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Ordenar por</label>
                <select name="orden" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    <option value="">Más recientes</option>
                    <option value="monto_asc" {{ request('orden') == 'monto_asc' ? 'selected' : '' }}>Monto: Menor a mayor</option>
                    <option value="monto_desc" {{ request('orden') == 'monto_desc' ? 'selected' : '' }}>Monto: Mayor a menor</option>
                    <option value="fecha_asc" {{ request('orden') == 'fecha_asc' ? 'selected' : '' }}>Fecha: Más antiguos</option>
                    <option value="fecha_desc" {{ request('orden') == 'fecha_desc' ? 'selected' : '' }}>Fecha: Más recientes</option>
                </select>
            </div>

            <!-- Botón filtrar -->
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                    </svg>
                    <span>Filtrar</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de Préstamos -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Lista de Préstamos</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-slate-600">
                        {{ $prestamos->total() }} préstamos encontrados
                    </span>
                    <button class="p-2 text-slate-400 hover:text-slate-600 transition-colors duration-200 rounded-lg hover:bg-slate-100" title="Actualizar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Código</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Cliente</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Monto</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Plazo</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Estado</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Fecha</th>
                        <th class="text-right py-4 px-6 font-semibold text-slate-700 text-sm">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($prestamos as $prestamo)
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <!-- Código -->
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <span class="text-xs font-semibold text-blue-600">#{{ substr($prestamo->codigo, -3) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-slate-900">{{ $prestamo->codigo }}</span>
                                </div>
                            </td>

                            <!-- Cliente -->
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-slate-400 to-slate-500 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-semibold text-white">{{ strtoupper(substr($prestamo->usuario->nombre_completo, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $prestamo->usuario->nombre_completo }}</p>
                                        <p class="text-xs text-slate-500">{{ $prestamo->usuario->correo }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Monto -->
                            <td class="py-4 px-6">
                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-600">Bs {{ number_format($prestamo->monto, 2) }}</p>
                                    @if($prestamo->cuota_mensual)
                                        <p class="text-xs text-slate-500">Cuota: Bs {{ number_format($prestamo->cuota_mensual, 2) }}</p>
                                    @endif
                                </div>
                            </td>

                            <!-- Plazo -->
                            <td class="py-4 px-6">
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $prestamo->plazo_meses }} meses</p>
                                    <p class="text-xs text-slate-500">{{ ucfirst($prestamo->frecuencia_pago ?? 'Mensual') }}</p>
                                </div>
                            </td>

                            <!-- Estado -->
                            <td class="py-4 px-6">
                                @php
                                    $estadoConfig = [
                                        'vigente' => [
                                            'bg' => 'bg-blue-100',
                                            'text' => 'text-blue-800',
                                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                        ],
                                        'cancelado' => [
                                            'bg' => 'bg-green-100',
                                            'text' => 'text-green-800',
                                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                        ],
                                        'mora' => [
                                            'bg' => 'bg-red-100',
                                            'text' => 'text-red-800',
                                            'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                                        ]
                                    ];
                                    $config = $estadoConfig[$prestamo->estado] ?? $estadoConfig['vigente'];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                    </svg>
                                    {{ ucfirst($prestamo->estado) }}
                                </span>
                            </td>

                            <!-- Fecha -->
                            <td class="py-4 px-6">
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ \Carbon\Carbon::parse($prestamo->fecha_desembolso)->format('d/m/Y') }}</p>
                                    <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($prestamo->fecha_desembolso)->diffForHumans() }}</p>
                                </div>
                            </td>

                            <!-- Acciones -->
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-1">
                                    <!-- Ver detalles -->
                                    <a href="{{ route('admin.prestamos.show', $prestamo->id) }}" 
                                       class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                       title="Ver detalles">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>

                                    <!-- Plan de pagos -->
                                    <a href="{{ route('admin.prestamos.plan-pagos', $prestamo->id) }}"
                                       class="p-2 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200"
                                       title="Ver Plan de Pagos">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>

                                    <!-- Editar -->
                                    <a href="{{ route('admin.prestamos.edit', $prestamo->id) }}"
                                       class="p-2 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                       title="Editar Préstamo">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <!-- Dropdown de más opciones -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" 
                                                class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors duration-200" 
                                                title="Más opciones">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                            </svg>
                                        </button>
                                        
                                        <div x-show="open" 
                                             @click.away="open = false" 
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-2 z-20">
                                            
                                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Generar reporte
                                            </a>
                                            
                                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v2m-6 0a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H10z"></path>
                                                </svg>
                                                Programar recordatorio
                                            </a>

                                            <div class="border-t border-slate-200 my-2"></div>
                                            
                                            <form action="{{ route('admin.prestamos.destroy', $prestamo->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este préstamo? Esta acción no se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="flex items-center w-full px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Eliminar préstamo
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-900 mb-2">No hay préstamos registrados</h3>
                                    <p class="text-slate-500 mb-6 max-w-sm">No se encontraron préstamos que coincidan con los filtros aplicados</p>
                                    <a href="{{ route('admin.prestamos.create') }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 shadow-sm">
                                        Crear Primer Préstamo
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($prestamos->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-600">
                        Mostrando <span class="font-medium">{{ $prestamos->firstItem() }}</span> a <span class="font-medium">{{ $prestamos->lastItem() }}</span> de <span class="font-medium">{{ $prestamos->total() }}</span> préstamos
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $prestamos->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Alpine.js -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    /* Estilos personalizados para mejorar las transiciones */
    [x-cloak] { display: none !important; }
    
    /* Mejoras en los botones de paginación */
    .pagination {
        @apply flex items-center space-x-1;
    }
    
    .pagination .page-link {
        @apply px-3 py-2 text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors duration-200;
    }
    
    .pagination .page-item.active .page-link {
        @apply bg-blue-600 text-white hover:bg-blue-700;
    }
    
    .pagination .page-item.disabled .page-link {
        @apply text-slate-400 cursor-not-allowed hover:bg-transparent;
    }
</style>
@endsection
