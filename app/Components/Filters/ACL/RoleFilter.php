<?php

namespace App\Components\Filters\ACL;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoleFilter extends QueryFilters
{
    public function q($v)
    {
        return $this->builder->where('roles.name','LIKE',"%$v%");
    }

    public function name($v)
    {
    	return $this->builder->where('roles.name','LIKE',"%$v%");
    }

    public function exclude_master($v)
    {
        return $this->builder->where('roles.name','!=',"Master");
    }
}
