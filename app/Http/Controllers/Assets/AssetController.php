<?php

namespace App\Http\Controllers\Assets;

use App\Components\Filters\Assets\AssetFilter;
use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\BaseController;
use App\Models\Assets\Asset;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AssetController extends BaseController
{
    protected 
        $model = Asset::class,
        $filter = AssetFilter::class,
        $views = 'assets',
        $edit_url = 'asset/detail',
        $upload_prefix = 'assets',
        $raw_columns = ['name'],
        $delete_url = 'asset/delete';
    
    public function viewImages()
    {
        return view($this->views.'.index',['type' => 'images']);
    }

    public function viewFiles()
    {
        return view($this->views.'.index',['type' => 'files']);
    }

    public function save(Request $request)
    {
        if($request->hasFile('file')){
            $request['name'] = @$request->name ?? $request->file('file')->getClientOriginalName();
            $request['size'] = $request->file('file')->getSize();
            $request['ext'] = $request->file('file')->extension();
        }

        return parent::save($request);
    }

    public function customDatatable($datatable)
    {
        return $datatable->editColumn('name',function($row){
                            if(request()->type == 'images'){
                                return '<a href="'.$row->file.'" target="_blank" class="text-gray-800 text-hover-primary"><img src="'.$row->file.'" width="100"></a><br>'.$row->name;
                            }

                            return '<div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-picture fs-2x text-primary me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span></i>
                                            <a href="'.$row->file.'" target="_blank" class="text-gray-800 text-hover-primary">'.$row->name.'</a>
                                    </div>';
                        })
                        ->editColumn('size',function($row){
                            return get_file_size($row->size);
                        })
                        ->editColumn('created_at',function($row){
                            return Carbon::parse($row->created_at)->format('F d, Y H:i:s');
                        })
                        ->editColumn('updated_at',function($row){
                            return Carbon::parse($row->updated_at)->format('F d, Y H:i:s');
                        })
                        ->addColumn('uploaded_by',function($row){
                            return @$row->createdBy->name ?? '-';
                        });
    }
}
