<?php

namespace App\Http\Controllers;

use App\Components\Filters\JobTraceFilter;
use App\Http\Controllers\BaseController;
use App\Models\JobTrace;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobTraceController extends BaseController
{
    protected $model = JobTrace::class;
    protected $filter = JobTraceFilter::class;

    public function datatable(Request $request)
    {
        $data = $this->model::whereIn('model',$request->filters['model'])
                        ->orderByDesc('job_traces.id')
                        ->get();

        return \DataTables::of($data)
                ->editColumn('status',function($data){
                    return $data->getStatusHtml();
                })
                ->addColumn('size',function($data){
                    return $data->file_path != null ? get_file_size($data->file_size) : '-';
                })
                ->editColumn('requested_by',function($data){
                    return $data->user->name;
                })
                ->addColumn('requested_at',function($data){
                    return '<span style="font-weight:700;font-size:12px">'.Carbon::parse($data->created_at)->translatedFormat('d F Y').'</span><br><span style="font-size:10px">'.Carbon::parse($data->created_at)->translatedFormat('H:i:s').'</span>';
                })
                ->addColumn('finished_at',function($data){
                    if(in_array($data->status,[$this->model::FAILED,$this->model::SUCCESS])){
                        return '<span style="font-weight:700;font-size:12px">'.Carbon::parse($data->updated_at)->translatedFormat('d F Y').'</span><br><span style="font-size:10px">'.Carbon::parse($data->updated_at)->translatedFormat('H:i:s').'</span>';
                    }

                    return '-';
                })
                ->addColumn('action', function ($data){
                    // $el = '<button type="button" class="btn btn-icon btn-danger btn-sm mr-1 mb-1"><i class="fas fa-trash"></i></button>';
                    $el = '';

                    if($data->status == $this->model::SUCCESS){
                        $el .= '<a href="'.$data->file_path.'" class="btn btn-icon btn-primary btn-sm mr-1 mb-1"><i class="fas fa-download"></i></a>';
                    }

                    // if($data->status == $this->model::FAILED){
                    //     $el .= '<button type="button" class="btn btn-icon btn-warning btn-sm mr-1 mb-1 text-white"><i class="fas fa-comment"></i></button>';
                    // }
                    
                    return $el;
                })
                ->rawColumns(['action','status','requested_at','finished_at'])
                ->make(true);
    }
}
