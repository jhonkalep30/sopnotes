<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Setting\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

// PROFILE
Route::group(['prefix' => 'profile'], function(){

    // WEB
    Route::group(['middleware' => ['web', 'auth']], function(){
        Route::get('', [ProfileController::class, 'view'])->name('profile.view');
    });

    // API
    Route::group(['middleware' => ['api', 'auth:sanctum']], function(){
        Route::get('get', [ProfileController::class, 'get'])->name('profile.get');
        Route::post('change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::post('update', [ProfileController::class, 'update'])->name('profile.update');
    });

});

/*
|--------------------------------------------------------------------------
| End Routing ... :)
|--------------------------------------------------------------------------
|
*/