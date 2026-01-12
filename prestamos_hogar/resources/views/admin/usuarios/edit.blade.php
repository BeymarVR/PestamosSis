@extends('layouts.app')

@section('page-title', 'Editar Usuario')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Editar Usuario</h1>
            <p class="mt-1 text-sm text-slate-600">Modifica la información de {{ $usuario->nombre_completo }}</p>
        </div>
        <a href="{{ route('admin.usuarios.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Volver</span>
        </a>
    </div>

    <!-- User Info Card -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                <span class="text-xl font-bold text-white">{{ substr($usuario->nombre_completo, 0, 2) }}</span>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-900">{{ $usuario->nombre_completo }}</h3>
                <p class="text-slate-600">{{ $usuario->correo }}</p>
                <div class="flex items-center space-x-2 mt-1">
                    @php
                        $rolColors = [
                            'admin' => 'bg-purple-100 text-purple-800',
                            'gestor' => 'bg-green-100 text-green-800',
                            'usuario' => 'bg-blue-100 text-blue-800'
                        ];
                        $rolColor = $rolColors[$usuario->rol->nombre] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $rolColor }}">
                        {{ ucfirst($usuario->rol->nombre) }}
                    </span>
                    <span class="text-sm text-slate-500">• Registrado el {{ $usuario->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Actualizar Información</h3>
            <p class="text-sm text-slate-600">Los campos marcados con * son obligatorios</p>
        </div>

        <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="text-red-800 font-medium">Por favor corrige los siguientes errores:</span>
                    </div>
                    <ul class="text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Personal Information Section -->
            <div class="space-y-6">
                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="text-lg font-medium text-slate-900">Información Personal</h4>
                    <p class="text-sm text-slate-600">Datos básicos del usuario</p>
                </div>

                <!-- Full Name -->
                <div class="space-y-2">
                    <label for="nombre_completo" class="block text-sm font-medium text-slate-700">
                        Nombre Completo *
                    </label>
                    <input 
                        type="text" 
                        id="nombre_completo"
                        name="nombre_completo" 
                        value="{{ old('nombre_completo', $usuario->nombre_completo) }}"
                        class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('nombre_completo') border-red-300 @enderror"
                        required
                    >
                    @error('nombre_completo')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email and CI -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="correo" class="block text-sm font-medium text-slate-700">
                            Correo Electrónico *
                        </label>
                        <input 
                            type="email" 
                            id="correo"
                            name="correo" 
                            value="{{ old('correo', $usuario->correo) }}"
                            class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('correo') border-red-300 @enderror"
                            required
                        >
                        @error('correo')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="ci" class="block text-sm font-medium text-slate-700">
                            Cédula de Identidad *
                        </label>
                        <input 
                            type="text" 
                            id="ci"
                            name="ci" 
                            value="{{ old('ci', $usuario->ci) }}"
                            class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('ci') border-red-300 @enderror"
                            required
                        >
                        @error('ci')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Expedido and Phone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="expedido" class="block text-sm font-medium text-slate-700">
                            Expedido en
                        </label>
                        <select 
                            id="expedido"
                            name="expedido" 
                            class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('expedido') border-red-300 @enderror"
                        >
                            <option value="">Seleccionar departamento</option>
                            <option value="LP" {{ old('expedido', $usuario->expedido) == 'LP' ? 'selected' : '' }}>La Paz</option>
                            <option value="CB" {{ old('expedido', $usuario->expedido) == 'CB' ? 'selected' : '' }}>Cochabamba</option>
                            <option value="SC" {{ old('expedido', $usuario->expedido) == 'SC' ? 'selected' : '' }}>Santa Cruz</option>
                            <option value="OR" {{ old('expedido', $usuario->expedido) == 'OR' ? 'selected' : '' }}>Oruro</option>
                            <option value="PT" {{ old('expedido', $usuario->expedido) == 'PT' ? 'selected' : '' }}>Potosí</option>
                            <option value="TJ" {{ old('expedido', $usuario->expedido) == 'TJ' ? 'selected' : '' }}>Tarija</option>
                            <option value="CH" {{ old('expedido', $usuario->expedido) == 'CH' ? 'selected' : '' }}>Chuquisaca</option>
                            <option value="BE" {{ old('expedido', $usuario->expedido) == 'BE' ? 'selected' : '' }}>Beni</option>
                            <option value="PD" {{ old('expedido', $usuario->expedido) == 'PD' ? 'selected' : '' }}>Pando</option>
                        </select>
                        @error('expedido')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="celular" class="block text-sm font-medium text-slate-700">
                            Número de Celular
                        </label>
                        <input 
                            type="text" 
                            id="celular"
                            name="celular" 
                            value="{{ old('celular', $usuario->celular) }}"
                            class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('celular') border-red-300 @enderror"
                        >
                        @error('celular')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div class="space-y-6">
                <div class="border-l-4 border-green-500 pl-4">
                    <h4 class="text-lg font-medium text-slate-900">Información de Seguridad</h4>
                    <p class="text-sm text-slate-600">Rol y credenciales de acceso</p>
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label for="rol_id" class="block text-sm font-medium text-slate-700">
                        Rol del Usuario *
                    </label>
                    <select 
                        id="rol_id"
                        name="rol_id" 
                        class="w-full px-3 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('rol_id') border-red-300 @enderror"
                        required
                    >
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}" {{ old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : '' }}>
                                {{ ucfirst($rol->nombre) }}
                                @if($rol->nombre == 'admin') - Acceso completo al sistema @endif
                                @if($rol->nombre == 'gestor') - Gestión de préstamos y clientes @endif
                                @if($rol->nombre == 'usuario') - Acceso limitado a sus préstamos @endif
                            </option>
                        @endforeach
                    </select>
                    @error('rol_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Change Section -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <h5 class="text-sm font-medium text-yellow-900">Cambio de Contraseña</h5>
                    </div>
                    <p class="text-sm text-yellow-800 mb-4">Deja estos campos en blanco si no deseas cambiar la contraseña actual.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="contrasena" class="block text-sm font-medium text-slate-700">
                                Nueva Contraseña
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="contrasena"
                                    name="contrasena" 
                                    placeholder="Nueva contraseña (opcional)"
                                    class="w-full px-3 py-3 pr-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('contrasena') border-red-300 @enderror"
                                >
                                <button 
                                    type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePassword('contrasena')"
                                >
                                    <svg class="h-5 w-5 text-slate-400 hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('contrasena')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="contrasena_confirmation" class="block text-sm font-medium text-slate-700">
                                Confirmar Nueva Contraseña
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="contrasena_confirmation"
                                    name="contrasena_confirmation" 
                                    placeholder="Confirmar nueva contraseña"
                                    class="w-full px-3 py-3 pr-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                >
                                <button 
                                    type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePassword('contrasena_confirmation')"
                                >
                                    <svg class="h-5 w-5 text-slate-400 hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.usuarios.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors duration-200">
                    Cancelar
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Actualizar Usuario</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
        field.setAttribute('type', type);
    }
</script>
@endsection
