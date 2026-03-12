<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Solicitudes de Crédito</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; color: #1e3a8a; }
        .subtitle { font-size: 12px; color: #666; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f3f4f6; color: #374151; font-weight: bold; padding: 8px; border: 1px solid #e5e7eb; text-align: left; }
        td { padding: 8px; border: 1px solid #e5e7eb; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge { padding: 2px 6px; border-radius: 10px; font-size: 8px; font-weight: bold; text-transform: uppercase; }
        .badge-pendiente { background: #fef3c7; color: #92400e; }
        .badge-aprobada { background: #d1fae5; color: #065f46; }
        .badge-rechazada { background: #fee2e2; color: #991b1b; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">REPORTE DE SOLICITUDES DE CRÉDITO</div>
        <div class="subtitle">Tienda Hogar - PrestamosH</div>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>N° Solicitud</th>
                <th>Cliente</th>
                <th>CI</th>
                <th>Producto</th>
                <th class="text-right">Monto Solicitado</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($solicitudes as $solicitud)
            <tr>
                <td>{{ $solicitud->numero_solicitud }}</td>
                <td>{{ $solicitud->usuario->nombre_completo ?? 'N/A' }}</td>
                <td>{{ $solicitud->usuario->ci ?? 'N/A' }}</td>
                <td>{{ ucfirst($solicitud->producto) }}</td>
                <td class="text-right">Bs. {{ number_format($solicitud->monto_solicitado, 2) }}</td>
                <td class="text-center">{{ $solicitud->fecha_solicitud->format('d/m/Y') }}</td>
                <td class="text-center">
                    <span class="badge badge-{{ $solicitud->estado }}">
                        {{ $solicitud->estado }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Este documento es un reporte oficial generado por el sistema de gestión de créditos.
    </div>
</body>
</html>
