<?php

namespace App\Http\Middleware;

use App\Components\Helpers\AccessHelper;
use App\Components\Helpers\ResponseHelper;
use App\Models\ACL\Permission;
use App\Models\ACL\RolePermission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ACL
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // IF ACL DISABLED
        if(env('ACL_DISABLED', false)) return $next($request);

        // MASTER NEXT
        if(@\Auth::user()->role->is_master) return $next($request);

        $access = true;
        $route = collect(request()->route());

        // IF ACL ACTIVATED
        if(@$route['action']['acl_group']){

            if(@$route['action']['acl_with']){
                // GET 'ACL WITH' KEY
                $access = AccessHelper::checkByKey(AccessHelper::getKeyByUrl(@$route['action']['acl_with']));
            }else{
                $access = AccessHelper::checkByRoutes($route);
            }

        }

        return $access ? $next($request) : ResponseHelper::getError();
    }
}
