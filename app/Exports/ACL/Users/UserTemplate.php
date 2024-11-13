<?php

namespace App\Exports\ACL\Users;

use App\Models\ACL\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserTemplate implements WithHeadings, WithTitle, WithStyles
{
    use Exportable;

    public function headings(): array
    {
        $headings = [];
        foreach(User::rule() as $key => $value){
            $headings[] = strtoupper(str_replace('_','',str_replace('_id', '', $key)));
        }

        return $headings;
    }

    public function title(): string
    {
        return 'Data';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true,'color' => ['rgb' => 'ffffff']], 
                'fill' => ['fillType' => Fill::FILL_SOLID,'startColor' => ['rgb' => '0a8f76']]
            ],
        ];
    }
}