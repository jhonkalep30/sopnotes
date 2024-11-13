<?php

namespace App\Components\Filters\NPS;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StagingDataFilter extends QueryFilters
{
    // public function q($v)
    // {
    //     return $this->builder->where('staging_data.id_transaksi','LIKE',"%$v%");
    // }

    // public function id_transaksi($v)
    // {
    // 	return $this->builder->where('staging_data.id_transaksi','LIKE',"%$v%");
    // }
}
