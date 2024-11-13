<?php

namespace App\Http\Controllers\Reference;

use App\Components\Filters\Reference\UnitBisnisFilter;
use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\BaseController;
use App\Models\Reference\UnitBisnis;
use Illuminate\Http\Request;

class UnitBisnisController extends BaseController
{
    protected 
        $model = UnitBisnis::class,
        $filter = UnitBisnisFilter::class,
        $views = 'reference.unit-bisnis',
        $edit_url = 'reference/unit-bisnis/detail',
        $delete_url = 'reference/unit-bisnis/delete';
    
}
