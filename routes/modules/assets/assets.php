<?php

use App\Http\Controllers\Assets\AssetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'asset',
    'controller' => AssetController::class,
    'acl_group' => 'Assets',
    'as' => 'asset.'
], function(){
    // API
    Route::group(['middleware' => ['api', 'auth:sanctum']], function(){

        // READ
        Route::group(['acl_ignore' => true, 'acl_with' => 'view'], function(){
            Route::post('list', ['as' => 'list', 'uses' => 'list']);
            Route::post('datatable', ['as' => 'datatable', 'uses' => 'datatable']);
            Route::get('detail/{id}', ['as' => 'detail', 'uses' => 'detail']);
        });
        
        // CREATE & UPDATE
        Route::post('save', ['as' => 'save', 'uses' => 'save']);

        // DELETE
        Route::delete('delete/{id}', ['as' => 'delete', 'uses' => 'delete']);

    });

    // WEB
    Route::group(['middleware' => ['web', 'auth']], function(){

        // VIEW
        Route::get('images', ['as' => 'viewImages', 'uses' => 'viewImages']);
        Route::get('files', ['as' => 'viewFiles', 'uses' => 'viewFiles']);

    });
    
});

/*
|--------------------------------------------------------------------------
| End Routing ... :)
|--------------------------------------------------------------------------
|
*/