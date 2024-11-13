<?php

use App\Components\Helpers\AccessHelper;
use App\Models\System\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Vinkla\Hashids\Facades\Hashids;

/*
|--------------------------------------------------------------------------
| Global Helpers
|--------------------------------------------------------------------------
|
| You can call function name on any dimension: Controllers, Model, event Blade
|
*/

if(!function_exists('get_file_size')){
    function get_file_size($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');   

        return $size > 0 ? round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)] : 0;
    }
}

if(!function_exists('uniqueFileName')){
    function uniqueFileName($file = null)
    {
        if(!$file) return '';

        $original = $file->getClientOriginalName();

        $filename = pathinfo($original, PATHINFO_FILENAME);
        $filename .= ' (@'.Carbon::now()->format('YmdHis').')';
        $filename .= '.'.pathinfo($original, PATHINFO_EXTENSION);

        return $filename;
    }
}

if(!function_exists('access')){
    function access($key = '')
    {
        return AccessHelper::checkByKey($key);
    }
}

if(!function_exists('master')){
    function master()
    {
        return @\Auth::user()->role->is_master;
    }
}


if(!function_exists('homeRedirect')){
    function homeRedirect()
    {
        if(!@\Auth::user()) return config('acl.no_auth_redirect') ?? '/';

        $home = '';
        foreach(config('acl.home_priority') as $prior){
            if($home != '') continue;
            if(AccessHelper::checkByUrl($prior)) $home = $prior;
        }


        if($home == '') $home = 'unaccessible';
        // if($home == '') return abort(404);
        return $home;
    }
}

if(!function_exists('setting')){
    function setting($type = '')
    {
        return @Setting::where('type', $type)->first()->value;
    }
}

if(!function_exists('upload_file')){
    function upload_file($file, $prefix, $isPublic = true)
    {
        $folderPath = ($isPublic ? 'public/' : '') . $prefix;

        if(!Storage::exists($folderPath)) {
            // Storage::makeDirectory($folderPath, 0777, true);
            mkdir('storage/'.$prefix, 0755, true);
        }

        $fileName = $file->storeAs($folderPath, uniqueFileName($file));
        return asset(Storage::url($fileName));
    }
}

if(!function_exists('delete_file')){
    function delete_file($file_path)
    {
        // return asset(\Storage::url('/'));
        // return storage_path('app\public\template');
        
        $file_paths = $file_path;
        if(!is_array($file_path)){
            $file_paths = [$file_path];
        }

        try{
            Storage::delete($file_paths);
        }catch(\Exception $ex){
            \Log::info($ex);
        }
    }
}

if(!function_exists('random_string')){
    function random_string($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
           $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}

if(!function_exists('migration_created_updated_by')){
    function migration_created_updated_by(&$table)
    {
        // CREATED BY & UPDATE BY
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();

        $table->foreign('created_by')->references('id')->on('users');
        $table->foreign('updated_by')->references('id')->on('users');
    }
}

if(!function_exists('encrypt_id')){
    function encrypt_id($id)
    {
        return Hashids::encode($id);
    }
}

if(!function_exists('decrypt_hash')){
    function decrypt_hash($hashText)
    {
        $decode = Hashids::decode($hashText);
        if(count($decode) == 0) abort(404);
        return $decode[0];
    }
}