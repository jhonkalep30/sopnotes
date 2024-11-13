<?php

namespace App\Http\Controllers;

use App\Components\Helpers\ResponseHelper;
use App\Jobs\BaseJob;
use App\Models\JobTrace;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Storage;
use Vinkla\Hashids\Facades\Hashids;

class BaseController extends Controller
{
    protected $model, $filter, $with_relation, $select, $export, $import, $views, $raw_columns, $order_by;

    public function __construct(Request $request)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function view()
    {
        return view($this->views.'.index');
    }

    public function datatable(Request $request)
    {
        $data = $this->model::with(@$this->with_relation ?? []);

        if(@$this->filter){
            $filters = new $this->filter($request);
            $data = $data->filter($filters);
        }

        if(@$this->order_by){
            $data = $data->orderBy($this->order_by['column'],$this->order_by['method']);
        }

        $datatable = \DataTables::of($data)
                                ->addColumn('action',function($row){

                                    if(!access(strtolower(class_basename(@$this->model_acl ?? $this->model)).'.save') && !access(strtolower(class_basename(@$this->model_acl ?? $this->model)).'.delete')) return '';

                                    $edit = '<div class="menu-item px-3">
                                                <a class="menu-link edit-button" href="javascript:void(0);" onclick="viewData(\''.url($this->edit_url.'/'.$row->id).'\')">Edit</a>
                                            </div>';

                                    if(@$this->edit_url_redirect){
                                        $edit = '<div class="menu-item px-3">
                                                <a class="menu-link edit-button" href="'.url($this->edit_url.'/'.$row->id).'">Edit</a>
                                            </div>'; 
                                    }

                                    return '<a href="javascript:void(0)" class="btn btn-icon btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                                <i class="ki-duotone ki-setting-4 fs-3">
                                         
                                                </i>
                                            </a>

                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold fs-6 w-150px py-4" data-kt-menu="true" style="">
                                                '.$edit.'
                                                <div class="menu-item px-3">
                                                    <a class="menu-link flex-stack delete-button" href="javascript:void(0);" onclick="deleteData(\''.url($this->delete_url).'\','.$row->id.')">Delete <i style="cursor: pointer; margin-left: 4px !important;" class="fas fa-exclamation-circle ms-2 fs-7 text-danger" title="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Please check data once more before deleting" data-bs-custom-class="tooltip-white"></i></a>
                                                </div>
                                            </div>';

                                    return '<div class="dropdown">
                                                <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary"><i class="fa fa-cog"></i></button>
                                                <div class="dropdown-content menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4">
                                                    <div class="menu-item px-3 text-center">
                                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Options</div>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a class="menu-link edit-button" href="javascript:void(0);" onclick="viewData(\''.url($this->edit_url.'/'.$row->id).'\')">Edit</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a class="menu-link flex-stack delete-button" href="javascript:void(0);" onclick="deleteData(\''.url($this->delete_url).'\','.$row->id.')">Delete <i style="cursor: pointer; margin-left: 4px !important;" class="fas fa-exclamation-circle ms-2 fs-7 text-danger" title="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="Please check data once more before deleting" data-bs-custom-class="tooltip-white"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>';

                                    // return '<button class="btn btn-icon btn-light-primary btn-sm" onclick="viewData(\''.url($this->edit_url.'/'.$row->id).'\')"><i class="fas fa-edit"></i></button>
                                    //         <button class="btn btn-icon btn-light-danger btn-sm" onclick="deleteData(\''.url($this->delete_url).'\','.$row->id.')"><i class="fas fa-trash"></i></button>';
                                });

        $datatable = $this->customDatatable($datatable);
        $rawColumns = array_merge(['action'],@$this->raw_columns ?? []);

        return $datatable->rawColumns($rawColumns)
                        ->make(true);
                        
    }

    public function customDatatable($datatable)
    {
        return $datatable;
    }

