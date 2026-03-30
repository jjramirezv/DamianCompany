<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Venta Electrónico</title>
    <style>
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        table { width: 100%; border-collapse: collapse; }
        p { margin: 4px 0; line-height: 1.4; }

        .sunat-box {
            border: 2px solid #000;
            text-align: center;
            padding: 15px;
            background-color: #f8f8f8;
        }
        .sunat-box h2 { font-size: 17px; margin: 5px 0; }
        .sunat-box h3 { font-size: 15px; margin: 5px 0; text-transform: uppercase; }
        
        .client-section {
            background-color: #fcfcfc;
            border: 1px solid #eee;
            margin: 20px 0;
            padding: 10px;
        }
        .client-table td { padding: 5px; vertical-align: top; }
        .label { color: #555; font-weight: bold; font-size: 11px; text-transform: uppercase; }
        .value { font-weight: bold; font-size: 13px; }

        .items-table { margin-bottom: 20px; border: 1px solid #eee; }
        .items-table th { background-color: #f8f8f8; color: #000; padding: 10px; text-align: left; font-size: 12px; border: 1px solid #eee; }
        .items-table td { padding: 10px; border: 1px solid #eee; }
        .right { text-align: right; }
        .center { text-align: center; }

        .totals-table td { padding: 7px 10px; }
        .total-label { font-weight: bold; text-transform: uppercase; font-size: 12px; }
        .total-value { font-size: 14px; font-weight: bold; }
        
        .grand-total { background-color: #f8f8f8; border: 1px solid #000; }
        .grand-total td { font-weight: bold; font-size: 16px; color: #000; }

        .footer { text-align: center; margin-top: 50px; font-size: 11px; color: #777; border-top: 1px dashed #ccc; padding-top: 20px; }
    </style>
</head>
<body>

    <table style="margin-bottom: 20px;">
        <tr>
            <td width="60%" style="vertical-align: top;">
                <table width="100%">
                    <tr>
                        <td width="100px" style="vertical-align: middle;">
                            <img src="{{ public_path('img/logo.png') }}" style="width: 90px; height: auto;">
                        </td>
                        <td style="vertical-align: middle;">
                            <h1 style="margin:0; font-size: 26px; font-weight: bold;">DAMIAN</h1>
                            <h1 style="margin:0; font-size: 26px; font-weight: bold;">COMPANY</h1>
                            <h3>RUC: 20609115697</h3>
                        </td>
                        <td>
                            <p>Av. Argentina S/N, Chupaca - Junín</p>
                            <p>Tel: +51 964 493 400</p>
                            <p>damiancompany@damiancompany.com.pe</p>

                        </td>
                    </tr>
                </table>
            </td>
        
        </tr>
    </table>

    <div class="client-section">
        <table class="client-table" width="100%">
            <tr>
                <td width="15%"><span class="label">Adquiriente</span></td>
                <td width="55%"><span class="value">{{ $venta->cliente_nombre ?? 'Público General' }}</span></td>
                <td width="15%"><span class="label">Emisión</span></td>
                <td width="15%"><span class="value">{{ $venta->created_at->format('d/m/Y') }}</span></td>
            </tr>
            <tr>
                <td><span class="label">{{ $venta->tipo_documento == 'RUC' ? 'RUC' : ($venta->tipo_documento == 'DNI' ? 'DNI' : 'Doc') }}</span></td>
                <td><span class="value">{{ $venta->numero_documento ?? '---' }}</span></td>
                <td><span class="label">Hora</span></td>
                <td><span class="value">{{ $venta->created_at->format('H:i') }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Pago</span></td>
                <td><span class="value">{{ $venta->metodo_pago }}</span></td>
                <td><span class="label">Vendedor</span></td>
                <td><span class="value">{{ $venta->user->name ?? 'Admin' }}</span></td>
            </tr>
        </table>
    </div>

    <table class="items-table" width="100%">
        <thead>
            <tr>
                <th width="10%" class="center">Cant.</th>
                <th width="50%">Descripción del Producto/Servicio</th>
                <th width="20%" class="center">Precio Unit.</th>
                <th width="20%" class="center">Importe</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
            <tr>
                <td class="center">{{ $detalle->cantidad }}</td>
                <td class="value">{{ $detalle->producto->nombre }}</td>
                <td>S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                <td>S/ {{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table width="100%">
        <tr>
            <td width="60%"></td>
            <td width="40%" style="vertical-align: top;">
                <table class="totals-table" width="100%">
                    <tr>
                        <td class="total-label">Sub Total:</td>
                        <td class="total-value right">S/ {{ number_format($venta->total / 1.18, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="total-label">IGV (18%):</td>
                        <td class="total-value right">S/ {{ number_format($venta->total - ($venta->total / 1.18), 2) }}</td>
                    </tr>
                    <tr class="grand-total">
                        <td style="padding: 10px; text-transform: uppercase font-size:15px;">Total a Pagar:</td>
                        <td class="right" style="padding: 10px; font-size: 15px;">S/ {{ number_format($venta->total, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer">
        <p style="font-weight: bold; color: #000;">DAMIAN COMPANY</p>
        <p>Expertos en Soluciones Tecnológicas.</p>
        <p>¡Muchas gracias por su preferencia!</p>
    </div>

</body>
</html>