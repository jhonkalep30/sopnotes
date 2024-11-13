<?php

namespace App\Http\Controllers\ACL;

use App\Components\Filters\ACL\RoleFilter;
use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\ACL\Permission;
use App\Models\ACL\Role;
use App\Models\ACL\RolePermission;
use App\Models\ACL\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RoleController extends Controller
{
    protected $model = Role::class;

    /**
     * Display a listing of the resource.
     */
    public function view()
    {
        return view('acl.role.index');
    }

    public function list(RoleFilter $filters)
    {
        return $this->model::filter($filters)->paginate(10);
    }

    public function render()
    {
        $result = [];
        foreach ($this->model::whereIsMaster(0)->get() as $role) {
            $detail = [];
            $detail['id'] = $role->id;
            $detail['name'] = $role->name;
            $detail['permissions'] = [];
            // $detail['test'] = [];

            // GROUP PERMISSIONS
            $access = RolePermission::whereRoleId($role->id)->whereAccess(1)->pluck('permission_id')->toArray();
            $groupKeys = array_unique(Permission::whereIn('id', $access)->whereNotNull('group_key')->get()->pluck('group_label', 'group_key')->toArray());
            foreach ($groupKeys as $groupKeyIndex => $groupKeyLabel) {
                
                $text = 'Some';

                // CHECK
                $permissionIds = Permission::leftJoin('role_permissions', 'permissions.id', 'role_permissions.permission_id')
                                    ->where('permissions.group_key', $groupKeyIndex)
                                    ->where(function($q) use ($role){
                                        $q->where(function($q2) use ($role){
                                            $q2->where('role_permissions.role_id', $role->id);
                                            $q2->where('role_permissions.access', 1);
                                        });

                                        // $q->orWhereNull('role_permissions.permission_id');
                                    })
                                    ->get()->count();

                $totalPermissionIds = Permission::where('permissions.group_key', $groupKeyIndex)->get()->count();

                if($permissionIds == $totalPermissionIds) $text = 'All';
                $text .= ' '.$groupKeyLabel.' Features';

                // $detail['test'][] = [
                //     'group_key' => $groupKeyIndex,
                //     'role_id' => $role->id,
                //     'access 0' => $permissionIds,
                // ];

                // $text = Permission::leftJoin('role_permissions', 'permissions.id', 'role_permissions.permission_id')
                //                     ->where('permissions.group_key', $groupKeyIndex)
                //                     ->where(function($q) use ($role){
                //                         $q->where(function($q2) use ($role){
                //                             $q2->where('role_permissions.role_id', $role->id);
                //                             $q2->where('role_permissions.access', 0);
                //                         });

                //                         $q->orWhereNull('role_permissions.permission_id');
                //                     })
                //                     ->get();

                $detail['permissions'][] = $text;
            }

            // SINGLE PERMISSIONS
            $singles = Permission::whereNull('group_key')->get();
            if($singles->count() > 0){

                foreach ($singles as $single) {
                    if(RolePermission::wherePermissionId($single->id)->whereRoleId($role->id)->whereAccess(1)->first()){
                        $detail['permissions'][] = $single->action_label . ' Access';
                    }
                }

            }

            $result[] = $detail;
        }

        return ResponseHelper::sendResponse($result, 'Success!');
    }

    public function permission(Request $request)
    {
        $result = [];

        // GROUPS
        $groupKeys = array_unique(Permission::whereNotNull('group_key')->get()->pluck('group_label', 'group_key')->toArray());
        foreach ($groupKeys as $groupKeyIndex => $groupKeyLabel) {
            $permissions = Permission::whereGroupKey($groupKeyIndex)->get();

            // GET ACCESS
            foreach ($permissions as $permission) {
                $permission['access'] = 0;

                if(@$request->id){
                    $permission['access'] = @RolePermission::whereRoleId(@$request->id)->wherePermissionId($permission->id)->first()->access ?? 0;
                }
            }

            if($permissions->count() > 0){
                $result[] = [
                    'key' => $groupKeyIndex,
                    'label' => $groupKeyLabel,
                    'permissions' => $permissions->toArray()
                ];
            }
        }

        // SINGLE
        $singlePermissions = Permission::whereNull('group_key')->get();

        // GET ACCESS
        foreach ($singlePermissions as $singlePermission) {
            $singlePermission['access'] = 0;

            if(@$request->id){
                $singlePermission['access'] = @RolePermission::whereRoleId(@$request->id)->wherePermissionId($singlePermission->id)->first()->access ?? 0;
            }
        }

        if($singlePermissions->count() > 0){
            $result[] = [
                'key' => '#',
                'label' => 'Non Group',
                'permissions' => $singlePermissions->toArray()
            ];
        }
        
        return ResponseHelper::sendResponse(['role' => Role::whereId(@$request->id)->first(), 'access' => $result], 'Success!');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function save(Request $request)
    {
        // return ResponseHelper::sendResponse([$request->all()], 'Success');

        // CHECK ROLE MUST BE FILLED
        if(!@$request->role) return ResponseHelper::sendError('Role cannot be empty, please check again');

        // CHECK EXISTED ROLE
        if($same = $this->model::where('id', '!=', @$request->id)->whereRaw('LOWER(name) = ?', @$request->role)->first())
            return ResponseHelper::sendError('Role already exist, please check again');

        $data = \DB::transaction(function() use($request){
            // $model = $this->model::firstOrCreate(['name' => $request->role]);

            if(@$request->id){
                $model = $this->model::whereId(@$request->id)->first();
                $model->update(['name' => @$request->role]);
            }else{
                $model = $this->model::firstOrCreate(['name' => $request->role]);
            }

            // PURGE ALL PERMISSIONS
            RolePermission::whereRoleId($model->id)->update(['access' => 0]);

            // SET PERMISSIONS
            foreach (@$request->permissions ?? [] as $permission_key) {
                if($permission = Permission::wherePermissionKey($permission_key)->first()){
                    RolePermission::updateOrCreate([
                        'role_id' => $model->id, 
                        'permission_id' => $permission->id,
                    ],[    
                        'access' => 1
                    ]);
                }
            }

            return $model;
        });

        return ResponseHelper::sendResponse($data, 'Data Has Been Saved!');
    }


    public function delete($id)
    {
        $data = $this->model::whereId($id)->first();
        if(!$data) return ResponseHelper::sendError('Failed to get data!');

        // CHECK USER
        if(User::whereRoleId($id)->first()) return ResponseHelper::sendError('Cannot delete data, some user using this role');
        
        $data->delete();

        return ResponseHelper::sendResponse([], 'Data has been deleted!');
    }

}
