@extends('layouts.app')

@section('page-title', 'Editar Préstamo')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Editar Préstamo: {{ $prestamo->codigo }}</h1>
        <a href="{{ route('admin.prestamos.index') }}" class="text-blue-600 hover:underline">Volver a la lista</a>
    </div>

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong class="font-bold">¡Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif



    <form action="{{ route('admin.prestamos.update', $prestamo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Selección de Usuario -->
            <div>
                <label for="usuario_id" class="block text-sm font-medium text-gray-700 mb-1">Cliente *</label>
                <select id="usuario_id" name="usuario_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ $prestamo->usuario_id == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->nombre_completo }} (CI: {{ $usuario->ci }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Monto del Préstamo -->
            <div>
                <label for="monto" class="block text-sm font-medium text-gray-700 mb-1">Monto (Bs) *</label>
                <input type="number" step="0.01" id="monto" name="monto" value="{{ old('monto', $prestamo->monto) }}"
                    required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Tasa de Interés -->
            <div>
                <label for="tasa_interes_mensual" class="block text-sm font-medium text-gray-700 mb-1">Tasa de Interés Mensual (%) *</label>
                <input type="number" step="0.01" id="tasa_interes_mensual" name="tasa_interes_mensual" 
                    value="{{ old('tasa_interes_mensual', $prestamo->tasa_interes_mensual) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Plazo en Meses -->
            <div>
                <label for="plazo_meses" class="block text-sm font-medium text-gray-700 mb-1">Plazo (Meses) *</label>
                <select id="plazo_meses" name="plazo_meses" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @for($i = 1; $i <= 3; $i++)
                        <option value="{{ $i }}" {{ $prestamo->plazo_meses == $i ? 'selected' : '' }}>{{ $i }} mes(es)</option>
                    @endfor
                </select>
            </div>

            <!-- Frecuencia de Pago -->
            <div>
                <label for="frecuencia_pago" class="block text-sm font-medium text-gray-700 mb-1">Frecuencia de Pago *</label>
                <select id="frecuencia_pago" name="frecuencia_pago" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="diario" {{ $prestamo->frecuencia_pago == 'diario' ? 'selected' : '' }}>Diario</option>
                    <option value="semanal" {{ $prestamo->frecuencia_pago == 'semanal' ? 'selected' : '' }}>Semanal</option>
                    <option value="quincenal" {{ $prestamo->frecuencia_pago == 'quincenal' ? 'selected' : '' }}>Quincenal</option>
                    <option value="mensual" {{ $prestamo->frecuencia_pago == 'mensual' ? 'selected' : '' }}>Mensual</option>
                </select>
            </div>

            <!-- Fecha de Desembolso -->
            <div>
                <label for="fecha_desembolso" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Desembolso *</label>
                <input type="date" id="fecha_desembolso" name="fecha_desembolso" 
                    value="{{ old('fecha_desembolso', $prestamo->fecha_desembolso->format('Y-m-d')) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Referencia Celular -->
            <div>
                <label for="referencia_celular" class="block text-sm font-medium text-gray-700 mb-1">Referencia Celular</label>
                <input type="text" id="referencia_celular" name="referencia_celular" 
                    value="{{ old('referencia_celular', $prestamo->referencia_celular) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Estado -->
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                <select id="estado" name="estado" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="vigente" {{ $prestamo->estado == 'vigente' ? 'selected' : '' }}>Vigente</option>
                    <option value="cancelado" {{ $prestamo->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    <option value="mora" {{ $prestamo->estado == 'mora' ? 'selected' : '' }}>En Mora</option>
                </select>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition-colors duration-200">
                Actualizar Préstamo
            </button>
        </div>
    </form>
</div>
@endsection