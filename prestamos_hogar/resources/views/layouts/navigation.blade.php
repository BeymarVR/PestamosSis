@php
$user_role = Auth::user()->role ?? 'usuario';
$current_route = Route::currentRouteName();

$navigation = [
    'admin' => [
        ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home'],
        ['name' => 'Usuarios', 'route' => 'admin.usuarios.index', 'icon' => 'users'],
        ['name' => 'Préstamos', 'route' => 'admin.prestamos.index', 'icon' => 'credit-card'],
        ['name' => 'Reportes', 'route' => 'admin.reportes.index', 'icon' => 'chart-bar'],
        ['name' => 'Configuración', 'route' => 'admin.configuracion', 'icon' => 'cog'],
    ],
    'gestor' => [
        ['name' => 'Dashboard', 'route' => 'gestor.dashboard', 'icon' => 'home'],
        ['name' => 'Préstamos', 'route' => 'gestor.prestamos.index', 'icon' => 'credit-card'],
        ['name' => 'Clientes', 'route' => 'gestor.clientes.index', 'icon' => 'users'],
        ['name' => 'Evaluaciones', 'route' => 'gestor.evaluaciones.index', 'icon' => 'clipboard-check'],
    ],
    'usuario' => [
        ['name' => 'Mi Dashboard', 'route' => 'usuario.dashboard', 'icon' => 'home'],
        ['name' => 'Mis Préstamos', 'route' => 'usuario.prestamos.index', 'icon' => 'credit-card'],
        ['name' => 'Solicitar Préstamo', 'route' => 'usuario.prestamos.create', 'icon' => 'plus-circle'],
        ['name' => 'Mi Perfil', 'route' => 'usuario.perfil', 'icon' => 'user'],
    ]
];

$icons = [
    'home' => '<svg ...></svg>', // SVG icon for home
    'users' => '<svg ...></svg>', // SVG icon for users
    'credit-card' => '<svg ...></svg>', // SVG icon for credit card
    'chart-bar' => '<svg ...></svg>', // SVG icon for chart
    'cog' => '<svg ...></svg>', // SVG icon for settings
    'clipboard-check' => '<svg ...></svg>', // SVG icon for clipboard
    'plus-circle' => '<svg ...></svg>', // SVG icon for plus
    'user' => '<svg ...></svg>', // SVG icon for user
];

$user_navigation = $navigation[$user_role] ?? [];
@endphp

@foreach($user_navigation as $item)
    @php
        $is_active = $current_route === $item['route'];
    @endphp
    
    <a href="{{ route($item['route']) }}" 
       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ $is_active 
           ? 'bg-blue-600 text-white shadow-lg' 
           : 'text-gray-700 hover:bg-blue-100 hover:text-blue-600' }}">
        <span class="mr-3 flex-shrink-0 h-6 w-6">
            {!! $icons[$item['icon']] !!}
        </span>
        {{ $item['name'] }}
        
        @if($is_active)
            <div class="ml-auto">
                <div class="w-2 h-2 bg-blue-200 rounded-full"></div>
            </div>
        @endif
    </a>
@endforeach

<!-- Logout Button -->
<div class="mt-8 pt-4 border-t border-gray-300">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" 
                class="group flex items-center w-full px-2 py-2 text-sm font-medium text-red-600 hover:bg-red-600 hover:text-white transition-all duration-200">
            <svg class="mr-3 flex-shrink-0 h-6 w-6 text-red-600 group-hover:text-white" 
                 stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Cerrar Sesión
        </button>
    </form>
</div>