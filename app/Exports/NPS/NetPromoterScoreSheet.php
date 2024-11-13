<?php

namespace App\Exports\NPS;

use App\Components\Filters\NPS\NetPromoterScoreFilter;
use App\Models\NPS\NetPromoterScore;
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

class NetPromoterScoreSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithStyles, WithStrictNullComparison, WithMapping
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
        $filters = new NetPromoterScoreFilter(new Request($this->params));

        $data = NetPromoterScore::filter($filters)
                            ->join('staging_data','net_promoter_scores.staging_data_id','staging_data.id')
                            ->select('net_promoter_scores.*','staging_data.id_transaksi','staging_data.tanggal_transaksi','staging_data.nama_bm','staging_data.data_type')
                            ->orderByDesc('net_promoter_scores.created_at')
                            ->get();

        return $data;
    }
    
    public function headings(): array
    {
        $headings = ['ID TRANSAKSI','TANGGAL TRANSAKSI','NAMA BM','TYPE','SCORE','LEVEL'];

        return $headings;
    }

    public function map($item): array
    {
        return [
            $item->id_transaksi,
            $item->tanggal_transaksi,
            $item->nama_bm,
            ucwords($item->data_type),
            $item->value,
            $item->level,
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
