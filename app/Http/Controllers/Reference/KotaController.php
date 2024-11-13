<?php

namespace App\Http\Controllers\Reference;

use App\Components\Filters\Reference\KotaFilter;
use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\BaseController;
use App\Models\Reference\Kota;
use Illuminate\Http\Request;

class KotaController extends BaseController
{
    protected 
        $model = Kota::class,
        $filter = KotaFilter::class,
        $views = 'reference.kota',
        $edit_url = 'reference/kota/detail',
        $delete_url = 'reference/kota/delete';
    
}
