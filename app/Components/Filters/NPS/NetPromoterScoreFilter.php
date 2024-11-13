<?php

namespace App\Components\Filters\NPS;

use App\Components\Filters\QueryFilters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NetPromoterScoreFilter extends QueryFilters
{
    // public function q($v)
    // {
    //     return $this->builder->where('net_promoter_scores.name','LIKE',"%$v%");
    // }

    public function start_date($v)
    {
    	return $this->builder->whereDate('staging_data.tanggal_transaksi','>=',$v);
    }

    public function end_date($v)
    {
        return $this->builder->whereDate('staging_data.tanggal_transaksi','<=',$v);
    }

    public function outlet_name($v)
    {
        return $this->builder->where('staging_data.nama_bm',$v);
    }

    public function data_type($v)
    {
        return $this->builder->where('staging_data.data_type',$v);
    }
}
