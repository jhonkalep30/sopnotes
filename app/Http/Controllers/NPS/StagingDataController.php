<?php

namespace App\Http\Controllers\NPS;

use App\Components\Filters\NPS\StagingDataFilter;
use App\Components\Helpers\ResponseHelper;
use App\Exports\NPS\StagingDataExport;
use App\Exports\NPS\StagingDataTemplate;
use App\Exports\NPS\StagingDataTemplateExport;
use App\Http\Controllers\BaseController;
use App\Imports\NPS\StagingDataImport;
use App\Models\NPS\StagingData;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class StagingDataController extends BaseController
{
    protected 
        $model = StagingData::class,
        // $export = StagingDataExport::class,
        // $import = StagingDataImport::class,
        // $template = StagingDataTemplateExport::class,
        $filter = StagingDataFilter::class,
        // $with_relation = ['stagingData'],
        $views = 'nps.staging-data',
        $edit_url = 'nps/staging-data/detail',
        $delete_url = 'nps/staging-data/delete',
        $order_by = ['column' => 'created_at','method' => 'desc'],
        $raw_columns = ['url','is_published','is_answered', 'is_wa'];

    public function view()
    {
        return view($this->views);
    }

    public function customDatatable($datatable)
    {
        return $datatable->editColumn('id_transaksi',function($row){
                            return @$row->id_transaksi ?? '-';
                        })->addColumn('outlet',function($row){
                            return @$row->nama_klinik ?? @$row->nama_lab ?? '-';
                        })->editColumn('tanggal_transaksi',function($row){
                            return @$row->tanggal_transaksi ?? '-';
                        })->editColumn('nama_bm',function($row){
                            return @$row->nama_bm ?? '-';
                        })->editColumn('data_type',function($row){
                            return @$row->data_type ? ucwords($row->data_type) : '-';
                        })->editColumn('url',function($row){
                            return @$row->url ? '<a href="'.$row->url.'" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-external-link"></i> Open Survey</a>' : '-';
                        })->editColumn('is_published',function($row){
                            $class = 'danger';
                            $text = 'No';
                            if($row->is_published == 1){
                                $class = 'success';
                                $text = 'Yes';
                            }
                            return '<center><span class="badge badge-'.$class.'">'.$text.'</span></center>';
                        })->editColumn('is_wa',function($row){
                            $class = 'danger';
                            $text = 'No';
                            if($row->is_wa == 1){
                                $class = 'success';
                                $text = 'Yes';
                            }
                            return '<center><span class="badge badge-'.$class.'">'.$text.'</span></center>';
                        })->editColumn('is_answered',function($row){
                            $class = 'danger';
                            $text = 'No';
                            if($row->is_answered == 1){
                                $class = 'success';
                                $text = 'Yes';
                            }
                            return '<center><span class="badge badge-'.$class.'">'.$text.'</span></center>';
                        });
    }

    
    public function createData(Request $request, $type)
    {
        $request = new Request(json_decode($request->getContent(),true));
        
        $request->merge([
            'data_type' => $type
        ]);

        $data = StagingData::firstOrCreate([
            'id_transaksi' => $request->id_transaksi,
            'data_type' => $type,
        ],$request->except(['id_transaksi','data_type']));

        // CHECK IS WA
        $data->is_wa = 1;
        if(@setting('nps_blast_whatsapp') === 0) $data->is_wa = 0;

        $data->publish_time = Carbon::parse($data->created_at)->addMinutes(30)->format('Y-m-d H:i:s');
        $data->save();

        return ResponseHelper::sendResponse($data, 'Staging Data Success!');
    }
}
