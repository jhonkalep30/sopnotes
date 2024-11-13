<?php

namespace App\Http\Controllers\NPS;

use App\Components\Filters\NPS\NetPromoterScoreFilter;
use App\Components\Helpers\ResponseHelper;
use App\Exports\NPS\NetPromoterScoreExport;
// use App\Exports\NPS\NetPromoterScoreTemplate;
// use App\Exports\NPS\NetPromoterScoreTemplateExport;
use App\Http\Controllers\BaseController;
use App\Imports\NPS\NetPromoterScoreImport;
use App\Models\NPS\NetPromoterScore;
use App\Models\NPS\ScoringTag;
use App\Models\NPS\ScoringValue;
use App\Models\NPS\StagingData;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class NetPromoterScoreController extends BaseController
{
    protected 
        $model = NetPromoterScore::class,
        $export = NetPromoterScoreExport::class,
        // $import = NetPromoterScoreImport::class,
        // $template = NetPromoterScoreTemplateExport::class,
        $filter = NetPromoterScoreFilter::class,
        $with_relation = ['stagingData'],
        $views = 'nps',
        $edit_url = 'nps/detail',
        $delete_url = 'nps/delete',
        // $order_by = ['column' => 'created_at','method' => 'desc'],
        $raw_columns = ['score','level', 'feedback'];

    public function datatable(Request $request)
    {
        $data = $this->model::filter(new $this->filter($request))
                            ->join('staging_data','net_promoter_scores.staging_data_id','staging_data.id')
                            ->select('net_promoter_scores.*','staging_data.id_transaksi','staging_data.tanggal_transaksi','staging_data.nama_bm','staging_data.data_type')
                            ->orderByDesc('net_promoter_scores.created_at')
                            ->get();

        return \DataTables::of($data)
                        ->addColumn('id_transaksi',function($row){
                            return @$row->id_transaksi ?? '-';
                        })->addColumn('tanggal_transaksi',function($row){
                            return @$row->tanggal_transaksi ?? '-';
                        })->addColumn('nama_bm',function($row){
                            return @$row->nama_bm ?? '-';
                        })->addColumn('data_type',function($row){
                            return @$row->data_type ? ucwords($row->data_type) : '-';
                        })->addColumn('score',function($row){
                            return '<span class="fw-bold">'.(@$row->value ?? '-').'</span>';
                        })->editColumn('level',function($row){
                            $class = 'danger';
                            if($row->level == 'Passives') $class = 'warning';
                            if($row->level == 'Promoters') $class = 'primary';
                            return '<span class="badge badge-'.$class.'">'.$row->level.'</span>';
                        })->addColumn('feedback',function($row){
                            $feedback = '';

                            if(@$row->tags && $row->tags != '' && $row->tags != 'null'){
                                foreach (json_decode($row->tags) as $tag) {
                                    if($tag == 'Lainnya' && @$row->notes) $tag .= ':<span class="fw-bold ms-1">'.$row->notes.'</span>';

                                    $feedback .= '<span class="badge badge-light-info fw-semibold me-1">'.$tag.'</span>';
                                }
                            }

                            return $feedback;
                        })
                        ->rawColumns($this->raw_columns)
                        ->make(true);
    }

    public function surveyView(Request $request)
    {
        try{

            $request->validate([
                'id_transaksi' => 'required|string',
            ]);

            $stagingData = StagingData::where('id_transaksi',$this->decryptHash($request->id_transaksi))->first();

            if($stagingData && $stagingData->is_answered == 0 && $stagingData->is_published == 1){
                return view($this->views.'.survey',['id_transaksi' => $request->id_transaksi]);
            }

            if($stagingData && $stagingData->is_answered == 1 && $stagingData->is_published == 1){
                return view($this->views.'.survey-answered');
            }

            abort(404);

        }catch(\Exception $ex){
            abort(404);
        }
    }

    public function surveySave(Request $request)
    {
        $stagingData = StagingData::where('id_transaksi',$this->decryptHash($request->id_transaksi))->first();
        
        if($stagingData && $stagingData->is_answered == 0 && $stagingData->is_published == 1){
            DB::transaction(function() use($stagingData, $request){
                $nps = NetPromoterScore::whereStagingDataId($stagingData->id)->first() ?? new NetPromoterScore;
                $nps->staging_data_id = $stagingData->id;
                $nps->value = $request->scoring_value;
                $nps->level = ScoringValue::where('value',$request->scoring_value)->first()->level;
                $nps->tags = json_encode($request->scoring_tags);
                $nps->notes = $request->notes;
                
                $masterScorings = [
                    'scoring_values' => ScoringValue::all(),
                    'scoring_tags' => ScoringTag::all(),
                ];
                $nps->master_scorings = json_encode($masterScorings);

                $nps->save();

                $stagingData->is_answered = 1;
                $stagingData->save();
            });

            return view($this->views.'.survey-finish');
        }

        abort(404);
    }

    public function outletSummary(Request $request)
    {
        $data = NetPromoterScore::join('staging_data','net_promoter_scores.staging_data_id','staging_data.id')
                            ->select(DB::raw("nama_bm AS nama_outlet, SUM(CASE WHEN level = 'Detractors' THEN 1 ELSE 0 END) AS detractors, SUM(CASE WHEN level = 'Promoters' THEN 1 ELSE 0 END) AS promoters, COUNT(*) as total, data_type as type_outlet"))
                            ->whereBetween('tanggal_transaksi',[(@$request->start_date ? Carbon::parse(@$request->start_date) : Carbon::now()->startOfMonth())->format('Y-m-d'),(@$request->end_date ? Carbon::parse(@$request->end_date) : Carbon::now())->format('Y-m-d')])
                            ->groupBy('staging_data.id')
                            ->get();

        return \DataTables::of($data)
                        ->editColumn('type_outlet',function($row){
                            return ucwords($row->type_outlet);
                        })
                        ->addColumn('outlet_score',function($row){
                            return (($row->promoters/$row->total)*100) - (($row->detractors/$row->total)*100);
                        })
                        ->make(true);
    }
}
