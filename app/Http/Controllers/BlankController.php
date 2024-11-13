<?php

namespace App\Http\Controllers;

use App\Components\Helpers\ResponseHelper;
use Carbon\Carbon;
use Storage;

class BlankController extends Controller
{
    public function view()
    {
        $uri = str_replace(env('APP_URL').'/', '', request()->url());
        $uri = explode('/', $uri);

        $breadcrumbs = [];

        $breadcrumbs[] = [
            'label' => 'Dashboard',
            'url' => route('admin.dashboard')
        ];

        $textTransform = 'ucwords';
        if(@request()->route()->action['title_uppercase']) $textTransform = 'strtoupper';

        foreach ($uri as $url) {
            $breadcrumbs[] = [
                'label' => $textTransform(str_replace('-', ' ', $url)),
            ];
        }

        return view('blank', ['title' => $textTransform(str_replace('-', ' ', basename(request()->path()))), 'breadcrumbs' => $breadcrumbs]);
    }

}
