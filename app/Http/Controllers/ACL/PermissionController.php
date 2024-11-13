<?php

namespace App\Http\Controllers\ACL;

use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\ACL\Menu;
use App\Models\ACL\Permission;
use App\Models\ACL\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PermissionController extends Controller
{
    protected $model = Permission::class;

    public function view()
    {
        return view('acl.permission.index');
    }

    public function list(Request $request)
    {
        $result = [];

        // GROUPS
        $groupKeys = array_unique($this->model::whereNotNull('group_key')->get()->pluck('group_label', 'group_key')->toArray());
        foreach ($groupKeys as $groupKeyIndex => $groupKeyLabel) {
            $result[] = [
                'key' => $groupKeyIndex,
                'label' => $groupKeyLabel,
                'actions' => $this->model::whereGroupKey($groupKeyIndex)
                                ->when(@$request->search, function($q) use ($request){
                                    return $q->where(function($q2) use ($request){
                                        return $q2->where('permission_key', 'like', '%'.$request->search.'%')
                                                  ->orWhere('group_label', 'like', '%'.$request->search.'%')
                                                  ->orWhere('action_label', 'like', '%'.$request->search.'%')
                                                  ->orWhere('url', 'like', '%'.$request->search.'%');
                                    });
                                })
                                ->get()->toArray()
            ];
        }

        // SINGLE
        $result[] = [
            'key' => '#',
            'label' => 'Non Group',
            'actions' => $this->model::whereNull('group_key')
                            ->when(@$request->search, function($q) use ($request){
                                return $q->where(function($q2) use ($request){
                                    return $q2->where('permission_key', 'like', '%'.$request->search.'%')
                                              ->orWhere('group_label', 'like', '%'.$request->search.'%')
                                              ->orWhere('action_label', 'like', '%'.$request->search.'%')
                                              ->orWhere('url', 'like', '%'.$request->search.'%');
                                });
                            })
                            ->get()->toArray()
        ];

        return ResponseHelper::sendResponse($result, 'Success!');
    }

    public function data(Request $request)
    {
        $data = $this->model::when(@$request->q, function($q) use ($request){
                    return $q->where(function($q2) use ($request){
                        return $q2->where('permission_key', 'like', '%'.$request->q.'%')
                                  ->orWhere('group_label', 'like', '%'.$request->q.'%')
                                  ->orWhere('action_label', 'like', '%'.$request->q.'%')
                                  ->orWhere('url', 'like', '%'.$request->q.'%');
                    });
                })->when(@config('acl.keys_for_menu'), function($q){
                    return $q->where('permission_key', 'like', '%'. config('acl.keys_for_menu'));
                });

        if(@$request->paginate) return $data->paginate(@$request->paginate ?? 10);
        return ResponseHelper::sendResponse($data->get(), 'Success!');
    }

    public function detail($id)
    {
        $data = $this->model::whereId($id)->first();
        if(!$data) return ResponseHelper::sendError('Failed to get data!');

        return ResponseHelper::sendResponse($data, 'Success!');
    }

    public function save(Request $request)
    {
        // AUTO :: GROUP LABEL
        if(@$request->group_key && !@$request->group_label) 
            $request['group_label'] = ucwords(@$request->group_key);

        // AUTO :: ACTION LABEL
        if(@$request->action_key && !@$request->action_label) 
            $request['action_label'] = ucwords(@$request->action_key);

        // AUTO :: PERMISSION KEY
        $request['permission_key'] = $request->action_key;
        if(@$request->group_key) $request['permission_key'] = $request->group_key.'.'.$request['permission_key'];

        $data = \DB::transaction(function () use ($request) {
            $model = $this->model::whereId(@$request->id)->first() ?? new $this->model;
            $rules = (@$request->id ? $model->ruleOnUpdate() : $model->rule());

            \Validator::make($request->except('id'), $rules)->validate();

            if(@$request->id){
                $model->update($request->except('id'));
            }else{
                $model = $this->model::updateOrCreate($request->all());
            }

            return $model;
        });

        if(!$data) return ResponseHelper::sendError(trans('Failed to save data, please try again.'));
        return ResponseHelper::sendResponse($data, trans('Data has been saved!'));
    }

    public function delete($id)
    {
        $data = $this->model::whereId($id)->first();
        if(!$data) return ResponseHelper::sendError('Failed to get data!');
        
        // DELETING PERMISSIONS
        $data->delete();
        
        // DELETING ROLE PERMISSIONS (ACL)
        RolePermission::where('permission_id', $id)->delete();

        // NULLING MENUS PERMISSION ID
        Menu::where('permission_id', $id)->update(['permission_id' => null]);

        return ResponseHelper::sendResponse([], 'Data has been deleted!');
    }

    public function editGroup(Request $request)
    {
        // VALIDATING
        \Validator::make($request->all(), ['edit_group_key' => 'required'], ['edit_group_key.required' => 'The group key field is required'])->validate();

        // AUTO :: GROUP LABEL
        $groupLabel = @$request->edit_group_label;
        if(@$request->edit_group_key && !@$request->edit_group_label) 
            $groupLabel = ucwords(@$request->edit_group_key);

        $datas = $this->model::whereNotNull('group_key')->whereGroupKey(@$request->edit_group_old_key)->get();
        if($datas->count() == 0) return ResponseHelper::sendError('Failed to get data!');

        // UPDATE ALL ACTION
        foreach ($datas as $data) {
            $permissionKey = $request->edit_group_key . '.' . $data->action_key;

            $data->update([
                'group_key' => $request->edit_group_key,
                'group_label' => $groupLabel,
                'permission_key' => $permissionKey,
            ]);
        }

        return ResponseHelper::sendResponse($this->model::whereGroupKey(@$request->edit_group_old_key)->get(), trans('Data has been saved!'));

    }

    public function deleteGroup(Request $request)
    {
        $data = $this->model::whereNotNull('group_key')->whereGroupKey(@$request->group_key)->get()->pluck('id')->toArray();
        if(count($data) == 0) return ResponseHelper::sendError('Failed to get data!');

        // DELETING PERMISSIONS
        $this->model::whereNotNull('group_key')->whereGroupKey(@$request->group_key)->delete();

        // DELETING ROLE PERMISSIONS (ACL)
        RolePermission::whereIn('permission_id', $data)->delete();

        // NULLING MENUS PERMISSION ID
        Menu::whereIn('permission_id', $data)->update(['permission_id' => null]);

        return ResponseHelper::sendResponse($data, trans('Data has been deleted!'));
    }

    public function discover(Request $request)
    {
        // dd(collect(Route::getRoutes())->whereNotNull('action.acl_group')->values()->all());
        // dd(@$request->import);
        // return ResponseHelper::sendResponse([collect(Route::getRoutes())->whereNotNull('action.acl_group')->values()->all()], 'OK');

        $result = [];

        foreach (@collect(Route::getRoutes())->whereNotNull('action.acl_group')->values()->all() ?? [] as $route) {
            
            $item = collect($route)->only(['uri', 'methods', 'action'])->toArray();
            $data = [];

            // URL
            $data['url'] = $item['uri'];
            $data['url_method'] = $item['methods'][0];

            // GROUP
            $group = $item['action']['acl_group'];
            $data['group_label'] = is_array($group) ? implode(' ', $group) : $group;
            $data['group_key'] = str_replace(' ', '.', strtolower($data['group_label']));

            // SET RESULT ARRAY
            // if(count(@$result[$data['group_label']] ?? []) == 0) $result[$data['group_label']] = [];

            // CHECK PREFIX
            if(@$item['action']['prefix'][0] == '/') $item['action']['prefix'] = substr($item['action']['prefix'], 1);

            // ACTION
            $data['action_key'] = str_replace('/', '.', str_replace($item['action']['prefix'], '', $item['uri']));

            // CHECK PAREMETER {}
            $expRouteParam = explode('{', $data['action_key']);
            if(count($expRouteParam) > 0) $data['action_key'] = $expRouteParam[0];



            // CHECK ACTION KEY EMPTY BUT USING ALIAS --> GET LAST ACTION FROM ALIAS
            if(!@$data['action_key'] && $data['group_key']){
                $data['action_key'] = str_replace($data['group_key'].'.', '', $item['action']['as']);
                // $data['action_key'] = $data['group_key'];
            } 

            // CHECK DOT ON FIRST & LAST CHARACTER
            if(@$data['action_key'][0] == '.') $data['action_key'] = substr($data['action_key'], 1);
            if(@$data['action_key'][strlen($data['action_key'])-1] == '.') $data['action_key'] = substr_replace($data['action_key'], '', -1);

            $data['action_label'] = ucwords(str_replace('.', ' ', str_replace('-', ' ', $data['action_key'])));

            // PERMISSION
            $data['permission_key'] = $data['group_key'] . '.' . $data['action_key'];

            // CHECK EXISTED PERMISSIONS
            $checkByURL = $this->model::whereUrl($item['uri'])->first();
            $checkByPermissionKey = $this->model::wherePermissionKey($data['permission_key'])->first();

            // CHECK IGNORE BY ROUTES
            $checkIgnoreRoute = false;
            // if(@$item['action']['acl_ignore']){
            //     $ignores = is_array($item['action']['acl_ignore']) ? $item['action']['acl_ignore'] : [$item['action']['acl_ignore']]; 
                
            //     if(in_array($data['action_key'], $ignores)) $checkIgnoreRoute = true;
            // }
            if(@$item['action']['acl_ignore']) $checkIgnoreRoute = true;

            // ADDING TO LIST & IMPORTING
            if(!@$checkByURL && !@$checkByPermissionKey && !@$checkIgnoreRoute){

                // IMPORT
                if(in_array($data['group_label'], @$request->import ?? [])){
                    $this->model::create($data);
                }

                // DISCOVER LIST
                $result[$data['group_label']][] = [
                    'url_method' => $data['url_method'],
                    'action_key' => $data['action_key'],
                    'prefixes' => $item['action']['prefix'],
                    'abc' => str_replace($item['action']['prefix'], '', $item['uri']),
                    'uri' => $item['uri'],
                ];
            }
        }
        
        return ResponseHelper::sendResponse($result, (@$request->import ? trans('Data has been imported') : trans('Success')));
    }

}