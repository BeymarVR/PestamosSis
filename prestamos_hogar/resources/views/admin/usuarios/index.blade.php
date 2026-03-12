@extends('layouts.app')

@section('page-title', 'Gestión de Usuarios')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Usuarios Registrados</h1>
            <p class="mt-1 text-sm text-slate-600">Gestiona todos los usuarios del sistema</p>
        </div>
<div class="flex items-center space-x-3">
            <a href="{{ route('admin.usuarios.exportar', request()->query()) }}" 
   class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    <span>Exportar</span>
</a>


            <a href="{{ route('admin.usuarios.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Nuevo Usuario</span>
            </a>
        </div>
    </div>

    <!-- Filters -->
     <form method="GET" action="{{ route('admin.usuarios.index') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Buscar</label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre o correo..." class="w-full px-3 py-2 border rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Rol</label>
            <select name="rol" class="w-full px-3 py-2 border rounded-lg">
                <option value="">Todos los roles</option>
                <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="gestor" {{ request('rol') == 'gestor' ? 'selected' : '' }}>Gestor</option>
                <option value="usuario" {{ request('rol') == 'usuario' ? 'selected' : '' }}>Usuario</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Estado</label>
            <select name="estado" class="w-full px-3 py-2 border rounded-lg">
                <option value="">Todos</option>
                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg font-medium">
                Filtrar
            </button>
            <a href="{{ route('admin.usuarios.index') }}" class="px-4 py-2 text-slate-600 hover:text-slate-800 border border-slate-300 rounded-lg transition-colors duration-200">
                        Limpiar
                    </a>
        </div>
    </div>
</form>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Usuarios</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $usuarios->total() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Registrados en el sistema</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Administradores</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $usuarios->where('rol.nombre', 'admin')->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Con acceso completo</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Gestores</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $usuarios->where('rol.nombre', 'gestor')->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Gestión operativa</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Clientes</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $usuarios->where('rol.nombre', 'usuario')->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1">Usuarios finales</p>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Lista de Usuarios</h3>
                <div class="flex items-center space-x-2">
                    <button class="p-2 text-slate-400 hover:text-slate-600 transition-colors duration-200 rounded-lg hover:bg-slate-100" title="Exportar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </button>
                    <button class="p-2 text-slate-400 hover:text-slate-600 transition-colors duration-200 rounded-lg hover:bg-slate-100" title="Actualizar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Usuario</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Información</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Rol</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Estado</th>
                        <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Registro</th>
                        <th class="text-right py-4 px-6 font-semibold text-slate-700 text-sm">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($usuarios as $usuario)
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <!-- Usuario -->
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-sm">
                                        <span class="text-sm font-semibold text-white">{{ strtoupper(substr($usuario->nombre_completo, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $usuario->nombre_completo }}</p>
                                        <p class="text-sm text-slate-500">{{ $usuario->correo }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Información -->
                            <td class="py-4 px-6">
                                <div class="space-y-1">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                        </svg>
                                        <span class="text-sm text-slate-900">{{ $usuario->ci }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <span class="text-sm text-slate-500">{{ $usuario->celular ?? 'No registrado' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Rol -->
                            <td class="py-4 px-6">
                                @php
                                    $rolConfig = [
                                        'admin' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                                        'gestor' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                                        'usuario' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z']
                                    ];
                                    $config = $rolConfig[$usuario->rol->nombre] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                    </svg>
                                    {{ ucfirst($usuario->rol->nombre) }}
                                </span>
                            </td>

                            <!-- Estado -->
                            <td class="py-4 px-6">
                                @if($usuario->activo ?? true)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-2 h-2 mr-1.5 fill-current" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-2 h-2 mr-1.5 fill-current" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        Inactivo
                                    </span>
                                @endif
                            </td>

                            <!-- Registro -->
                            <td class="py-4 px-6">
                                <div class="space-y-1">
                                    <p class="text-sm font-medium text-slate-900">{{ $usuario->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-slate-500">{{ $usuario->created_at->format('H:i') }}</p>
                                </div>
                            </td>

                            <!-- Acciones -->
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-1">
                                    <!-- Ver Score IA -->
                                    <a href="{{ route('admin.usuarios.scoreia', $usuario->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 hover:border-blue-300 transition-colors duration-200"
                                       title="Ver Score IA">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                        Score
                                    </a>
                                    <!-- Ver Detalles -->
                                    <a href="{{ route('admin.usuarios.show', $usuario->id) }}" class="p-2 text-slate-400 hover:text-blue-600" title="Ver detalles">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                    <!-- Editar -->
                                    <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" 
                                       class="p-2 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200" 
                                       title="Editar usuario">
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
                                             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-2 z-20">
                                            
                                            <!-- Ver préstamos -->
                                            <a href="{{ route('admin.prestamos.index', ['usuario_id' => $usuario->id]) }}" 
                                               class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Ver préstamos
                                            </a>
                                            
                                            <!-- Historial -->
                                            <a href="{{ route('admin.usuarios.historial', $usuario->id) }}" 
                                               class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Historial completo
                                            </a>

                                            <!-- Separador -->
                                            <div class="border-t border-slate-200 my-2"></div>
                                            
                                            <!-- Activar/Desactivar -->
                                            @if ($usuario->activo)
                                                <form action="{{ route('admin.usuarios.desactivar', $usuario->id) }}" method="POST" class="block">
                                                    @csrf
                                                    <button type="submit" 
                                                            onclick="return confirm('¿Estás seguro de que deseas desactivar este usuario?')"
                                                            class="flex items-center w-full px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                                        <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                        </svg>
                                                        Desactivar usuario
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.usuarios.activar', $usuario->id) }}" method="POST" class="block">
                                                    @csrf
                                                    <button type="submit" 
                                                            onclick="return confirm('¿Estás seguro de que deseas activar este usuario?')"
                                                            class="flex items-center w-full px-4 py-2.5 text-sm text-green-700 hover:bg-green-50 transition-colors duration-200">
                                                        <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Activar usuario
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-900 mb-2">No hay usuarios registrados</h3>
                                    <p class="text-slate-500 mb-6 max-w-sm">Comienza agregando el primer usuario al sistema para gestionar el acceso y permisos</p>
                                    <a href="{{ route('admin.usuarios.create') }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 shadow-sm">
                                        Crear Primer Usuario
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($usuarios->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-600">
                        Mostrando <span class="font-medium">{{ $usuarios->firstItem() }}</span> a <span class="font-medium">{{ $usuarios->lastItem() }}</span> de <span class="font-medium">{{ $usuarios->total() }}</span> resultados
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $usuarios->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Alpine.js for dropdowns -->
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
