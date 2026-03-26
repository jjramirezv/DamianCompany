<?php

namespace App\Exports;

use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\MovimientoCaja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VentasSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    public function title(): string
    {
        return 'Ventas y Caja';
    }

    public function collection()
    {
        return VentaDetalle::with(['venta.cliente', 'producto.categoria', 'producto.marca'])
            ->whereHas('venta', fn($query) => $query->whereDate('created_at', now()))
            ->get();
    }

    public function headings(): array
    {
        return [
            ['DAMIAN COMPANY - VENTAS DEL DÍA'],
            ['Fecha:', now()->format('d/m/Y')],
            [''], 
            ['N° Venta', 'Cliente', 'Método Pago', 'SKU', 'Producto', 'Categoría', 'Marca', 'Cant.', 'P. Unitario', 'Subtotal']
        ];
    }

    public function map($detalle): array
    {
        $venta = $detalle->venta;
        $producto = $detalle->producto;

        return [
            '#' . str_pad($venta->id, 4, '0', STR_PAD_LEFT),
            $venta->cliente_nombre ?? ($venta->cliente?->nombre ?? 'Público General'),
            $venta->metodo_pago,
            $producto->codigo ?? 'Sin SKU',
            $producto->nombre,
            $producto->categoria?->nombre ?? '-',
            $producto->marca?->nombre ?? '-',
            $detalle->cantidad,
            'S/ ' . number_format($detalle->precio_unitario, 2),
            'S/ ' . number_format($detalle->subtotal, 2)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A4:J4')->getFont()->setBold(true);
        
        $lastRow = $sheet->getHighestRow();
        $summaryRow = $lastRow + 2;

        $totalDinero = Venta::whereDate('created_at', now())->sum('total');
        $totalUnidades = VentaDetalle::whereHas('venta', fn($q) => $q->whereDate('created_at', now()))->sum('cantidad');
        $totalEgresos = MovimientoCaja::whereDate('created_at', now())->where('tipo', 'egreso')->sum('monto');

        $sheet->setCellValue("I{$summaryRow}", "VENTA TOTAL:");
        $sheet->setCellValue("J{$summaryRow}", "S/ " . number_format($totalDinero, 2));
        
        $sheet->setCellValue("I" . ($summaryRow + 1), "UNIDADES VENDIDAS:");
        $sheet->setCellValue("J" . ($summaryRow + 1), $totalUnidades);

        $sheet->setCellValue("I" . ($summaryRow + 2), "TOTAL EGRESOS (GASTOS):");
        $sheet->setCellValue("J" . ($summaryRow + 2), "S/ " . number_format($totalEgresos, 2));

        $sheet->setCellValue("I" . ($summaryRow + 3), "SALDO FINAL NETO:");
        $sheet->setCellValue("J" . ($summaryRow + 3), "S/ " . number_format($totalDinero - $totalEgresos, 2));

        $sheet->getStyle("I{$summaryRow}:I" . ($summaryRow + 3))->getFont()->setBold(true);
        $sheet->getStyle("I" . ($summaryRow + 3) . ":J" . ($summaryRow + 3))->getFont()->setBold(true)->getColor()->setRGB('22A15E'); 
    }
}