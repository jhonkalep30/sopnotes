<?php

namespace App\Exports\SOP\Unread;

use App\Models\SOP\Survey;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UnreadUsersSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithStyles, WithStrictNullComparison, WithMapping
{
    protected $params, $title;

    public function __construct($params = [], $title = 'Data')
    {
        $this->params = $params;
        $this->title = $title;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Survey::findOrFail($this->params['id']);

        return $data->unreadUsers();
    }
    
    public function headings(): array
    {

        $headings = ['NAMA','OUTLET','JABATAN','KOTA','UNIT BISNIS','DIREKTORAT'];

        return $headings;
    }

    public function map($item): array
    {
        return [
            @$item->name ?? '-',
            @$item->outlet->name ?? '-',
            @$item->jabatan->name ?? '-',
            @$item->kota_link->name ?? '-',
            @$item->unitBisnis->name ?? '-',
            @$item->direktorat->name ?? '-',
        ];

    }

    public function title(): string
    {
        return $this->title;
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
