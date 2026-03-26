<?php

namespace App\Exports;

use App\Models\MovimientoInventario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventarioSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    public function title(): string
    {
        return 'Movimientos de Stock';
    }

    public function collection()
    {
        // Traemos todos los movimientos de HOY, incluyendo ventas, compras a proveedores, mermas, etc.
        return MovimientoInventario::with('producto')
            ->whereDate('created_at', now())
            ->get();
    }

    public function headings(): array
    {
        return [
            ['DAMIAN COMPANY - AUDITORÍA DE INVENTARIO'],
            ['Fecha:', now()->format('d/m/Y')],
            [''],
            ['Hora', 'SKU', 'Producto', 'Tipo de Mov.', 'Cant. Movida', 'Stock Final', 'Motivo / Referencia']
        ];
    }

    public function map($movimiento): array
    {
        return [
            $movimiento->created_at->format('H:i:s'),
            $movimiento->producto->codigo ?? '-',
            $movimiento->producto->nombre,
            strtoupper($movimiento->tipo), // INGRESO o SALIDA
            ($movimiento->tipo === 'ingreso' ? '+' : '-') . $movimiento->cantidad,
            $movimiento->stock_despues ?? $movimiento->producto->stock, // Muestra cómo quedó el stock en ese momento
            $movimiento->motivo
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A4:G4')->getFont()->setBold(true);
    }
}