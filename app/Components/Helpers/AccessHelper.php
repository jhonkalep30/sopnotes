<?php

namespace App\Components\Helpers;

use App\Components\Helpers\ResponseHelper;
use App\Models\ACL\Permission;
use App\Models\ACL\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AccessHelper {

    public static function checkByRoutes($route)
    {
        $result = true;

        $permission = Permission::where('permissions.url_method', $route['methods'][0])->where('permissions.url', $route['uri'])->first();

        if($permission){
            if(!(@RolePermission::wherePermissionId($permission->id)->whereRoleId(@\Auth::user()->role_id)->first()->access ?? 0)){
                $result = false;
            }
        }

        return $result;
    }

    public static function checkByKey($key = null, $withResponse = false)
    {
        if(!$key) return false;

        $result = true;

        $permission = Permission::where('permissions.permission_key', $key)->first();

        if(@\Auth::user()->role->is_master){
            $result = true;
        }else{
            if($permission){
                if(!(@RolePermission::wherePermissionId($permission->id)->whereRoleId(@\Auth::user()->role_id)->first()->access ?? 0)){
                    $result = false;
                }
            }
        }

        if($withResponse && !$result) return ResponseHelper::getError();

        return $result;
    }

    public static function checkByUrl($url = null, $withResponse = false)
    {
        if(!$url) return false;

        $result = true;

        $permission = Permission::where('permissions.url', $url)->first();

        if(@\Auth::user()->role->is_master){
            $result = true;
        }else{
            if($permission){
                if(!(@RolePermission::wherePermissionId($permission->id)->whereRoleId(@\Auth::user()->role_id)->first()->access ?? 0)){
                    $result = false;
                }
            }
        }

        if($withResponse && !$result) return ResponseHelper::getError();

        return $result;
    }

    public static function getKeyByUrl($customKey = '')
    {
        $route = collect(request()->route())->toArray();

        // GROUP KEY
        $group = $route['action']['acl_group'];
        $data['group_label'] = is_array($group) ? implode(' ', $group) : $group;
        $data['group_key'] = str_replace(' ', '.', strtolower($data['group_label']));

        // CHECK PREFIX
        if($route['action']['prefix'][0] == '/') $route['action']['prefix'] = substr($route['action']['prefix'], 1);;

        // ACTION
        $data['action_key'] = str_replace('/', '', str_replace($route['action']['prefix'], '', $route['uri']));

        // CHECK PAREMETER {}
        $expRouteParam = explode('{', $data['action_key']);
        if(count($expRouteParam) > 0) $data['action_key'] = $expRouteParam[0];

        // CHECK ACTION KEY EMPTY BUT USING ALIAS --> GET LAST ACTION FROM ALIAS
        if(!@$data['action_key'] && $data['group_key']){
            $data['action_key'] = str_replace($data['group_key'].'.', '', $route['action']['as']);
        } 

        $data['action_label'] = ucwords($data['action_key']);

        // PERMISSION
        return $data['group_key'] . '.' . ($customKey ? $customKey : $data['action_key']);
    }

}