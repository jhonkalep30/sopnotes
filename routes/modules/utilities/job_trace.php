<?php

use App\Http\Controllers\JobTraceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'job-trace',
    'controller' => JobTraceController::class,
    'as' => 'job-trace.'
], function(){

    // WEB
    Route::group(['middleware' => ['web', 'auth']], function(){

        //

    });

    // API
    Route::group(['middleware' => ['api', 'auth:sanctum']], function(){

        // READ
        Route::post('datatable', ['as' => 'datatable', 'uses' => 'datatable']);
        
    });
    
});

/*
|--------------------------------------------------------------------------
| End Routing ... :)
|--------------------------------------------------------------------------
|
*/