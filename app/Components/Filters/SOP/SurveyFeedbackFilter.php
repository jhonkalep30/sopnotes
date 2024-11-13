<?php

namespace App\Components\Filters\SOP;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SurveyFeedbackFilter extends QueryFilters
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
        return $this->builder->whereHas('survey_feedback.survey',function($q) use($v){
            $q->where('surveys.id',$v);
        });
    }

    public function user($v)
    {
        return $this->builder->whereHas('survey_feedback.user',function($q) use($v){
            $q->where('users.id',$v);
        });
    }

    public function date($v)
    {
        return $this->builder->whereHas('survey_feedback',function($q) use($v){
            $q->whereDate('survey_feedback.created_at',$v);
        });
    }
}
