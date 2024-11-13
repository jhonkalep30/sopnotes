<?php

use App\Http\Controllers\SOP\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'sop',
    'controller' => SurveyController::class,
    'acl_group' => 'SOP',
    'as' => 'sop.'
], function(){

    // WEB
    Route::group(['middleware' => ['web', 'auth']], function(){

        // VIEW
        Route::get('', ['as' => 'view', 'uses' => 'view']);
        Route::get('form', ['as' => 'form', 'uses' => 'form']);

        Route::get('export-unread-users/{id?}', ['as' => 'export.unread-users', 'uses' => 'exportUnreadUsers']);
    });

    // API
    Route::group(['middleware' => ['api', 'auth:sanctum']], function(){

        // READ
        Route::group(['acl_ignore' => true, 'acl_with' => 'view'], function(){
            Route::post('list', ['as' => 'list', 'uses' => 'list']);
            Route::post('datatable', ['as' => 'datatable', 'uses' => 'datatable']);
            Route::get('detail/{id}', ['as' => 'detail', 'uses' => 'detail']);
            Route::get('unread/{id}', ['as' => 'unread', 'uses' => 'unread']);
        });
        
        // CREATE & UPDATE
        Route::post('save', ['as' => 'save', 'uses' => 'save']);
        Route::post('publish/{id}', ['as' => 'publish', 'uses' => 'publish']);

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