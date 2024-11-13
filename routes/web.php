<?php

use App\Http\Controllers\ACL\UserController;
use App\Http\Controllers\BlankController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home Routes
|--------------------------------------------------------------------------
|
|
*/

Route::get('/', function () {
    return redirect()->route('login');
    // return view('home');
})->name('home')->middleware('guest');

// FRONT PAGE & DASHBOARD
Route::group([
    'acl_group' => 'Pages',
    'middleware' => 'auth'
], function(){

    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('admin/dashboard', function () {
        return view('admin-dashboard');
    })->name('admin.dashboard');
    
});

// NO ACCESS FRONT OR BACK
Route::get('/unaccessible', function () {
    return view('errors.422');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// PROFILE - LARAVEL BREEZE
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// BLANK
Route::group([
    'controller' => BlankController::class,
], function(){
    Route::get('blank', ['as' => 'blank.view', 'uses' => 'view']);

    // UPPERCASE TITLE
    Route::group([
        // 'title_uppercase' => 1
    ], function(){
        // SOP 
        Route::get('sop/sop-frekuensi', ['as' => 'sop.sop-frekuensi.view', 'uses' => 'view']);
        Route::get('sop/sop-biasa', ['as' => 'sop.sop-biasa.view', 'uses' => 'view']);

        // ENTRIES
        Route::get('entries/sop-entries', ['as' => 'entries.sop-entries.view', 'uses' => 'view']);

        // REFERENCE
        // Route::get('reference/jenis-sop', ['as' => 'reference.jenis-sop.view', 'uses' => 'view']);
        // Route::get('reference/jenis-classifier', ['as' => 'reference.jenis-classifier.view', 'uses' => 'view']);
        // Route::get('reference/outlet', ['as' => 'reference.outlet.view', 'uses' => 'view']);
        Route::get('reference/location', ['as' => 'reference.location.view', 'uses' => 'view']);

        // ASSETS
        Route::get('web/assets/images', ['as' => 'assets.images.view', 'uses' => 'view']);
        Route::get('web/assets/files', ['as' => 'assets.files.view', 'uses' => 'view']);
        Route::get('web/assets/videos', ['as' => 'assets.videos.view', 'uses' => 'view']);

    });

});

// NO ACCESS FRONT OR BACK
Route::get('/unaccessible', function () {
    return view('errors.422');
});

Route::get('/123', function () {

    $alphabetRange = range('A','Z');

    foreach(range('A', 'Z') as $first){
        foreach(range('A', 'Z') as $second){
            array_push($alphabetRange, $first.$second);
        }
    }

    $string = "\"INSERT INTO users VALUES (";

    for($i=1;$i<=83;$i++){
        if(in_array($alphabetRange[$i], ['K', 'Y', 'AM', 'P', 'J'])){
            $string .= "\"&IF(".$alphabetRange[$i]."2 = \"\"; \"NULL\"; \"'\"&".$alphabetRange[$i]."2&\"'\")&\", ";
        }else{
            $string .= "'\"&".$alphabetRange[$i]."2&\"', ";
        }
    }

    $string .= ");\"";
    return $string;
});

// Route::get('/nps', function () {
//     return view('survey');
// });

// Route::get('/nps-finish', function () {
//     return view('survey-finish');
// });

require __DIR__.'/auth.php';
