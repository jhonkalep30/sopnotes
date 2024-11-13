<?php

use App\Http\Controllers\ACL\PermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'permission',
    'controller' => PermissionController::class,
    'as' => 'permission.'
], function(){

    // WEB
    Route::group(['middleware' => ['web', 'auth', 'master']], function(){
        Route::get('', ['as' => 'view', 'uses' => 'view']);
    });

    // API
    Route::group(['middleware' => ['api', 'auth:sanctum', 'master']], function(){

        // READ
        Route::post('/list', ['as' => 'list', 'uses' => 'list']);
        Route::post('/data', ['as' => 'data', 'uses' => 'data']);
        Route::get('/detail/{id}', ['as' => 'detail', 'uses' => 'detail']);

        // CREATE & UPDATE
        Route::post('/save', ['as' => 'save', 'uses' => 'save']);

        // DELETE
        Route::delete('/delete/{id}', ['as' => 'delete', 'uses' => 'delete']);

        // GROUP
        Route::post('/edit-group', ['as' => 'edit-group', 'uses' => 'editGroup']);
        Route::post('/delete-group', ['as' => 'delete-group', 'uses' => 'deleteGroup']);

        // DISCOVER
        Route::post('discover', ['as' => 'discover', 'uses' => 'discover']);
    });
    
});

/*
|--------------------------------------------------------------------------
| End Routing ... :)
|--------------------------------------------------------------------------
|
*/