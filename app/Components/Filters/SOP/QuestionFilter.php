<?php

namespace App\Components\Filters\SOP;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuestionFilter extends QueryFilters
{
    public function q($v)
    {
        return $this->builder->where('questions.content','LIKE',"%$v%");
    }

    public function content($v)
    {
        return $this->builder->where('questions.content','LIKE',"%$v%");
    }

    public function survey_id($v)
    {
        return $this->builder->join('question_groups','questions.question_group_id','question_groups.id')
                            ->where('question_groups.survey_id',$v);
    }

    public function question_group_id($v)
    {
        return $this->builder->where('questions.question_group_id',$v);
    }

    public function has_multiple_answer($v)
    {
        if($v == 1){
            return $this->builder->has('answers');
            // return $this->builder->join('answers','answer.question_id','questions.id')
                                // ->groupBy('questions.id');
        }
    }
}
