<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Préstamos</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        h2 { text-align: center; margin-bottom: 10px; }
        .footer { text-align: center; margin-top: 20px; font-size: 11px; }
    </style>
</head>
<body>
    <h2>REPORTE GENERAL DE PRÉSTAMOS</h2>
    <p><strong>Generado el:</strong> {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Cliente</th>
                <th>CI</th>
                <th>Monto (Bs)</th>
                <th>Interés %</th>
                <th>Plazo</th>
                <th>Frecuencia</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestamos as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->codigo }}</td>
                    <td>{{ $p->usuario->nombre_completo ?? '---' }}</td>
                    <td>{{ $p->usuario->ci ?? '---' }}</td>
                    <td>{{ number_format($p->monto, 2) }}</td>
                    <td>{{ $p->interes }}%</td>
                    <td>{{ $p->plazo }} meses</td>
                    <td>{{ ucfirst($p->frecuencia_pago) }}</td>
                    <td>{{ strtoupper($p->estado) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sistema de Gestión de Préstamos - Tienda Hogar
    </div>
</body>
</html>
