<?php

namespace App\Components\Filters\SOP;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnswerFilter extends QueryFilters
{
    public function q($v)
    {
        return $this->builder->where('answers.content','LIKE',"%$v%");
    }

    public function content($v)
    {
        return $this->builder->where('answers.content','LIKE',"%$v%");
    }

    public function question_group_id($v)
    {
        return $this->builder->join('questions','answers.question_id','questions.id')
                            ->where('questions.question_group_id',$v);
    }

    public function question_id($v)
    {
        return $this->builder->where('answers.question_id',$v);
    }
}
