<?php

use App\Http\Controllers\NPS\StagingDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'staging-data',
    'controller' => StagingDataController::class,
    'acl_group' => 'Staging Data',
    'as' => 'staging-data.'
], function(){

    // WEB
    Route::group(['middleware' => ['web', 'auth']], function(){

        // VIEW
        Route::get('', ['as' => 'view', 'uses' => 'view']);

    });

    // API
    Route::group(['middleware' => ['api', 'auth:sanctum']], function(){

        // READ
        Route::group(['acl_ignore' => true, 'acl_with' => 'view'], function(){
            Route::post('list', ['as' => 'list', 'uses' => 'list']);
            Route::post('datatable', ['as' => 'datatable', 'uses' => 'datatable']);
        });
        
        // CREATE & UPDATE
        Route::post('save', ['as' => 'save', 'uses' => 'save']);

        // DELETE
        Route::delete('delete/{id}', ['as' => 'delete', 'uses' => 'delete']);

    });
    
});

/*
|--------------------------------------------------------------------------
| End Routing ... :)
|--------------------------------------------------------------------------
|
*/