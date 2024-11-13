<?php

namespace App\Components\Filters\SOP;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuestionGroupFilter extends QueryFilters
{
    public function q($v)
    {
        return $this->builder->where('question_groups.name','LIKE',"%$v%");
    }

    public function name($v)
    {
        return $this->builder->where('question_groups.name','LIKE',"%$v%");
    }

    public function survey_id($v)
    {
        return $this->builder->where('question_groups.survey_id',$v);
    }
}
