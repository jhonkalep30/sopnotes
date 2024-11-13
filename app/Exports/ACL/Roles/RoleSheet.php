<?php

namespace App\Exports\ACL\Roles;

use App\Components\Filters\ACL\RoleFilter;
use App\Models\ACL\Role;
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

class RoleSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithStyles, WithStrictNullComparison, WithMapping
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
        $filters = new RoleFilter(new Request($this->params));

        $data = Role::filter($filters)
                    ->where('is_master', '!=', 1)
                    ->get();

        return $data;
    }
    
    public function headings(): array
    {
        $headings = ['NAME'];

        return $headings;
    }

    public function map($item): array
    {
        return [
            $item->name,
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
