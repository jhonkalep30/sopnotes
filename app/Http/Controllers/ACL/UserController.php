<?php

namespace App\Http\Controllers\ACL;

use App\Components\Filters\ACL\UserFilter;
use App\Components\Helpers\ResponseHelper;
use App\Exports\ACL\Users\UserExport;
use App\Exports\ACL\Users\UserTemplate;
use App\Exports\ACL\Users\UserTemplateExport;
use App\Http\Controllers\BaseController;
use App\Imports\ACL\Users\UserImport;
use App\Models\ACL\AccountActivationToken;
use App\Models\ACL\User;
use App\Models\Reference\Jabatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
{
    protected 
        $model = User::class,
        $export = UserExport::class,
        $import = UserImport::class,
        $template = UserTemplateExport::class,
        $filter = UserFilter::class,
        $with_relation = ['role', 'createdBy', 'updatedBy', 'jabatan.classifiers', 'unitBisnis', 'outlet', 'kota_link', 'direktorat'],
        $views = 'acl.user',
        // $edit_url = 'user/detail',
        $edit_url = 'user/show',
        $edit_url_redirect = true,
        $delete_url = 'user/delete',
        // $return_model = ['save'],
        $raw_columns = ['role.name', 'active', 'jabatan.classifiers'];


    public function customDatatable($datatable)
    {
        return $datatable->addColumn('unit_bisnis',function($row){
                            return @$row->unitBisnis->name ?? '-';
                        })
                        ->editColumn('updated_at',function($row){
                            return Carbon::parse($row['updated_at'])->format('F d, Y H:i:s');
                        })
                        ->editColumn('active',function($row){
                            return $row['active'] = $row['active'] ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>';
                        })
                        ->editColumn('jabatan.classifiers',function($row){
                            $result = '';

                            foreach (@$row->jabatan->classifiers ?? [] as $jc) {
                                $result .= '<span class="badge badge-secondary me-1">'.@$jc->name.'</span>';
                            }

                            return $result;
                        });
    }

    public function list(Request $request)
    {
        if(!@$request['not_self']) $request['not_self'] = @\Auth::user()->id;
        return parent::list($request);
    }

    public function datatable(Request $request)
    {
        if(!@$request['not_self']) $request['not_self'] = @\Auth::user()->id;
        return parent::datatable($request);
    }

    public function save(Request $request)
    {

        $result = \DB::transaction(function() use($request){
            $model = @$request->id ? $this->model::findOrFail(@$request->id) : new $this->model;

            if(@$request->id){

                // Set Default Data
                if(@$request['jabatan_id']){
                    $request['role_id'] = @Jabatan::whereId(@$request->jabatan_id)->first()->role_id;
                }

                $request->validate(array_merge($model->ruleOnUpdate(), method_exists($this, 'ruleOnUpdate') ? $this->ruleOnUpdate() : []));

                // Automatically Hashing Password If Request Has Password
                if(@$request['password'] && $request['password'] != null){
                    $request['password'] = bcrypt($request->password);
                }else{
                    unset($request['password']);
                }

                $model->update($request->except(['id']));

            }else{

                // Set Default Data
                $request['active'] = 1;
                $request['password'] = bcrypt(123456);
                $request['role_id'] = @Jabatan::whereId(@$request->jabatan_id)->first()->role_id;

                $request->validate(array_merge($model->rule(), method_exists($this, 'rule') ? $this->rule() : []));

                $model = $this->model::create($request->all());
            }

            // Uploading Files
            foreach($request->all() as $key => $value){
                if($request->hasFile($key)){
                    $model->update([$key => upload_file($request->file($key), $this->upload_prefix)]);
                }
            }

            return $model;
        });

        if(@$result['error'] && @$result['message']) return ResponseHelper::sendError($result['message']);

        return ResponseHelper::sendResponse($result, 'Data Has Been Saved!');
    }

    public function accountActivation()
    {
        $checkToken = AccountActivationToken::where('token', @request()->token)
                        ->where('email', @request()->email)
                        ->first();

        if(!$checkToken) return redirect('login')->withErrors(['email' => 'Link was invalid or expired, please check again']);

        $user = User::whereEmail(@request()->email)->first();

        if(!$user) return redirect('login')->withErrors(['email' => 'Account was not found, please contact administrator']);

        $user->update(['active' => 1, 'email_verified_at' => Carbon::now()]);
        $checkToken->delete();

        return redirect('login')->with(['status_top' => 'Your account has been activated', 'email' => @request()->email]);
    }
}
