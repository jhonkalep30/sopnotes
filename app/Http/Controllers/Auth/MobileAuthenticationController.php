<?php

namespace App\Http\Controllers\Auth;

use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\ACL\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MobileAuthenticationController extends Controller
{
    public function login(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);
     
        $user = User::where('email', @$request->email)->first();
     
        if (! $user || ! Hash::check(@$request->password, @$user->password)) {
            // return ResponseHelper::sendError('The provided credentials are incorrect.');
            return response()->json(['message' => 'The provided credentials are incorrect.']);
        }

        $data = collect($user)->put('token',$user->createToken($request->email)->plainTextToken);
     
        // return ResponseHelper::sendResponse('Login success!',$data);
        return response()->json($data);

    }
}
