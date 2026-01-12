<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Plan de Pagos - {{ $prestamo->codigo }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; font-weight: bold; }
        .header h2 { font-size: 16px; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; border-collapse: collapse; }
        .info table td { padding: 5px; border: 1px solid #ddd; }
        .info table .label { font-weight: bold; background-color: #f5f5f5; }
        .cuotas { margin-top: 20px; }
        .cuotas table { width: 100%; border-collapse: collapse; }
        .cuotas th { background-color: #f5f5f5; font-weight: bold; text-align: left; }
        .cuotas th, .cuotas td { padding: 8px; border: 1px solid #ddd; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CRÉDITOS ÁGILES TIENDA HOGAR</h1>
        <h2>PLAN DE PAGOS</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td class="label" width="20%">Crédito:</td>
                <td width="30%">Bs {{ number_format($prestamo->monto, 2) }}</td>
                <td class="label" width="20%">Interés:</td>
                <td width="30%">{{ $prestamo->tasa_interes_mensual }}% mensual</td>
            </tr>
            <tr>
                <td class="label">Plazo:</td>
                <td>{{ $prestamo->plazo_meses }} meses</td>
                <td class="label">F. Desembolso:</td>
                <td>{{ $prestamo->fecha_desembolso->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Nombre:</td>
                <td colspan="3">{{ $prestamo->usuario->nombre_completo }}</td>
            </tr>
            <tr>
                <td class="label">Código:</td>
                <td colspan="3">{{ $prestamo->codigo }}</td>
            </tr>
        </table>
    </div>

    <div class="cuotas">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Fecha</th>
                    <th>Cuota</th>
                    <th>Capital $</th>
                    <th>Interés $</th>
                    <th>Monto $</th>
                    <th>Monto Bs.</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestamo->planPagos as $cuota)
                <tr>
                    <td>{{ $cuota->numero_cuota }}</td>
                    <td>{{ $cuota->fecha_vencimiento->format('d/m/Y') }}</td>
                    <td>{{ $cuota->numero_cuota }}° cuota</td>
                    <td>{{ number_format($cuota->capital, 2) }}</td>
                    <td>{{ number_format($cuota->interes, 2) }}</td>
                    <td>{{ number_format($cuota->monto_cuota, 2) }}</td>
                    <td>{{ number_format($cuota->monto_cuota, 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="label">TOTAL</td>
                    <td>{{ number_format($prestamo->planPagos->sum('capital'), 2) }}</td>
                    <td>{{ number_format($prestamo->planPagos->sum('interes'), 2) }}</td>
                    <td>{{ number_format($prestamo->planPagos->sum('monto_cuota'), 2) }}</td>
                    <td>{{ number_format($prestamo->planPagos->sum('monto_cuota'), 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
        <p>Sistema de Gestión de Préstamos - Tienda Hogar</p>
    </div>
</body>
</html>