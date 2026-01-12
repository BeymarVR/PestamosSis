<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Plan de Pagos - PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Plan de Pagos - Préstamo #{{ $prestamo->id }}</h2>
    <p>Monto: Bs {{ number_format($prestamo->monto, 2) }}</p>
    <p>Fecha de inicio: {{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</p>
    <p>Fecha estimada fin: {{ \Carbon\Carbon::parse($prestamo->fecha_fin_estimada)->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha Vencimiento</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Fecha de Pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prestamo->planPagos as $cuota)
                <tr>
                    <td>{{ $cuota->numero }}</td>
                    <td>{{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}</td>
                    <td>Bs {{ number_format($cuota->monto, 2) }}</td>
                    <td>{{ ucfirst($cuota->estado) }}</td>
                    <td>{{ optional($cuota->pagos->first())->fecha_pago ? \Carbon\Carbon::parse($cuota->pagos->first()->fecha_pago)->format('d/m/Y') : '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
