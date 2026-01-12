@extends('layouts.app')

@section('page-title', 'Plan de Pagos - ' . $prestamo->codigo)

@section('content')
    <!-- Encabezado y resumen del préstamo (mantener igual) -->
   <div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Plan de Pagos</h1>
            <p class="text-gray-600">Préstamo: {{ $prestamo->codigo }} - {{ $prestamo->usuario->nombre_completo }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.prestamos.plan-pagos.pdf', $prestamo->id) }}" 
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Exportar PDF
            </a>
            <a href="{{ route('admin.prestamos.contrato-pdf', $prestamo->id) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
            </svg>
            Contrato PDF
            </a>

            <a href="{{ route('admin.prestamos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                Volver
            </a>
        </div>
    </div>

    <!-- Resumen del Préstamo -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="font-semibold text-blue-800">Detalles del Préstamo</h3>
            <p class="mt-2"><span class="font-medium">Monto:</span> Bs {{ number_format($prestamo->monto, 2) }}</p>
            <p><span class="font-medium">Interés:</span> {{ $prestamo->tasa_interes_mensual }}% mensual</p>
            <p><span class="font-medium">Plazo:</span> {{ $prestamo->plazo_meses }} meses</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="font-semibold text-green-800">Fechas Clave</h3>
            <p class="mt-2"><span class="font-medium">Desembolso:</span> {{ $prestamo->fecha_desembolso->format('d/m/Y') }}</p>
            <p><span class="font-medium">Frecuencia:</span> {{ ucfirst($prestamo->frecuencia_pago) }}</p>
            <p><span class="font-medium">Estado:</span> 
                <span class="px-2 py-1 rounded-full text-xs font-medium 
                    {{ $prestamo->estado == 'vigente' ? 'bg-blue-100 text-blue-800' : 
                       ($prestamo->estado == 'cancelado' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($prestamo->estado) }}
                </span>
            </p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg">
            <h3 class="font-semibold text-yellow-800">Totales</h3>
            <p class="mt-2"><span class="font-medium">Cuotas:</span> {{ $prestamo->planPagos->count() }}</p>
            <p><span class="font-medium">Pagadas:</span> {{ $prestamo->planPagos->filter(fn($cuota) => $cuota->estado === 'pagado')->count() }}</p>

            <p><span class="font-medium">Pendientes:</span> {{ $prestamo->planPagos->where('estado', 'pendiente')->count() }}</p>
        </div>
    </div>

    <!-- Tabla de Plan de Pagos -->
    <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-center">
        <thead class="bg-gray-50">
            <tr>
                <th># Cuota</th>
                <th>Vencimiento</th>
                <th>Capital (Bs)</th>
                <th>Interés (Bs)</th>
                <th>Total Cuota (Bs)</th>
                <th>Saldo (Bs)</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        @php
    $totalGeneral = $prestamo->planPagos->sum(function($cuota) {
        $mora = ($cuota->mora && $cuota->mora->estado === 'activa') ? $cuota->mora->interes_mora : 0;
        return $cuota->monto_cuota + $mora;
    });
@endphp
        <tbody class="bg-white divide-y divide-gray-200">
            @php $totalGeneral = 0; @endphp
            @foreach($prestamo->planPagos as $cuota)
                @php
                    $moraExtra = $cuota->mora && $cuota->mora->estado === 'activa' ? $cuota->mora->interes_mora : 0;
                    $totalCuota = $cuota->monto_cuota + $moraExtra;
                    $totalGeneral += $totalCuota;
                    $estado = $cuota->estaPagado() ? 'pagado' : $cuota->estado;
                @endphp

                <tr class="{{ $estado == 'pagado' ? 'bg-green-50' : ($cuota->fecha_vencimiento < now() && $estado != 'pagado' ? 'bg-red-50' : '') }}">
                    <td>{{ $cuota->numero_cuota }}</td>
                    <td>{{ $cuota->fecha_vencimiento->format('d/m/Y') }}</td>
                    <td>Bs {{ number_format($cuota->capital, 2) }}</td>
                    <td>Bs {{ number_format($cuota->interes, 2) }}</td>
                   <td class="px-6 py-4 whitespace-nowrap font-medium">
                    @php
                        $moraExtra = $cuota->mora && $cuota->mora->estado === 'activa' ? $cuota->mora->interes_mora : 0;
                        $totalCuota = $cuota->monto_cuota + $moraExtra;
                    @endphp

                    {{ number_format($totalCuota, 2) }}
                    @if($moraExtra > 0)
                        <div class="text-xs text-red-600">+ Mora: Bs {{ number_format($moraExtra, 2) }}</div>
                    @endif
                </td>



                    <td>Bs {{ number_format($cuota->saldo, 2) }}</td>
                    <td>
                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                            {{ $estado == 'pagado' ? 'bg-green-200 text-green-800' : ($estado == 'mora' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                            {{ ucfirst($estado) }}
                        </span>
                    </td>
                    <td>
                        @if($estado != 'pagado')
                            <button onclick="mostrarModalPago({{ $cuota->id }})"
                                    title="Registrar Pago"
                                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 0v4m0-4h4m-4 0H8"/>
                                </svg>
                                Pagar
                            </button>
                        @else
                            <span class="text-green-700 text-sm">
    Pagado el {{ $cuota->fecha_pago ? $cuota->fecha_pago->format('d/m/Y') : 'Fecha no disponible' }}
</span>

                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

        <!-- Total General -->
        <tfoot class="bg-slate-100 font-bold">
            <tr>
                <td colspan="4" class="text-right pr-4">TOTAL GENERAL:</td>
                <td class="text-green-700 text-lg">Bs {{ number_format($totalGeneral, 2) }}</td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</div>

</div>

<!-- 🟢Modal para Registrar Pago🟢 -->
<div id="modalPago" style="background-color: rgba(0, 0, 0, 0.8);" class="fixed inset-0 hidden flex items-center justify-center z-50">


    <div class="bg-white rounded-xl p-6 w-full max-w-4xl mx-4 shadow-lg">
        <div class="flex justify-between items-center mb-6 border-b pb-2">
            <h3 class="text-2xl font-bold text-gray-800">Registrar Pago</h3>
            <button onclick="cerrarModalPago()" class="text-gray-500 hover:text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="formPago" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="plan_pago_id" id="plan_pago_id">

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Pago *</label>
                        <input type="date" name="fecha_pago" value="{{ now()->format('Y-m-d') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monto Pagado (Bs) *</label>
                        <input type="number" step="0.01" name="monto" id="monto_pagado"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Método de Pago *</label>
                        <select name="metodo_pago"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="transferencia">Transferencia Bancaria</option>
                            <option value="deposito">Depósito</option>
                            <option value="cheque">Cheque</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Comprobante</label>
                        <input type="file" name="comprobante"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Formatos aceptados: JPG, PNG, PDF (Max. 2MB)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea name="observaciones" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div id="detalle_pago" class="bg-yellow-50 p-3 rounded text-sm mt-2 text-gray-800 font-medium"></div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="cerrarModalPago()"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition-colors">
                    Cancelar
                </button>
                <button type="submit" id="submitBtn"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Registrar Pago
                </button>
            </div>
        </form>
    </div>
</div>
<script>
let isSubmitting = false;

function mostrarModalPago(planPagoId) {
    document.getElementById('modalPago').classList.remove('hidden');
    document.getElementById('plan_pago_id').value = planPagoId;

    fetch(`/admin/plan-pagos/${planPagoId}/detalle`)
        .then(res => res.json())
        .then(data => {
            let total = parseFloat(data.total);
            document.getElementById('monto_pagado').value = total.toFixed(2);
            const detalle = `
    <div class="text-left space-y-1">
        <div class="flex justify-between">
            <span>Cuota base:</span> 
            <span class="font-semibold">Bs ${parseFloat(data.monto_pendiente).toFixed(2)}</span>
        </div>

        ${data.interes_mora > 0 ? `
            <div class="flex justify-between text-red-600">
                <span>Interés Mora:</span> 
                <span class="font-semibold">+ Bs ${parseFloat(data.interes_mora).toFixed(2)}</span>
            </div>` : ''
        }

        <div class="flex justify-between border-t pt-2 text-lg text-blue-700 font-bold">
            <span>Total a Pagar:</span> 
            <span>Bs ${total.toFixed(2)}</span>
        </div>
    </div>
`;

            document.getElementById('detalle_pago').innerHTML = detalle;
        });
}

function cerrarModalPago() {
    document.getElementById('modalPago').classList.add('hidden');
}

document.getElementById('formPago').addEventListener('submit', async function (e) {
    e.preventDefault();
    if (isSubmitting) return;
    isSubmitting = true;

    const form = e.target;
    const submitBtn = document.getElementById('submitBtn');
    const originalBtnText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <span class="inline-block animate-spin rounded-full h-5 w-5 border-b-2 border-white"></span>
        Procesando...`;

    try {
        const response = await fetch("{{ route('admin.pagos.store') }}", {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Error en la respuesta del servidor');

        if (data.success) {
            cerrarModalPago();
            window.location.reload();
        } else {
            throw new Error(data.message || 'Error al registrar el pago');
        }
    } catch (error) {
        console.error('Error:', error);
        alert(error.message);
    } finally {
        isSubmitting = false;
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
});

document.getElementById('modalPago').addEventListener('click', function (e) {
    if (e.target === this) {
        cerrarModalPago();
    }
});
</script>
@endsection
