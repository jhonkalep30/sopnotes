<?php

use App\Http\Controllers\ACL\UserController;
use App\Http\Controllers\Auth\MobileAuthenticationController;
use App\Http\Controllers\JobTraceController;
use App\Http\Controllers\NPS\StagingDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [MobileAuthenticationController::class, 'login']);
Route::post('nps/staging-data/{type}', [StagingDataController::class,'createData'])->middleware('public.api');
