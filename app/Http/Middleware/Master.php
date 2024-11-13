<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Components\Helpers\ResponseHelper;
use Symfony\Component\HttpFoundation\Response;

class Master
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!@\Auth::user()->role->is_master)
            return $request->expectsJson() ? 
                ResponseHelper::sendError('You don\'t have permission to access this request') : 
                abort(404);

        return $next($request);
    }
}
