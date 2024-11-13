<?php

namespace App\Exports\SOP\Report;

use App\Components\Filters\SOP\SurveyReportFilter;
use App\Models\SOP\Survey;
use App\Models\SOP\SurveyReport;
use App\Models\SOP\SurveyReportSummary;
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

class ReportSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithStyles, WithStrictNullComparison, WithMapping
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
        $filters = new SurveyReportFilter(new Request($this->params));

        $surveyField = str_replace(' ', '_', strtoupper(config('dynamic-survey.survey')));
        $subTaskField = str_replace(' ', '_', strtoupper(config('dynamic-survey.answer')));

        $data = SurveyReportSummary::filter($filters)
                            ->join('survey_reports','survey_report_summaries.survey_report_id','survey_reports.id')
                            ->leftJoin('users','survey_reports.user_id','users.id')
                            ->leftJoin('surveys','survey_reports.survey_id','surveys.id')
                            ->leftJoin('outlets','survey_reports.outlet_id','outlets.id')
                            ->leftJoin('kota','survey_reports.kota_id','kota.id')
                            ->leftJoin('unit_bisnis','survey_reports.unit_bisnis_id','unit_bisnis.id')
                            ->leftJoin('direktorat','survey_reports.direktorat_id','direktorat.id')
                            ->select('users.name as user_name','outlets.name as outlet_name','unit_bisnis.name as unit_bisnis_name','surveys.name as '.$surveyField,'surveys.frequency as frekuensi','survey_reports.started_at as mulai','survey_reports.ended_at as selesai','survey_report_summaries.duration as durasi','survey_report_summaries.completed as '.$subTaskField.'_selesai','survey_report_summaries.uncompleted as '.$subTaskField.'_tidak_selesai','survey_report_summaries.feedback as feedback')
                            ->orderByDesc('survey_reports.created_at')
                            ->get();

        return $data;
    }
    
    public function headings(): array
    {

        $headings = ['USER','OUTLET','UNIT BISNIS',strtoupper(config('dynamic-survey.survey')),'FREKUENSI','MULAI','SELESAI','DURASI',strtoupper(config('dynamic-survey.answer')).' SELESAI',strtoupper(config('dynamic-survey.answer')).' TIDAK SELESAI','FEEDBACK'];

        return $headings;
    }

    public function map($item): array
    {
        $surveyField = str_replace(' ', '_', strtoupper(config('dynamic-survey.survey')));
        $subTaskField = str_replace(' ', '_', strtoupper(config('dynamic-survey.answer')));

        $completed = $subTaskField.'_selesai';
        $uncompleted = $subTaskField.'_tidak_selesai';

        return [
            @$item->user_name ?? '-',
            @$item->outlet_name ?? '-',
            @$item->unit_bisnis_name ?? '-',
            @$item->$surveyField ?? '-',
            @Survey::getFrequency(@$item->frekuensi) ?? '-',
            @$item->mulai ?? '-',
            @$item->selesai ?? '-',
            @$item->durasi ?? '-',
            @$item->$completed ?? '-',
            @$item->$uncompleted ?? '-',
            @$item->feedback ?? '-',
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