    public function list(Request $request)
    {
        $data = $this->model::with(@$this->with_relation ?? []);

        if(@$this->filter){
            $filters = new $this->filter($request);
            $data = $data->filter($filters);
        }

        if(@$this->select){
            $data = $data->selectRaw(@$this->select);
        }

        if(isset($request->paginate)){
            $data = $data->paginate(@$request->paginate ?? 10);
            $mapping = 'through';
        }else{
            $data = $data->get();
            $mapping = 'transform';
        }

        if(isset($request->fns)){

            $data = $data->$mapping(function($item, $key) use ($request){

                foreach (@$request->fns?? [] as $fn) {
                    $fnField = strtolower(str_replace(' ', '_', $fn));
                    $fn = str_replace(' ', '', ucwords(str_replace('_', ' ', $fn)));

                    if(method_exists($item, 'fn'.$fn)){
                        $fnRun = $item->{'fn'.$fn}();

                        if(@$fnRun['field'] && (@$fnRun['value'] || $fnRun['value'] === 0 || $fnRun['value'] === '')){
                            $item[$fnRun['field']] = $fnRun['value'];
                        }else{
                            $item[$fnField] = $fnRun;
                        }
                    }

                }

                return $item;
            });

        }

        return (isset($request->paginate) ? $data : ResponseHelper::sendResponse($data, 'Success'));

        // if(isset($request->paginate)) return $this->model::filter($filters)->paginate(@$request->paginate ?? 10);
        // return ResponseHelper::sendResponse($this->model::filter($filters)->get(), 'Success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        $result = DB::transaction(function() use($request){
            $model = @$request->id ? $this->model::findOrFail(@$request->id) : new $this->model;

            if(@$request->id){
                $request->validate(array_merge(method_exists($model, 'ruleOnUpdate') ? $model->ruleOnUpdate() : [], method_exists($this, 'ruleOnUpdate') ? $this->ruleOnUpdate() : []));

                // Automatically Hashing Password If Request Has Password
                if(@$request['password'] && $request['password'] != null){
                    $request['password'] = bcrypt($request->password);
                }else{
                    unset($request['password']);
                }

                $model->update($request->except(['id']));
            }else{
                $request->validate(array_merge(method_exists($model, 'rule') ? $model->rule() : [], method_exists($this, 'rule') ? $this->rule() : []));

                // Automatically Hashing Password If Request Has Password
                if(@$request['password']) $request['password'] = bcrypt($request->password);

                $model = $this->model::create($request->all());
            }

            // Uploading Files
            foreach($request->all() as $key => $value){
                if($request->hasFile($key)){
                    $model->update([$key => upload_file($request->file($key), $this->upload_prefix)]);
                }
            }

            if(@$this->with_relation){
                $model = $this->model::with($this->with_relation)->find(@$model->id);
            }

            return $model;
        });

        if(in_array(__FUNCTION__, @$this->return_model ?? [])) return $result;

        return ResponseHelper::sendResponse($result, 'Data Has Been Saved!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->views.'.form');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->model::with(@$this->with_relation ?? [])->findOrFail($id);
        return view($this->views.'.form',['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail(Request $request, string $id)
    {
        $result = $this->model::with(@$this->with_relation ?? [])->findOrFail($id);
        return ResponseHelper::sendResponse($result, 'Data Found!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $id = request()->id;

        $result = DB::transaction(function() use($id){
            $model = $this->model::findOrFail($id);
            $model->delete();

            return $model;
        });

        return ResponseHelper::sendResponse($result, 'Data Has Been Deleted!');
    }

    public function downloadTemplate()
    {
        $fileName = implode(' ', \Str::ucsplit(class_basename($this->template))).'.xlsx';

        return (new $this->template)->download($fileName);
    }

    public function processingExport(Request $request)
    {
        $request->validate([
            'method' => 'required|string',
            'type' => 'required|string'
        ]);

        $title = implode(' ', \Str::ucsplit(class_basename($this->export)));

        if($request->method == 'direct'){

            if($request->type == 'xlsx'){
                $fileName = $title.' (@'.Carbon::now()->format('YmdHis').').xlsx';
                $store = (new $this->export($request->all()))->store('public/exports/'.$fileName);

                // return (new $this->export($request->all()))->download($fileName);
                return ResponseHelper::sendResponse([
                    'url' => asset(Storage::url('public/exports/'.$fileName)),
                    'filename' => $fileName,
                ], 'Success!');
            }
            
            return ResponseHelper::sendError('Unknown Export Type!',[]);
            
        }elseif($request->method == 'queue'){

            $jobTrace = JobTrace::create([
                'title' => $title,
                'model' => $this->export,
                'requested_by' => Auth::user()->id,
            ]);

            dispatch(new BaseJob($jobTrace,$request->all(),'export'));

            return ResponseHelper::sendResponse([], 'Export Started!');
        
        }else{
        
            return ResponseHelper::sendError('Unknown Export Method!',[]);
        
        }

    }

    public function processingImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx'
        ]);

        $title = implode(' ', \Str::ucsplit(class_basename($this->import)));

        $fileName = $request->file('file')->store('public/imports');

        $url = asset(Storage::url($fileName));

        $jobTrace = JobTrace::create([
            'title' => $title,
            'model' => $this->import,
            'requested_by' => Auth::user()->id,
            'file_path' => $url,
            'file_size' => filesize(public_path(Storage::url($fileName))),
        ]);

        dispatch(new BaseJob($jobTrace,$request->except(['file']),'import'));

        return ResponseHelper::sendResponse([], 'Import Started!');
    }

    public function encryptId($id)
    {
        return Hashids::encode($id);
    }

    public function decryptHash($hashText)
    {
        $decode = Hashids::decode($hashText);
        if(count($decode) == 0) abort(404);
        return $decode[0];
    }
}
