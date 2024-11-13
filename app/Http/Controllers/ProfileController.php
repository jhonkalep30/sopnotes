<?php

namespace App\Http\Controllers;

use App\Components\Helpers\ResponseHelper;
use App\Models\ACL\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; 
use Carbon\Carbon;
use Storage;

class ProfileController extends Controller
{
    public function view()
    {
        return view('setting.profile');
    }

    public function get()
    {
        $data = User::whereId(\Auth::user()->id)->with('role')->first();
        if(!$data) return ResponseHelper::sendError('User not found');

        return ResponseHelper::sendResponse($data, 'Success');
    }

    public function changePassword(Request $request)
    {
        // CHECK OLD PASSWORD
        $check = Hash::check($request->old_password, \Auth::user()->password);
        if(!$check) return ResponseHelper::sendError('Current password not doesn\'t match, please check again');

        // CHECK NEW & CONFIRMED
        if($request->new_password != $request->confirm_password) return ResponseHelper::sendError('Password confirmation not doesn\'t match, please check again');

        \Auth::user()->update(['password' => bcrypt($request->new_password)]);

        return ResponseHelper::sendResponse([], 'Password has been changed');
    }

    public function update(Request $request)
    {
        $request->validate(['name' => 'required']);

        \Auth::user()->update($request->only(['name', 'nik', 'tanggal_lahir', 'phone', 'alamat_ktp', 'alamat_domisili', 'jenis_kelamin', 'agama', 'pekerjaan', 'pendidikan']));

        // PHOTO URL
        if(isset($request->photo_url_remove)){

            $filepath = str_replace(url('/').'/storage', 'public', \Auth::user()->photo_url);

            // DELETING FILE
            Storage::delete($filepath);

            \Auth::user()->update(['photo_url' => null]);
        }else{
            if(@$request->file('photo_url')){

                // DELETE PREVIOUS FILE
                $filepath = str_replace(url('/').'/storage', 'public', \Auth::user()->photo_url);

                // DELETING FILE
                Storage::delete($filepath);

                // $fileName = $request->file('photo_url')->storeAs(
                //     'public/users/avatar', uniqueFileName($request->file('photo_url'))
                // );

                // $url = asset(Storage::url($fileName));

                \Auth::user()->update(['photo_url' => upload_file($request->file('photo_url'), 'users/avatar')]);
            }
        }

        $data = User::whereId(\Auth::user()->id)->with('role')->first();

        return ResponseHelper::sendResponse($data, 'Your profile has been updated');
    }
}
