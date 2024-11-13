<?php

namespace App\Components\Filters\Reference;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SOPTypeFilter extends QueryFilters
{
    protected $table = 'sop_types';

    public function q($v)
    {
        return $this->builder->where($this->table.'.name','LIKE',"%$v%");
    }

    public function name($v)
    {
    	return $this->builder->where($this->table.'.name','LIKE',"%$v%");
    }
}
