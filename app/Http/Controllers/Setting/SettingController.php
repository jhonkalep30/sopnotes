<?php

namespace App\Http\Controllers\Setting;

use App\Components\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\System\Setting;
use Storage;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function view()
    {
        $websiteConfig = Setting::pluck('value', 'type')->toArray();

        return view('setting.setting', ['website_config' => $websiteConfig]);
    }

    public function save(Request $request)
    {
        return ResponseHelper::sendResponse([$request->all()], 'Success');
    }

    public function websiteConfiguration(Request $request)
    {
        // NAME
        if(@$request->website_name){
            Setting::updateOrCreate(['type' => 'website_name'], ['value' => $request->website_name]);
        }

        // DESCRIPTION
        if(@$request->website_description){
            Setting::updateOrCreate(['type' => 'website_description'], ['value' => $request->website_description]);
        }

        // LOGO
        if(@$request->file('website_logo')){
            // $fileName = $request->file('website_logo')->store('public/settings/logo');
            // $url = asset(Storage::url($fileName));

            Setting::updateOrCreate(['type' => 'website_logo'], ['value' => upload_file($request->file('website_logo'), 'settings/logo')]);
        }

        // LOGO DARK
        if(@$request->file('website_logo_dark')){
            // $fileName = $request->file('website_logo_dark')->store('public/settings/logo');
            // $url = asset(Storage::url($fileName));

            Setting::updateOrCreate(['type' => 'website_logo_dark'], ['value' => upload_file($request->file('website_logo_dark'), 'settings/logo')]);
        }

        // FAVICON
        if(@$request->file('website_favicon')){
            // $fileName = $request->file('website_favicon')->store('public/settings/favicon');
            // $url = asset(Storage::url($fileName));

            Setting::updateOrCreate(['type' => 'website_favicon'], ['value' => upload_file($request->file('website_favicon'), 'settings/favicon')]);
        }

        // FOOTER
        if(@$request->website_footer){
            Setting::updateOrCreate(['type' => 'website_footer'], ['value' => $request->website_footer]);
        }

        // ============= SURVEY =================== //

        // SURVEY LOGO
        if(@$request->file('nps_logo')){
            Setting::updateOrCreate(['type' => 'nps_logo'], ['value' => upload_file($request->file('nps_logo'), 'settings/logo')]);
        }

        // NOMOR BANTUAN
        if(@$request->nps_nomor_bantuan){
            Setting::updateOrCreate(['type' => 'nps_nomor_bantuan'], ['value' => $request->nps_nomor_bantuan]);
        }

        // LINK HADIAH
        if(@$request->nps_hadiah_link){
            Setting::updateOrCreate(['type' => 'nps_hadiah_link'], ['value' => $request->nps_hadiah_link]);
        }

        // BLAST WHATSAPP
        if(isset($request->nps_blast_whatsapp)){
            Setting::updateOrCreate(['type' => 'nps_blast_whatsapp'], ['value' => @$request->nps_blast_whatsapp ?? 0]);
        }

        return ResponseHelper::sendResponse([], 'Configuration has been saved');
    }    

}
