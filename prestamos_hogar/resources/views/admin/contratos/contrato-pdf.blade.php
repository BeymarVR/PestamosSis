<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contrato de Préstamo</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; line-height: 1.6; }
        h1, h2, h3 { text-align: center; }
        .firma { margin-top: 60px; text-align: center; }
        table { width: 100%; margin-top: 50px; }
    </style>
</head>
<body>

    <h1>CONTRATO PRIVADO</h1>
    <p>Conste por el presente documento privado de préstamo de dinero, el cual a solo reconocimiento de firmas y rubricas podrá elevarse a instrumento público, el mismo que se suscribe al tenor de las siguientes cláusulas:</p>

    <p><strong>PRIMERA: (DE LAS PARTES).- Intervienen en la celebración del presente contrato en su propio nombre y derecho:</strong></p>
    <p><strong>1.1 PRESTAMISTA:</strong> {{ $prestamista->nombre_completo }} con C.I. {{ $prestamista->ci }} {{ $prestamista->expedido }}, con celular {{ $prestamista->celular }}.</p>
    <p><strong>1.2 PRESTATARIO:</strong> {{ $prestamo->usuario->nombre_completo }} con C.I. {{ $prestamo->usuario->ci }} {{ $prestamo->usuario->expedido }}, con celular {{ $prestamo->usuario->celular }}.</p>
    <p>1.3.	Ambas partes reconocen la capacidad legal necesaria para formalizar el presente CONTRATO CIVIL DE PRÉSTAMO CON INTERESES en el concepto en el que intervienen en el mismo, y de conformidad con las cláusulas detalladas.</p>

    <p><strong>SEGUNDA: (OBJETO DEL CONTRATO)</strong></p>
    <p>Por el presente contrato, el PRESTAMISTA otorga un préstamo de dinero con recursos propios en favor del PRESTATARIO por la suma de <strong>Bs {{ number_format($prestamo->monto, 2) }}</strong> (Bolivianos) . Monto de dinero que el PRESTATARIO declara en forma expresa haber recibido en mano propia y en efectivo de parte del PRESTAMISTA. Sirviendo la firma del presente documento como formal  recibo de la citada cantidad.</p>

    <p><strong>TERCERA: (TASA DE INTERÉS)</strong></p>
    <p>El PRESTATARIO se obliga frente al PRESTAMISTA a la devolución del capital prestado con un interés mensual, pactado por las partes, del CINCO por ciento( <strong>{{ $prestamo->tasa_interes_mensual }}%</strong>.) siendo pagadero dicho interés por periodos vencidos DIARIAMENTE, los mismos que serán cobrados por el PRESTAMISTA. Asimismo, la falta de pago del importe del capital o de los intereses pactados a su vencimiento, devengará un interés de mora del TRES por ciento (3 %) mensual; sin que sea necesario para ello el requerimiento previo por parte del PRESTAMISTA.</p>  

    <p><strong>CUARTA: (PLAZO)</strong></p>
    <p>El plazo por el cual el PRESTAMISTA concede el préstamo es de <strong>{{ $prestamo->plazo_meses }} meses</strong> computables a partir de la firma del presento contrato, quedando el PRESTATARIO, obligado a pagar su obligación mediante el PLAN DE PAGOS aprobado entre ambos o antes del vencimiento del plazo. El Plan de Pagos de referencia se constituye en parte indisoluble del presento contrato.
Asimismo se prevé el derecho del PRESTATARIO a poder realizar pagos anticipados, estableciéndose que estos recursos se imputaran a: intereses devengados y finalmente al capital del préstamo; pudiendo asimismo  liquidar su deuda antes del periodo establecido.
</p>

    <p><strong>QUINTA: (FRECUENCIA DE PAGO)</strong></p>
    <p>El prestatario realizará pagos de forma <strong>{{ ucfirst($prestamo->frecuencia_pago) }}</strong>.Todos los pagos de capital e intereses, deberán hacerse en efectivo o atreves de depósito bancario, en los montos indicados, en la misma moneda en que se efectuó el préstamo. A tal efecto el PRESTAMISTA elaborará las liquidaciones si correspondieren, que en su caso serán actualizadas cuantas veces sea necesario y tendrán por si solas suficiente fuerza legal, liquidez y exigibilidad, harán fe en juicio y surtirán efectos legales.</p>

    <p><strong>SEXTA: CLÁUSULA PENAL (MORA Y EJECUCION).</strong></p>
    <p>Queda convenido que la falta de pago total o parcial del préstamo, intereses y/o sus accesorios o la simple demora en el pago de cualesquier cuota de capital, intereses, en las fechas correspondientes pactadas en el Plan de Pago, constituirá al PRESTATARIO en DEUDOR EN MORA, por el monto total de la obligación, la cual se considerará de plazo vencido, liquida y exigible, sin necesidad de intimación o requerimiento judicial o extrajudicial previo, lo que dará derecho al PRESTAMISTA para exigir al PRESTATARIO el pago íntegro del préstamo y todos sus saldos de capital, intereses convencionales, intereses penales, accesorios, etc. Aunque el plazo final no se encuentre vencido, pudiendo el PRESTAMISTA interponer en cualquier momento la correspondiente acción judicial para su cobranza, quedando el PRESTATARIO obligado al pago de todos los gastos y demás costos ocasionados al PRESTAMISTA, incluyendo los relacionados y emergentes de la cobranza judicial y/o extrajudicial, honorarios de abogado, derechos, costas y otros, sin excepción, los cuales serán pagados por el PRESTATARIO, aunque no se formalice la acción judicial, formalizada esta, aunque no se haya dictado sentencia o cualquiera que sea el estado procesal a que llegue el juicio.</p>

    <p><strong>SEPTIMA: (INCUMPLIMIENTO)</strong></p>
    <p>El incumplimiento de lo pactado facultará al PRESTAMISTA a reportar ante la CENTRAL DE RIESGOS este incumplimiento y de acuerdo al Art. 569 del Código Civil el presente contrato podrá resolverse en forma anticipada a la fecha de su vencimiento si el PRESTATARIO incurriere en cualquiera de las siguientes causales:
