{{-- resources/views/admin/solicitud-credito/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Crédito - {{ $solicitud->numero_solicitud }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table th, .info-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .info-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #333;
            color: white;
            padding: 8px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .signature-table {
            width: 100%;
            margin-top: 50px;
            border-collapse: collapse;
        }
        .signature-table td {
            padding: 15px;
            text-align: center;
            vertical-align: top;
            border-top: 1px solid #000;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        .page-break {
            page-break-before: always;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
        .mt-3 {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- ENCABEZADO -->
        <div class="header">
            <h1>TIENDA HOGAR</h1>
            <h2>FORMULARIO SOLICITUD DE CRÉDITO</h2>
        </div>

        <!-- INFORMACIÓN BÁSICA -->
        <table class="info-table">
            <tr>
                <th width="25%">OFICIAL DE CRÉDITO:</th>
                <td>{{ $solicitud->oficial_credito }}</td>
                <th width="25%">NRO. DE SOLICITUD:</th>
                <td>{{ $solicitud->numero_solicitud }}</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>{{ $solicitud->fecha_solicitud->format('d/m/Y') }}</td>
                <th>PRODUCTO:</th>
                <td>
                    @if($solicitud->producto == 'mensual')
                    ☑ MENSUAL ☐ SEMANAL ☐ DIARIO
                    @elseif($solicitud->producto == 'semanal')
                    ☐ MENSUAL ☑ SEMANAL ☐ DIARIO
                    @else
                    ☐ MENSUAL ☐ SEMANAL ☑ DIARIO
                    @endif
                </td>
            </tr>
        </table>

        <!-- SECCIÓN I: DATOS GENERALES DEL SOLICITANTE -->
        <div class="section">
            <div class="section-title">I. DATOS GENERALES DEL SOLICITANTE</div>
            <table class="info-table">
                <tr>
                    <th width="30%">NOMBRE DEL SOLICITANTE</th>
                    <td>{{ $solicitud->usuario->nombre_completo }}</td>
                    <th width="15%">C.I.:</th>
                    <td>{{ $solicitud->usuario->ci }} {{ $solicitud->usuario->expedido ? 'Exp: ' . $solicitud->usuario->expedido : '' }}</td>
                </tr>
                <tr>
                    <th>FECHA DE NACIMIENTO:</th>
                    <td>{{ $solicitud->fecha_nacimiento ? $solicitud->fecha_nacimiento->format('d/m/Y') : '' }}</td>
                    <th>EDAD:</th>
                    <td>{{ $solicitud->edad }}</td>
                </tr>
                <tr>
                    <th>ESTADO CIVIL:</th>
                    <td>{{ $solicitud->estado_civil }}</td>
                    <th>TELEFONO FIJO:</th>
                    <td>{{ $solicitud->telefono_fijo }}</td>
                </tr>
                <tr>
                    <th>CELULAR:</th>
                    <td>{{ $solicitud->celular_solicitante }}</td>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <th>DOMICILIO:</th>
                    <td colspan="3">{{ $solicitud->domicilio }}</td>
                </tr>
                <tr>
                    <th>TIPO DE VIVIENDA:</th>
                    <td>{{ ucfirst($solicitud->tipo_vivienda) }}</td>
                    <th>MONTO BS.:</th>
                    <td>{{ $solicitud->monto_vivienda ? 'Bs. ' . number_format($solicitud->monto_vivienda, 2) : '' }}</td>
                </tr>
                <tr>
                    <th>TIEMPO DE PERMANENCIA:</th>
                    <td colspan="3">
                        {{ $solicitud->tiempo_permanencia_anios ?? 0 }} AÑOS 
                        {{ $solicitud->tiempo_permanencia_meses ?? 0 }} MESES
                    </td>
                </tr>
                <tr>
                    <th>CORREO ELECTRÓNICO:</th>
                    <td colspan="3">{{ $solicitud->correo_solicitante }}</td>
                </tr>
            </table>
        </div>

        @if($solicitud->conyuge_nombre_completo)
        <!-- SECCIÓN II: DATOS PERSONALES DEL CONYUGUE -->
        <div class="section">
            <div class="section-title">II. DATOS PERSONALES DEL CONYUGUE</div>
            <table class="info-table">
                <tr>
                    <th width="30%">NOMBRE COMPLETO:</th>
                    <td>{{ $solicitud->conyuge_nombre_completo }}</td>
                    <th width="15%">C.I.:</th>
                    <td>{{ $solicitud->conyuge_ci }} {{ $solicitud->conyuge_expedido ? 'Exp: ' . $solicitud->conyuge_expedido : '' }}</td>
                </tr>
                <tr>
                    <th>FECHA DE NACIMIENTO:</th>
                    <td>{{ $solicitud->conyuge_fecha_nacimiento ? $solicitud->conyuge_fecha_nacimiento->format('d/m/Y') : '' }}</td>
                    <th>EDAD:</th>
                    <td>{{ $solicitud->conyuge_edad }}</td>
                </tr>
                <tr>
                    <th>ESTADO CIVIL:</th>
                    <td>{{ $solicitud->conyuge_estado_civil }}</td>
                    <th>TELEFONO FIJO:</th>
                    <td>{{ $solicitud->conyuge_telefono_fijo }}</td>
                </tr>
                <tr>
                    <th>CELULAR:</th>
                    <td>{{ $solicitud->conyuge_celular }}</td>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <th>DOMICILIO:</th>
                    <td colspan="3">{{ $solicitud->conyuge_domicilio }}</td>
                </tr>
                <tr>
                    <th>TIPO DE VIVIENDA:</th>
                    <td>{{ ucfirst($solicitud->conyuge_tipo_vivienda) }}</td>
                    <th>MONTO BS.:</th>
                    <td>{{ $solicitud->conyuge_monto_vivienda ? 'Bs. ' . number_format($solicitud->conyuge_monto_vivienda, 2) : '' }}</td>
                </tr>
                <tr>
                    <th>TIEMPO DE PERMANENCIA:</th>
                    <td colspan="3">
                        {{ $solicitud->conyuge_tiempo_permanencia_anios ?? 0 }} AÑOS 
                        {{ $solicitud->conyuge_tiempo_permanencia_meses ?? 0 }} MESES
                    </td>
                </tr>
                <tr>
                    <th>CORREO ELECTRÓNICO:</th>
                    <td colspan="3">{{ $solicitud->conyuge_correo }}</td>
                </tr>
            </table>
        </div>
        @endif

        @if($solicitud->garante_nombre_completo)
        <!-- SECCIÓN III: DATOS DEL GARANTE -->
        <div class="section">
            <div class="section-title">III. DATOS DEL GARANTE</div>
            <table class="info-table">
                <tr>
                    <th width="30%">NOMBRE DEL GARANTE:</th>
                    <td>{{ $solicitud->garante_nombre_completo }}</td>
                    <th width="15%">C.I.:</th>
                    <td>{{ $solicitud->garante_ci }} {{ $solicitud->garante_expedido ? 'Exp: ' . $solicitud->garante_expedido : '' }}</td>
                </tr>
                <tr>
                    <th>FECHA DE NACIMIENTO:</th>
                    <td>{{ $solicitud->garante_fecha_nacimiento ? $solicitud->garante_fecha_nacimiento->format('d/m/Y') : '' }}</td>
                    <th>EDAD:</th>
                    <td>{{ $solicitud->garante_edad }}</td>
                </tr>
                <tr>
                    <th>ESTADO CIVIL:</th>
                    <td>{{ $solicitud->garante_estado_civil }}</td>
                    <th>TELEFONO FIJO:</th>
                    <td>{{ $solicitud->garante_telefono_fijo }}</td>
                </tr>
                <tr>
                    <th>CELULAR:</th>
                    <td>{{ $solicitud->garante_celular }}</td>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <th>DOMICILIO:</th>
                    <td colspan="3">{{ $solicitud->garante_domicilio }}</td>
                </tr>
                <tr>
                    <th>TIPO DE VIVIENDA:</th>
                    <td>{{ ucfirst($solicitud->garante_tipo_vivienda) }}</td>
                    <th>MONTO BS.:</th>
                    <td>{{ $solicitud->garante_monto_vivienda ? 'Bs. ' . number_format($solicitud->garante_monto_vivienda, 2) : '' }}</td>
                </tr>
                <tr>
                    <th>TIEMPO DE PERMANENCIA:</th>
                    <td colspan="3">
                        {{ $solicitud->garante_tiempo_permanencia_anios ?? 0 }} AÑOS 
                        {{ $solicitud->garante_tiempo_permanencia_meses ?? 0 }} MESES
                    </td>
                </tr>
                <tr>
                    <th>CORREO ELECTRÓNICO:</th>
                    <td colspan="3">{{ $solicitud->garante_correo }}</td>
                </tr>
            </table>
        </div>
        @endif

        <div class="page-break"></div>

        <!-- DATOS LABORALES -->
        @if($solicitud->datos_laborales)
        <div class="section">
            <div class="section-title">IV. DATOS LABORALES DEL SOLICITANTE</div>
            @php $lab = $solicitud->datos_laborales; @endphp
            
            @if($lab['tipo'] == 'dependiente')
            <table class="info-table">
                <tr>
                    <th colspan="2" class="text-center bg-light">DEPENDIENTE</th>
                </tr>
                <tr>
                    <th width="30%">PROFESIÓN U OCUPACIÓN:</th>
                    <td>{{ $lab['profesion_ocupacion'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>EMPRESA EN LA QUE TRABAJA:</th>
                    <td>{{ $lab['empresa_trabaja'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>CARGO QUE DESEMPEÑA:</th>
                    <td>{{ $lab['cargo_desempena'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>FECHA DE INGRESO:</th>
                    <td>{{ isset($lab['fecha_ingreso']) ? \Carbon\Carbon::parse($lab['fecha_ingreso'])->format('d/m/Y') : '' }}</td>
                </tr>
                <tr>
                    <th>FECHA DE PAGO DE SUELDO:</th>
                    <td>{{ $lab['fecha_pago_sueldo'] ? 'Día ' . $lab['fecha_pago_sueldo'] : '' }}</td>
                </tr>
                <tr>
                    <th>SALARIO ACTUAL:</th>
                    <td>{{ isset($lab['salario_actual']) ? 'Bs. ' . number_format($lab['salario_actual'], 2) : '' }}</td>
                </tr>
            </table>
            @elseif($lab['tipo'] == 'independiente')
            <table class="info-table">
                <tr>
                    <th colspan="2" class="text-center bg-light">INDEPENDIENTE</th>
                </tr>
                <tr>
                    <th width="30%">DESCRIPCIÓN DEL NEGOCIO:</th>
                    <td>{{ $lab['descripcion_negocio'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>DIRECCIÓN:</th>
                    <td>{{ $lab['direccion_negocio'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>ANTIGÜEDAD:</th>
                    <td>{{ $lab['antiguedad_negocio'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>TELEFONO:</th>
                    <td>{{ $lab['telefono_negocio'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>INGRESO PROMEDIO POR MES:</th>
                    <td>{{ isset($lab['ingreso_promedio_mes']) ? 'Bs. ' . number_format($lab['ingreso_promedio_mes'], 2) : '' }}</td>
                </tr>
            </table>
            @endif

            @if(isset($lab['ingresos_gastos']))
            <div class="mt-3">
                <table class="info-table">
                    <tr>
                        <th colspan="2" class="text-center bg-light">FLUJO DE EFECTIVO MENSUAL DEL SOLICITANTE</th>
                        <th colspan="2" class="text-center bg-light">GASTOS</th>
                    </tr>
                    <tr>
                        <th width="25%">VENTAS:</th>
                        <td width="25%">Bs. {{ number_format($lab['ingresos_gastos']['ventas'] ?? 0, 2) }}</td>
                        <th width="25%">CANASTA FAMILIAR:</th>
                        <td width="25%">Bs. {{ number_format($lab['ingresos_gastos']['canasta_familiar'] ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <th>OTROS INGRESOS:</th>
                        <td>Bs. {{ number_format($lab['ingresos_gastos']['otros_ingresos'] ?? 0, 2) }}</td>
                        <th>VATICOS:</th>
                        <td>Bs. {{ number_format($lab['ingresos_gastos']['vaticos'] ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <th>TOTAL INGRESOS:</th>
                        <td><strong>Bs. {{ number_format($lab['ingresos_gastos']['total_ingresos'] ?? 0, 2) }}</strong></td>
                        <th>SERVICIOS BÁSICOS:</th>
                        <td>Bs. {{ number_format($lab['ingresos_gastos']['servicios_basicos'] ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>ALQUILER:</th>
                        <td>Bs. {{ number_format($lab['ingresos_gastos']['alquiler'] ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>OTROS:</th>
                        <td>Bs. {{ number_format($lab['ingresos_gastos']['otros_gastos'] ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>TOTAL GASTOS:</th>
                        <td><strong>Bs. {{ number_format($lab['ingresos_gastos']['total_gastos'] ?? 0, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
            @endif
        </div>

        <!-- DEUDAS -->
        @if($solicitud->deudas->count() > 0)
        <div class="section">
            <div class="section-title">V. DEUDAS EN OTRAS INSTITUCIONES</div>
            <table class="info-table">
                <thead>
                    <tr>
                        <th width="50%">BANCO/INSTITUCIÓN</th>
                        <th width="50%">MONTO</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalDeudas = 0; @endphp
                    @foreach($solicitud->deudas as $deuda)
                    <tr>
                        <td>{{ $deuda->institucion }}</td>
                        <td>Bs. {{ number_format($deuda->monto, 2) }}</td>
                    </tr>
                    @php $totalDeudas += $deuda->monto; @endphp
                    @endforeach
                    <tr>
                        <td class="text-right"><strong>TOTAL DEUDAS:</strong></td>
                        <td><strong>Bs. {{ number_format($totalDeudas, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
        @endif

        <!-- SOLICITUD DE CRÉDITO -->
        <div class="section">
            <div class="section-title">VI. SOLICITUD DE CRÉDITO</div>
            <table class="info-table">
                <tr>
                    <th width="30%">MONTO:</th>
                    <td>Bs. {{ number_format($solicitud->monto_solicitado, 2) }}</td>
                    <th width="20%">MONEDA:</th>
                    <td>{{ $solicitud->moneda }}</td>
                </tr>
                <tr>
                    <th>MONTO LITERAL:</th>
                    <td colspan="3">{{ $solicitud->monto_literal ?? '' }}</td>
                </tr>
                <tr>
                    <th>OBJETIVO DEL CRÉDITO:</th>
                    <td colspan="3">{{ $solicitud->objetivo_credito ?? '' }}</td>
                </tr>
            </table>
        </div>

        <!-- TÉRMINOS Y CONDICIONES -->
        <div class="section">
            <div class="section-title">VII. TÉRMINOS Y CONDICIONES</div>
            <p>
                Las personas que firmamos la presente, autorizamos a TIENDA HOGAR, que pueda solicitar información 
                sobre mis antecedentes crediticios y otras cuentas por pagar de carácter económico, financiero y 
                comercial registrados en el Buro de Información, mientras dure la relación contractual con la 
                citada empresa. Asimismo autorizo a incorporar los datos crediticios y de otras cuentas por pagar 
                de carácter económico, financiero y comercial derivados de la relación con INFOCENTER S.A. en la 
                base de datos de propiedad de los buros de información que cuenten con la licencia de funcionamiento 
                del organismo de supervisión.
            </p>
            
            <table class="signature-table">
                <tr>
                    <td width="33%">
                        <div style="height: 60px; border-bottom: 1px solid #000; margin-bottom: 10px;"></div>
                        <strong>FIRMA DEL CONYUGUE</strong><br>
                        NOMBRE: {{ $solicitud->conyuge_nombre_completo ?? '' }}<br>
                        C.I.: {{ $solicitud->conyuge_ci ?? '' }}
                    </td>
                    <td width="33%">
                        <div style="height: 60px; border-bottom: 1px solid #000; margin-bottom: 10px;"></div>
                        <strong>FIRMA DEL SOLICITANTE</strong><br>
                        NOMBRE: {{ $solicitud->usuario->nombre_completo }}<br>
                        C.I.: {{ $solicitud->usuario->ci }}
                    </td>
                    <td width="33%">
                        <div style="height: 60px; border-bottom: 1px solid #000; margin-bottom: 10px;"></div>
                        <strong>FIRMA DEL GARANTE</strong><br>
                        NOMBRE: {{ $solicitud->garante_nombre_completo ?? '' }}<br>
                        C.I.: {{ $solicitud->garante_ci ?? '' }}
                    </td>
                </tr>
            </table>

            <p class="mt-3">
                LOS DATOS PROPORCIONADOS SON CIERTOS Y POR LO TANTO DEBEN SER TRATADOS CONFIDENCIALMENTE.
            </p>

            <table class="info-table mt-3">
                <tr>
                    <th width="50%">NOMBRE DE QUIEN PROPORCIONA LA INFORMACIÓN:</th>
                    <td width="50%">{{ $solicitud->usuario->nombre_completo }}</td>
                </tr>
                <tr>
                    <th>FECHA DE APROBACIÓN DE CRÉDITO:</th>
                    <td>
                        @if($solicitud->fecha_aprobacion)
                            {{ $solicitud->fecha_aprobacion->format('d/m/Y') }}
                        @else
                            __________________________
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>AUTORIZADO POR:</th>
                    <td>{{ $solicitud->autorizado_por ?? '__________________________' }}</td>
                </tr>
                <tr>
                    <th>FECHA DE FIRMA DE CONTRATO:</th>
                    <td>
                        @if($solicitud->fecha_firma_contrato)
                            {{ $solicitud->fecha_firma_contrato->format('d/m/Y') }}
                        @else
                            __________________________
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>Documento generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>TIENDA HOGAR - La felicidad está aquí</p>
        </div>
    </div>
</body>
</html>