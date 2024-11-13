<?php

namespace App\Components\Filters\SOP;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SurveyReportFilter extends QueryFilters
{
    // public function q($v)
    // {
    //     return $this->builder->where('surveys.name','LIKE',"%$v%");
    // }

    // public function name($v)
    // {
    // 	return $this->builder->where('surveys.name','LIKE',"%$v%");
    // }

    public function survey($v)
    {
        return $this->builder->whereHas('report.survey_origin',function($q) use($v){
            $q->where('surveys.id',$v);
        });
    }

    public function user($v)
    {
        return $this->builder->whereHas('report.user',function($q) use($v){
            $q->where('users.id',$v);
        });
    }

    public function outlet($v)
    {
        return $this->builder->whereHas('report.outlet',function($q) use($v){
            $q->where('outlets.id',$v);
        });
    }

    public function unit_bisnis($v)
    {
        return $this->builder->whereHas('report.unit_bisnis',function($q) use($v){
            $q->where('unit_bisnis.id',$v);
        });
    }

    public function kota($v)
    {
        return $this->builder->whereHas('report.kota',function($q) use($v){
            $q->where('kota.id',$v);
        });
    }

    public function direktorat($v)
    {
        return $this->builder->whereHas('report.direktorat',function($q) use($v){
            $q->where('direktorat.id',$v);
        });
    }

    public function date($v)
    {
        return $this->builder->whereDate('survey_report_summaries.created_at',$v);
    }

    public function start_date($v)
    {
        return $this->builder->whereDate('survey_report_summaries.created_at','>=',$v);
    }

    public function end_date($v)
    {
        return $this->builder->whereDate('survey_report_summaries.created_at','<=',$v);
    }
}
