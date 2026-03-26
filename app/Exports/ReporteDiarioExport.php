<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteDiarioExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        return [
            new VentasSheet(),
            new InventarioSheet(),
        ];
    }
}