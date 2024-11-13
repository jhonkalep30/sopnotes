<?php

namespace App\Components\Filters\SOP;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SurveyFilter extends QueryFilters
{
    public function q($v)
    {
        return $this->builder->where('surveys.name','LIKE',"%$v%");
    }

    public function name($v)
    {
    	return $this->builder->where('surveys.name','LIKE',"%$v%");
    }

    public function frequency($v)
    {
        return $this->builder->where('surveys.frequency',$v);
    }

    public function privacy($v)
    {
        return $this->builder->where('surveys.privacy',$v);
    }

    public function classifiers($v)
    {
        return $this->builder->whereHas('classifiers',function($q) use($v){
            $q->whereIn('survey_classifiers.classifier_id',$v);
        });
    }
}
