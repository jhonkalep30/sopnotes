<?php

namespace App\Components\Filters\Assets;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssetFilter extends QueryFilters
{
    protected $table = 'assets';

    public function q($v)
    {
        return $this->builder->where($this->table.'.name','LIKE',"%$v%");
    }

    public function name($v)
    {
    	return $this->builder->where($this->table.'.name','LIKE',"%$v%");
    }

    public function type($v)
    {
        if($v == 'images') return $this->builder->whereIn('ext',['jpg','jpeg','png']);
        if($v == 'files') return $this->builder->whereIn('ext',['pdf','doc','docx','xls','xlsx']);
        return null;
    }
}
