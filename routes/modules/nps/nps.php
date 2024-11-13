<?php

use App\Http\Controllers\NPS\NetPromoterScoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'nps',
    'controller' => NetPromoterScoreController::class,
    'acl_group' => 'Net Promoter Score',
    'as' => 'nps.'
], function(){

    // WEB
    Route::group(['middleware' => ['web', 'auth']], function(){

        // VIEW
        Route::get('', ['as' => 'view', 'uses' => 'view']);

    });

    // FOR CUSTOMER
    Route::get('survey', ['as' => 'survey.view', 'uses' => 'surveyView']);
    Route::post('survey', ['as' => 'survey.save', 'uses' => 'surveySave']);

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

        // OUTLET SUMMARY
        Route::post('outlet-summary', ['as' => 'outlet-summary', 'uses' => 'outletSummary']);

        // EXPORT
        Route::post('export', ['as' => 'export', 'uses' => 'processingExport']);
    });
    
});

/*
|--------------------------------------------------------------------------
| End Routing ... :)
|--------------------------------------------------------------------------
|
*/