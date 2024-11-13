<?php

namespace App\Http\Controllers\Reference;

use App\Components\Filters\Reference\ClassifierFilter;
use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\BaseController;
use App\Models\Reference\Classifier;
use Illuminate\Http\Request;

class ClassifierController extends BaseController
{
    protected 
        $model = Classifier::class,
        $filter = ClassifierFilter::class,
        $views = 'reference.classifier',
        $edit_url = 'reference/classifier/detail',
        $delete_url = 'reference/classifier/delete';
    
}
