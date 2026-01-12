@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Gestión de Capital</h2>
        
<div class="flex justify-end mb-4">
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.capital.exportar') }}" 
           class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Exportar</span>
        </a>
    </div>
</div>



        <!-- Tarjeta de Resumen -->
        <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-blue-600">Capital Disponible</p>
                    <p class="text-3xl font-bold text-blue-800">
                        Bs. {{ number_format($capital->monto_actual ?? 0, 2) }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Última actualización</p>
                    <p class="text-sm font-medium">
                        @if ($capital)
    {{ $capital->created_at->format('d/m/Y H:i') }}
@else
    N/A
@endif

                    </p>
                </div>
            </div>
        </div>

        <!-- Formularios -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Añadir Capital -->
            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                <h3 class="font-medium text-green-700 mb-3">Añadir Capital</h3>
                <form action="{{ route('admin.capital.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Monto</label>
                        <input type="number" step="0.01" name="monto" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea name="descripcion" rows="2"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>
                    <button type="submit" 
                            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Registrar Depósito
                    </button>
                </form>
            </div>

            <!-- Retirar Capital -->
            <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                <h3 class="font-medium text-red-700 mb-3">Retirar Capital</h3>
                <form action="{{ route('admin.capital.retirar') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Monto</label>
                        <input type="number" step="0.01" name="monto" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea name="descripcion" rows="2"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>
                    <button type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        Registrar Retiro
                    </button>
                </form>
            </div>
        </div>

        <!-- Historial -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Historial de Movimientos</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registrado por</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($movimientos as $movimiento)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $movimiento->created_at->format('d/m/Y H:i') }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium 
            {{ $movimiento->monto_inicial >= 0 ? 'text-green-600' : 'text-red-600' }}">
            Bs. {{ number_format($movimiento->monto_inicial, 2) }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-500">
            {{ $movimiento->descripcion ?? 'Sin descripción' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
         {{ $movimiento->usuario->nombre_completo ?? 'Desconocido' }}
        </td>

    </tr>
@empty
    <tr>
        <td colspan="3" class="text-center py-4 text-gray-500">No hay registros de capital</td>
    </tr>
@endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection