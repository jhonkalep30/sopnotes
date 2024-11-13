<?php

namespace App\Http\Controllers\Reference;

use App\Components\Filters\Reference\JabatanFilter;
use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\BaseController;
use App\Models\Reference\Jabatan;
use App\Models\Reference\JabatanClassifier;
use Illuminate\Http\Request;

class JabatanController extends BaseController
{
    protected 
        $model = Jabatan::class,
        $filter = JabatanFilter::class,
        $with_relation = ['role', 'jabatanClassifiers.classifier','classifiers'],
        $views = 'reference.jabatan',
        $edit_url = 'reference/jabatan/detail',
        $delete_url = 'reference/jabatan/delete',
        $raw_columns = ['classifier', 'active'];

    public function customDatatable($datatable)
    {
        return $datatable->addColumn('classifier',function($row){

                            $result = '';

                            foreach (@$row['jabatanClassifiers'] ?? [] as $jc) {
                                $result .= '<span class="badge badge-secondary me-1">'.@$jc->classifier->name.'</span>';
                            }

                            return $result;
                            return Carbon::parse($row['updated_at'])->format('F d, Y H:i:s');
                        })
                        ->editColumn('active',function($row){
                            return $row['active'] = $row['active'] ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>';
                        });
    }

    public function list(Request $request)
    {
        $request['is_active'] = 1;

        return parent::list($request);
    }

    public function save(Request $request)
    {
        $result = \DB::transaction(function() use($request){
            $model = @$request->id ? $this->model::findOrFail(@$request->id) : new $this->model;

            if(@$request->id){
                $request->validate(array_merge(method_exists($model, 'ruleOnUpdate') ? $model->ruleOnUpdate() : [], method_exists($this, 'ruleOnUpdate') ? $this->ruleOnUpdate() : []));


                $model->update($request->except(['id', 'classifiers']));
            }else{
                $request->validate(array_merge(method_exists($model, 'rule') ? $model->rule() : [], method_exists($this, 'rule') ? $this->rule() : []));

                $model = $this->model::create($request->except(['classifiers']));
            }

            // JABATAN CLASSIFIERS
            JabatanClassifier::whereJabatanId($model->id)->delete();
            foreach (@$request->classifiers ?? [] as $value) {
                JabatanClassifier::updateOrCreate(['jabatan_id' => $model->id, 'classifier_id' => $value]);
            }

            return $model;
        });

        return ResponseHelper::sendResponse($result, 'Data Has Been Saved!');
    }
}
