<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Reporte de Capital - Tienda Hogar</h2>

    <p><strong>Capital Actual:</strong> Bs. {{ number_format($capital->monto_actual ?? 0, 2) }}</p>
    <p><strong>Fecha de Reporte:</strong> {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Descripción</th>
                <th>Registrado por</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $mov)
            <tr>
                <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                <td style="color: {{ $mov->monto_inicial >= 0 ? 'green' : 'red' }}">
                    Bs. {{ number_format($mov->monto_inicial, 2) }}
                </td>
                <td>{{ $mov->descripcion ?? 'Sin descripción' }}</td>
                <td>{{ $mov->usuario->nombre_completo ?? 'Desconocido' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
