<?php

use App\Http\Controllers\Reference\SOPTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Routing ... :3
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => 'reference/sop-type',
    'controller' => SOPTypeController::class,
    'acl_group' => 'Jenis SOP',
    'as' => 'sop.type.'
], function(){

    // WEB
    Route::group(['middleware' => ['web', 'auth']], function(){

        // VIEW
        Route::get('', ['as' => 'view', 'uses' => 'view']);

        // CREATE PAGE (FORM)
        Route::group(['acl_ignore' => true, 'acl_with' => 'save'], function(){
            Route::get('create', ['as' => 'create', 'uses' => 'create']);
        });

        // SHOW PAGE (FORM)
        Route::group(['acl_ignore' => true, 'acl_with' => 'view'], function(){
            Route::get('show/{id}', ['as' => 'show', 'uses' => 'show']);
        });

        // DOWNLOAD TEMPLATE (FOR IMPORT)
        Route::group(['acl_ignore' => true, 'acl_with' => 'view'], function(){
            Route::get('download-template', ['as' => 'download-template', 'uses' => 'downloadTemplate']);
        });

    });

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

        // IMPORT
        Route::post('import', ['as' => 'import', 'uses' => 'processingImport']);

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