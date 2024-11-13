<?php

namespace App\Components\Filters\Reference;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OutletFilter extends QueryFilters
{
    protected $table = 'outlets';

    public function q($v)
    {
        return $this->builder->where($this->table.'.name','LIKE',"%$v%");
    }

    public function name($v)
    {
    	return $this->builder->where($this->table.'.name','LIKE',"%$v%");
    }
}
