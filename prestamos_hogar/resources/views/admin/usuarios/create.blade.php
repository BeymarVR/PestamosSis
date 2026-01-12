@extends('layouts.app')

@section('page-title', 'Crear Nuevo Usuario')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Crear Nuevo Usuario</h1>
            <p class="mt-1 text-sm text-slate-600">Completa la información para registrar un nuevo usuario en el sistema</p>
        </div>
        <a href="{{ route('admin.usuarios.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Volver</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Información del Usuario</h3>
            <p class="text-sm text-slate-600">Los campos marcados con * son obligatorios</p>
        </div>

        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

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
                        value="{{ old('nombre_completo') }}"
                        placeholder="Ej: Juan Carlos Pérez López"
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
                            value="{{ old('correo') }}"
                            placeholder="ejemplo@correo.com"
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
                            value="{{ old('ci') }}"
                            placeholder="12345678"
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
                            <option value="LP" {{ old('expedido') == 'LP' ? 'selected' : '' }}>La Paz</option>
                            <option value="CB" {{ old('expedido') == 'CB' ? 'selected' : '' }}>Cochabamba</option>
                            <option value="SC" {{ old('expedido') == 'SC' ? 'selected' : '' }}>Santa Cruz</option>
                            <option value="OR" {{ old('expedido') == 'OR' ? 'selected' : '' }}>Oruro</option>
                            <option value="PT" {{ old('expedido') == 'PT' ? 'selected' : '' }}>Potosí</option>
                            <option value="TJ" {{ old('expedido') == 'TJ' ? 'selected' : '' }}>Tarija</option>
                            <option value="CH" {{ old('expedido') == 'CH' ? 'selected' : '' }}>Chuquisaca</option>
                            <option value="BE" {{ old('expedido') == 'BE' ? 'selected' : '' }}>Beni</option>
                            <option value="PD" {{ old('expedido') == 'PD' ? 'selected' : '' }}>Pando</option>
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
                            value="{{ old('celular') }}"
                            placeholder="70123456"
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
                    <p class="text-sm text-slate-600">Credenciales de acceso al sistema</p>
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
                        <option value="">Seleccionar rol</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>
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

                <!-- Passwords -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="contrasena" class="block text-sm font-medium text-slate-700">
                            Contraseña *
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="contrasena"
                                name="contrasena" 
                                placeholder="Mínimo 8 caracteres"
                                class="w-full px-3 py-3 pr-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('contrasena') border-red-300 @enderror"
                                required
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
                            Confirmar Contraseña *
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="contrasena_confirmation"
                                name="contrasena_confirmation" 
                                placeholder="Repetir contraseña"
                                class="w-full px-3 py-3 pr-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                required
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

                <!-- Password Requirements -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h5 class="text-sm font-medium text-blue-900 mb-2">Requisitos de la contraseña:</h5>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mínimo 8 caracteres
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Al menos una letra mayúscula y una minúscula
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Al menos un número
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.usuarios.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors duration-200">
                    Cancelar
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Crear Usuario</span>
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
