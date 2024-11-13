<?php

namespace App\Http\Controllers\Reference;

use App\Components\Filters\Reference\SOPTypeFilter;
use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\BaseController;
use App\Models\Reference\SOPType;
use Illuminate\Http\Request;

class SOPTypeController extends BaseController
{
    protected 
        $model = SOPType::class,
        $filter = SOPTypeFilter::class,
        $views = 'reference.sop-type',
        $edit_url = 'reference/sop-type/detail',
        $delete_url = 'reference/sop-type/delete';
    
}
