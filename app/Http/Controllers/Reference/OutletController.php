<?php

namespace App\Http\Controllers\Reference;

use App\Components\Filters\Reference\OutletFilter;
use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\BaseController;
use App\Models\Reference\Outlet;
use Illuminate\Http\Request;

class OutletController extends BaseController
{
    protected 
        $model = Outlet::class,
        $filter = OutletFilter::class,
        $views = 'reference.outlet',
        $edit_url = 'reference/outlet/detail',
        $delete_url = 'reference/outlet/delete';
    
}