a)	 Incumplimiento de cualquiera de las cláusulas del presente contrato.
b)	 Falta del pago oportuno de cualquier cuota o amortización de préstamo, ya sea pago a capital o intereses u otras aplicables de acuerdo al Plan de Pagos aprobado.
c)	Si el PRESTAMISTA establece que es falsa o incompleta alguna de las declaraciones o garantías hechas por el PRESTATARIO.
d)	Si el PRESTATARIO en cualquier momento y por cualquier circunstancia desconocieren la validez legal y ejecutabilidad de las obligaciones contraídas bajo el presente contrato o cualquier parte del mismo o de cualquier documento otorgado de acuerdo al presente.
</p>

    <p><strong>OCTAVA: (GARANTIAS)</strong></p>
    <p>El PRESTATARIO garantiza al PRESTAMISTA el fiel y estricto cumplimiento del presente contrato y todas las obligaciones señaladas, inherentes, derivadas y emergentes del mismo, con la generalidad de sus bienes muebles, inmuebles y semovientes, presentes o futuros, sin exclusión o limitación de ninguna naturaleza, que responderán al pago total de la obligación, tanto capital como intereses convencionales y demás cargas aplicables a la presente obligación.</p>

    <p><strong>NOVENA: (DE LA CESION DE CRÉDITOS)</strong></p>
    <p>Las partes acuerdan que el PRESTAMISTA podrá transferir o ceder a terceros el presente préstamo o cualquier derecho que le corresponda de acuerdo al presente contrato, siempre y cuando la cesión o transferencia mantenga las mismas condiciones para el PRESTATARIO. Queda establecido que cualquier transferencia o cesión realizada por el PRESTAMISTA producirá efectos legales sin necesidad de aviso o notificación al PRESTATARIO, bastando la aceptación a lo dispuesto en la presente cláusula que para todos los fines y efectos legales constituye notificación y aceptación suficiente.</p>

<p><strong>DÉCIMA: (AUTORIZACIÓN)</strong></p>
    <p>Mediante la presente, como PRESTATARIO doy mi autorización al PRESTAMISTA a solicitar información sobre mis antecedentes crediticios y otras cuentas por pagar registrados en el Buró de Informaciones mientras dure mi relación contractual. Asimismo autorizo en caso de incumplimiento, a incorporar los datos crediticios y otras cuentas por pagar de carácter económico y financiero ante la base de datos de INFOCENTER.</p>

    <p><strong>DÉCIMA PRIMERA: (RENUNCIA)</strong></p>
    <p>El PRESTATARIO renuncia a los trámites del proceso ejecutivo y acepta la ejecución coactiva de la obligación a pagar la suma líquida y exigible a plazo vencido de este contrato.</p>

    <p><strong>DÉCIMA SEGUNDA: (DOMICILIO ESPECIAL Y OBLIGACIÓN DE INFORMAR)</strong></p>
    <p>Para los fines del presente contrato, el PRESTAMISTA y el PRESTATARIO constituyen como domicilio especial el señalado en la cláusula correspondiente, no pudiendo cambiar sus domicilios sin previa notificación mediante carta notariada a la otra parte integrante del presente contrato. Asimismo se deberá informar al PRESTAMISTA dentro de las 24 horas cualquier hecho o acontecimiento que de alguna manera pudiera afectar el cumplimiento del presente contrato.</p>

    <p><strong>DÉCIMA TERCERA: (LEGISLACIÓN APLICABLE)</strong></p>
    <p>La interpretación de las cláusulas del presente contrato se realizará de conformidad con la legislación boliviana. En consecuencia, el presente contrato se rige supletoriamente, y en lo no pactado expresamente en él, por lo dispuesto en el Código Civil.</p>

    <p><strong>DÉCIMA CUARTA: (ACEPTACIÓN)</strong></p>
    <p>Firmado en la ciudad de La Paz, a los {{ now()->format('d') }} días del mes de {{ now()->translatedFormat('F') }} de {{ now()->year }}.</p>

    <table>
        <tr>
            <td class="firma">
                ___________________________<br>
                {{ $prestamista->nombre_completo }}<br>
                PRESTAMISTA
            </td>
            <td class="firma">
                ___________________________<br>
                {{ $prestamo->usuario->nombre_completo }}<br>
                PRESTATARIO
            </td>
        </tr>
    </table>

</body>
</html>