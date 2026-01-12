<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel | Sistema de Préstamos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-slate-50 font-inter">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-white border-r border-slate-200 shadow-sm">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-6 pb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-slate-900">PréstamosFácil</h1>
                            <p class="text-xs text-slate-500">Sistema de Gestión</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 pb-4 space-y-1">
                    @auth
                        @if(auth()->user()->rol->nombre === 'admin')
                            <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                Dashboard
                            </a>
                            
                            <a href="{{ route('admin.usuarios.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.usuarios.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 w-5 h-5 {{ request()->routeIs('admin.usuarios.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Usuarios
                            </a>
                            
                            <a href="{{ route('admin.prestamos.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('prestamos.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 w-5 h-5 {{ request()->routeIs('prestamos.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Préstamos
                            </a>

<a href="{{ route('admin.solicitud-credito.index') }}" 
       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 
              {{ request()->routeIs('admin.solicitud-credito.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
        <svg class="mr-3 w-5 h-5 {{ request()->routeIs('admin.solicitud-credito.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Solicitudes de Crédito
    </a>

                               <a href="{{ route('admin.capital.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.capital.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
        <svg class="mr-3 w-5 h-5 {{ request()->routeIs('admin.capital.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Capital
    </a>


                          <!-- DASHBOARD GESTOR -->
                        @elseif(auth()->user()->rol->nombre === 'gestor')
                            <a href="{{ route('gestor.dashboard') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('gestor.dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 w-5 h-5 {{ request()->routeIs('gestor.dashboard') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Dashboard
                            </a>
                            <!-- Usuarios -->
<a href="{{ route('gestor.usuarios.index') }}"
   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('gestor.usuarios.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
    <svg class="mr-3 w-5 h-5 {{ request()->routeIs('gestor.usuarios.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5.121 17.804A4 4 0 017 17h10a4 4 0 011.879.804M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    Clientes
</a>

<!-- Préstamos -->
<a href="{{ route('gestor.prestamos.index') }}"
   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('gestor.prestamos.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
    <svg class="mr-3 w-5 h-5 {{ request()->routeIs('gestor.prestamos.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
    Préstamos
</a>

<!-- Capital -->
<a href="{{ route('gestor.capital.index') }}"
   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('gestor.capital.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
    <svg class="mr-3 w-5 h-5 {{ request()->routeIs('gestor.capital.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Capital
</a>



                            <!-- DASHBOARD USUARIOS -->
                        @else
                             <a href="{{ route('usuario.dashboard') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 
                   {{ request()->routeIs('usuario.dashboard') ? 'bg-purple-50 text-purple-700 border-r-2 border-purple-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="mr-2 w-4 h-4 {{ request()->routeIs('usuario.dashboard') ? 'text-purple-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Mi Préstamo
                </a>
                
                <a href="{{ route('usuario.prestamos') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 
                   {{ request()->routeIs('usuario.prestamos*') ? 'bg-purple-50 text-purple-700 border-r-2 border-purple-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="mr-2 w-4 h-4 {{ request()->routeIs('usuario.prestamos*') ? 'text-purple-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Mis Préstamos
                </a>
                
                <a href="{{ route('usuario.historial') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 
                   {{ request()->routeIs('usuario.historial') ? 'bg-purple-50 text-purple-700 border-r-2 border-purple-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="mr-2 w-4 h-4 {{ request()->routeIs('usuario.historial') ? 'text-purple-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Historial
                </a>
                
                <a href="{{ route('usuario.perfil') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 
                   {{ request()->routeIs('usuario.perfil') ? 'bg-purple-50 text-purple-700 border-r-2 border-purple-700' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="mr-2 w-4 h-4 {{ request()->routeIs('usuario.perfil') ? 'text-purple-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Mi Perfil
                </a>

                            
                        @endif

                        <!-- Divider -->
                        <div class="pt-4 mt-4 border-t border-slate-200">
                            <div class="px-3 py-2">
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Cuenta</p>
                            </div>
                        </div>

                        <!-- User Profile -->
                        <div class="px-3 py-2">
                            <div class="flex items-center space-x-3 p-2 rounded-lg bg-slate-50">
                                <div class="w-8 h-8 bg-gradient-to-br from-slate-400 to-slate-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-medium text-white">{{ substr(auth()->user()->nombre_completo, 0, 2) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate">{{ auth()->user()->nombre_completo }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->rol->nombre }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="group flex items-center w-full px-3 py-2.5 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                <svg class="mr-3 w-5 h-5 text-red-500 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    @endauth
                </nav>
            </div>
        </aside>

        <!-- Mobile sidebar -->
        <div class="md:hidden">
            <div class="fixed inset-0 flex z-40" id="mobile-menu" style="display: none;">
                <div class="fixed inset-0 bg-slate-600 bg-opacity-75" onclick="toggleMobileMenu()"></div>
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" onclick="toggleMobileMenu()">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Mobile navigation content (same as desktop) -->
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top bar -->
            <header class="bg-white border-b border-slate-200 shadow-sm">
                <div class="flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                    <div class="flex items-center">
                        <button type="button" class="md:hidden -ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-slate-500 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" onclick="toggleMobileMenu()">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="ml-2 text-lg font-semibold text-slate-900">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
<!-- 🔔 Notificaciones con clases específicas -->
<div class="notification-container">
    <button onclick="toggleDropdown()" class="notification-btn" id="notificationBtn">
        <svg class="notification-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @php
            $notiCount = \App\Models\Notificacion::where('usuario_id', auth()->id())
                        ->where('leida', false)->count();
        @endphp
        
        @if($notiCount > 0)
            <span class="notification-badge" id="notificationBadge">
                {{ $notiCount > 99 ? '99+' : $notiCount }}
            </span>
        @endif
    </button>

    <!-- 🔻 Dropdown de Notificaciones -->
    <div id="dropdownNotificaciones" class="notification-dropdown hidden">
        <div class="notification-header">
            <div class="notification-header-content">
                <h3 class="notification-header-title">Notificaciones</h3>
                @if($notiCount > 0)
                    <button onclick="markAllAsRead()" class="notification-mark-all-btn">
                        Marcar todas como leídas
                    </button>
                @endif
            </div>
            @if($notiCount > 0)
                <p class="notification-header-subtitle">
                    Tienes {{ $notiCount }} notificación{{ $notiCount > 1 ? 'es' : '' }} sin leer
                </p>
            @endif
        </div>

        <div class="notifications-content">
            @php
                $notificaciones = \App\Models\Notificacion::where('usuario_id', auth()->id())
                    ->orderBy('created_at', 'desc')->take(10)->get();
            @endphp

            @forelse ($notificaciones as $noti)
                <div class="notification-item {{ !$noti->leida ? 'unread' : 'read' }}" 
                     data-id="{{ $noti->id }}" 
                     onclick="markAsRead({{ $noti->id }})">
                    
                    <div class="notification-icon-wrapper">
                        @php
                            $tipo = $noti->tipo ?? 'general';
                            $iconClass = match($tipo) {
                                'prestamo' => 'notification-icon-loan',
                                'pago' => 'notification-icon-payment',
                                'vencimiento' => 'notification-icon-due',
                                default => 'notification-icon-general'
                            };
                        @endphp
                        <div class="notification-type-icon {{ $iconClass }}">
                            @switch($tipo)
                                @case('prestamo')
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V19A2 2 0 0 0 5 21H19A2 2 0 0 0 21 19V9M19 19H5V3H13V9H19Z"/>
                                    </svg>
                                    @break
                                @case('pago')
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z"/>
                                    </svg>
                                    @break
                                @case('vencimiento')
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z"/>
                                    </svg>
                                    @break
                                @default
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13,14H11V10H13M13,18H11V16H13M1,21H23L12,2L1,21Z"/>
                                    </svg>
                            @endswitch
                        </div>
                    </div>

                    <div class="notification-content">
                        <p class="notification-message">{{ $noti->mensaje }}</p>
                        <div class="notification-meta">
                            <span class="notification-time">
                                <svg class="notification-time-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.7L16.2,16.2Z"/>
                                </svg>
                                {{ $noti->created_at->diffForHumans() }}
                            </span>
                            @if(!$noti->leida)
                                <span class="notification-unread-indicator"></span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="notification-empty-state">
                    <div class="notification-empty-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.19 14,4.29 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21"/>
                        </svg>
                    </div>
                    <p class="notification-empty-message">No tienes notificaciones recientes</p>
                </div>
            @endforelse
        </div>

        @if($notificaciones->count() > 0)
            <div class="notification-footer">
                <button onclick="viewAllNotifications()" class="notification-view-all-btn">
                    Ver todas las notificaciones
                </button>
            </div>
        @endif
    </div>
</div>


                        
                        <!-- User menu -->
                        <div class="relative">
                            <div class="flex items-center space-x-3">
                                <span class="text-sm font-medium text-slate-700 hidden sm:block">{{ auth()->user()->nombre_completo }}</span>
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-medium text-white">{{ substr(auth()->user()->nombre_completo, 0, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto bg-slate-50">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>        
        

<style>
/* 🔔 Estilos específicos solo para notificaciones */
.notification-container {
    position: relative;
    margin-left: 1rem;
}

.notification-btn {
    position: relative;
    background: none;
    border: none;
    padding: 0.5rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-btn:hover {
    background-color: #f3f4f6;
    transform: translateY(-1px);
}

.notification-icon {
    width: 1.5rem;
    height: 1.5rem;
    color: #374151;
    transition: color 0.2s ease;
}

.notification-btn:hover .notification-icon {
    color: #2563eb;
}

.notification-badge {
    position: absolute;
    top: -0.25rem;
    right: -0.25rem;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.125rem 0.375rem;
    border-radius: 9999px;
    min-width: 1.25rem;
    height: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: notification-pulse 2s infinite;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
}

@keyframes notification-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

.notification-dropdown {
    position: absolute;
    right: 0;
    top: calc(100% + 0.5rem);
    width: 24rem;
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border: 1px solid #e5e7eb;
    z-index: 9999;
    overflow: hidden;
    animation: notification-slideDown 0.2s ease-out;
}

@keyframes notification-slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.notification-header {
    padding: 1rem 1.25rem 0.75rem;
    background: linear-gradient(135deg, #f9fafb, #f3f4f6);
    border-bottom: 1px solid #e5e7eb;
}

.notification-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.notification-header-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
    margin: 0;
}

.notification-mark-all-btn {
    background: none;
    border: none;
    color: #2563eb;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    transition: all 0.2s ease;
}

.notification-mark-all-btn:hover {
    background-color: #dbeafe;
    color: #1d4ed8;
}

.notification-header-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.notifications-content {
    max-height: 20rem;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #d1d5db #f9fafb;
}

.notifications-content::-webkit-scrollbar {
    width: 6px;
}

.notifications-content::-webkit-scrollbar-track {
    background: #f9fafb;
}

.notifications-content::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 3px;
}

.notification-item {
    display: flex;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f3f4f6;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.notification-item:hover {
    background-color: #f9fafb;
}

.notification-item.unread {
    background: linear-gradient(90deg, #dbeafe 0%, #f0f9ff 100%);
    border-left: 4px solid #2563eb;
}

.notification-item.unread .notification-message {
    font-weight: 500;
    color: #111827;
}

.notification-icon-wrapper {
    flex-shrink: 0;
    margin-right: 0.75rem;
    margin-top: 0.125rem;
}

.notification-type-icon {
    width: 2rem;
    height: 2rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-type-icon svg {
    width: 1rem;
    height: 1rem;
}

.notification-icon-loan {
    background-color: #dcfce7;
    color: #16a34a;
}

.notification-icon-payment {
    background-color: #dbeafe;
    color: #2563eb;
}

.notification-icon-due {
    background-color: #fed7aa;
    color: #ea580c;
}

.notification-icon-general {
    background-color: #f3f4f6;
    color: #6b7280;
}

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-message {
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.notification-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.notification-time {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: #6b7280;
}

.notification-time-icon {
    width: 0.75rem;
    height: 0.75rem;
}

.notification-unread-indicator {
    width: 0.5rem;
    height: 0.5rem;
    background-color: #2563eb;
    border-radius: 50%;
    flex-shrink: 0;
}

.notification-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 1.5rem;
    text-align: center;
}

.notification-empty-icon {
    width: 3rem;
    height: 3rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.notification-empty-icon svg {
    width: 100%;
    height: 100%;
}

.notification-empty-message {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.notification-footer {
    padding: 0.75rem;
    background-color: #f9fafb;
    border-top: 1px solid #e5e7eb;
}

.notification-view-all-btn {
    width: 100%;
    background: none;
    border: none;
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.5rem;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.notification-view-all-btn:hover {
    background-color: white;
    color: #111827;
}

/* Responsive para notificaciones */
@media (max-width: 640px) {
    .notification-dropdown {
        width: 20rem;
        right: -2rem;
    }
}

</style>



<script>
// 🚀 JavaScript Mejorado
function toggleDropdown() {
    const dropdown = document.getElementById('dropdownNotificaciones');
    const btn = document.getElementById('notificationBtn');
    
    if (dropdown.classList.contains('hidden')) {
        dropdown.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
        
        // Cerrar al hacer clic fuera
        setTimeout(() => {
            document.addEventListener('click', closeOnClickOutside);
        }, 100);
    } else {
        dropdown.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
        document.removeEventListener('click', closeOnClickOutside);
    }
}

function closeOnClickOutside(event) {
    const container = document.querySelector('.notification-container');
    if (!container.contains(event.target)) {
        document.getElementById('dropdownNotificaciones').classList.add('hidden');
        document.getElementById('notificationBtn').setAttribute('aria-expanded', 'false');
        document.removeEventListener('click', closeOnClickOutside);
    }
}

function markAsRead(notificationId) {
    // Actualizar visualmente
    const item = document.querySelector(`[data-id="${notificationId}"]`);
    if (item && item.classList.contains('unread')) {
        item.classList.remove('unread');
        item.classList.add('read');
        
        // Remover indicador de no leída
        const indicator = item.querySelector('.unread-indicator');
        if (indicator) {
            indicator.remove();
        }
        
        // Actualizar contador
        updateNotificationCount();
    }
    
    // Enviar petición AJAX para marcar como leída en la base de datos
    fetch('/notifications/mark-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: notificationId })
    }).catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function markAllAsRead() {
    // Actualizar visualmente todas las notificaciones
    const unreadItems = document.querySelectorAll('.notification-item.unread');
    unreadItems.forEach(item => {
        item.classList.remove('unread');
        item.classList.add('read');
        
        const indicator = item.querySelector('.unread-indicator');
        if (indicator) {
            indicator.remove();
        }
    });
    
    // Ocultar botón y actualizar contador
    const markAllBtn = document.querySelector('.mark-all-btn');
    if (markAllBtn) {
        markAllBtn.style.display = 'none';
    }
    
    updateNotificationCount();
    
    // Enviar petición AJAX
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).catch(error => {
        console.error('Error marking all notifications as read:', error);
    });
}

function updateNotificationCount() {
    const badge = document.getElementById('notificationBadge');
    const unreadCount = document.querySelectorAll('.notification-item.unread').length;
    
    if (unreadCount === 0) {
        if (badge) {
            badge.style.display = 'none';
        }
    } else {
        if (badge) {
            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
            badge.style.display = 'flex';
        }
    }
}

function viewAllNotifications() {
    // Redirigir a la página completa de notificaciones
    window.location.href = '/admin/notificaciones';
}

// Cerrar dropdown con tecla Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const dropdown = document.getElementById('dropdownNotificaciones');
        if (!dropdown.classList.contains('hidden')) {
            dropdown.classList.add('hidden');
            document.getElementById('notificationBtn').setAttribute('aria-expanded', 'false');
        }
    }
});

// Accesibilidad: navegación con teclado
document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter' || event.key === ' ') {
        const target = event.target;
        if (target.classList.contains('notification-item')) {
            event.preventDefault();
            const notificationId = target.getAttribute('data-id');
            markAsRead(notificationId);
        }
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
