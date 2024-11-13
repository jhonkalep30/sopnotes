<?php

use App\Http\Controllers\SOP\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'question',
    'controller' => QuestionController::class,
    'acl_group' => 'Question',
    'as' => 'question.'
], function(){

    // API
    Route::group(['middleware' => ['api', 'auth:sanctum']], function(){

        // READ
        Route::group(['acl_ignore' => true, 'acl_with' => 'view'], function(){
            Route::post('list', ['as' => 'list', 'uses' => 'list']);
            Route::get('detail/{id}', ['as' => 'detail', 'uses' => 'detail']);
        });
        
        // CREATE & UPDATE
        Route::post('save', ['as' => 'save', 'uses' => 'save']);
        Route::post('bulk-create-answer', ['as' => 'bulk-create-answer', 'uses' => 'bulkCreateAnswer']);

        // DELETE
        Route::delete('delete/{id?}', ['as' => 'delete', 'uses' => 'delete']);

    });
    
});

/*
|--------------------------------------------------------------------------
| End Routing ... :)
|--------------------------------------------------------------------------
|
*/