<?php

use App\Http\Controllers\ACL\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'menu',
    'middleware' => 'master',
    'controller' => MenuController::class,
    'as' => 'menu.'
], function(){

    // WEB
    Route::group(['middleware' => ['web', 'auth']], function(){

        // VIEW
        Route::get('', ['as' => 'view', 'uses' => 'view']);

    });

    // API
    Route::group(['middleware' => ['api', 'auth:sanctum']], function(){

        // READ
        Route::post('list', ['as' => 'list', 'uses' => 'list']);
        Route::post('data', ['as' => 'data', 'uses' => 'data']);
        Route::get('detail/{id}', ['as' => 'detail', 'uses' => 'detail']);
        
        // CREATE & UPDATE
        Route::post('save', ['as' => 'save', 'uses' => 'save']);

        // DELETE
        Route::delete('delete/{id}', ['as' => 'delete', 'uses' => 'delete']);

        // HIDE
        Route::get('hide/{id}', ['as' => 'hide', 'uses' => 'hide']);

    });
    
});

/*
|--------------------------------------------------------------------------
| End Routing ... :)
|--------------------------------------------------------------------------
|
*/