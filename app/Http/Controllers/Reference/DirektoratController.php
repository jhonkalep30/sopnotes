<?php

namespace App\Http\Controllers\Reference;

use App\Components\Filters\Reference\DirektoratFilter;
use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\BaseController;
use App\Models\Reference\Direktorat;
use Illuminate\Http\Request;

class DirektoratController extends BaseController
{
    protected 
        $model = Direktorat::class,
        $filter = DirektoratFilter::class,
        $views = 'reference.direktorat',
        $edit_url = 'reference/direktorat/detail',
        $delete_url = 'reference/direktorat/delete';
    
}
