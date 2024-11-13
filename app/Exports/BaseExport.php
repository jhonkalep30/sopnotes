<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BaseExport implements WithMultipleSheets, WithHeadings, ShouldAutoSize, WithColumnWidths, WithStyles, WithStrictNullComparison
{
    use Exportable;

    public function headings(): array
    {
        return [];
    }

    public function sheets(): array
    {
        return [];
    }

    public function columnWidths(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }
}
