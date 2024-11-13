<?php

use App\Http\Controllers\Setting\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'setting',
    'middleware' => 'master',
    'controller' => SettingController::class,
    'as' => 'setting.'
], function(){

    // WEB
    Route::group(['middleware' => ['web', 'auth']], function(){

        // VIEW
        Route::get('', ['as' => 'view', 'uses' => 'view']);

    });

    // API
    Route::group(['middleware' => ['api', 'auth:sanctum']], function(){

        // SAVE
        Route::post('save', ['as' => 'save', 'uses' => 'save']);

        // WEBSITE CONFIGURATION
        Route::post('website-config', ['as' => 'website-config', 'uses' => 'websiteConfiguration']);

    });
    
});

/*
|--------------------------------------------------------------------------
| End Routing ... :)
|--------------------------------------------------------------------------
|
*/