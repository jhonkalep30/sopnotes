<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class PublicApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->bearerToken() != null){
            if(Hash::check(env('PUBLIC_API_KEY_PHRASE'), $request->bearerToken())){
                return $next($request);
            }

            return response()->json(['success' => false,'message' => 'Token Invalid!']);
        }

        return response()->json(['success' => false,'message' => 'Header Authentication is Required!']);
    }
}
