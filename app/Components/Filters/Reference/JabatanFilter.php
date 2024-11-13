<?php

namespace App\Components\Filters\Reference;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JabatanFilter extends QueryFilters
{
    protected $table = 'jabatan';

    public function q($v)
    {
        return $this->builder->where($this->table.'.name','LIKE',"%$v%");
    }

    public function name($v)
    {
    	return $this->builder->where($this->table.'.name','LIKE',"%$v%");
    }

    public function is_active($v)
    {
        return $this->builder->where($this->table.'.active', 1);
    }
}
