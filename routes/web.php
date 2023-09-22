<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/getSurveyorsName/{id}', [App\Http\Controllers\AssetsController::class, 'getSurveyorName']);

// image download 
Route::get('/downloadImages/{id}', [App\Http\Controllers\AssetsController::class, 'downloadImages']);
// end 

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/upload', [App\Http\Controllers\HomeController::class, 'upload'])->name('upload');
Route::get('/jobs', [App\Http\Controllers\HomeController::class, 'jobs']);
Route::get('/store-jobs', [App\Http\Controllers\HomeController::class, 'storejobs']);
Route::get('/add-asset', [App\Http\Controllers\AssetsController::class, 'create']);
Route::post('/uploadimages', [App\Http\Controllers\AssetsController::class, 'uploadimages']);
Route::get('/getUserRole', [App\Http\Controllers\AssetsController::class, 'getUserRole']);
Route::post('/deleteImage/{id}', [App\Http\Controllers\AssetsController::class, 'deleteImage']);
Route::get('/edit/{id}', [App\Http\Controllers\HomeController::class, 'edit']);
Route::get('/edituser/{id}', [App\Http\Controllers\HomeController::class, 'edituser']);
Route::get('/print-report/{id}', [App\Http\Controllers\AssetsController::class, 'printReport']);
Route::get('/editsurvey/{id}', [App\Http\Controllers\AssetsController::class, 'editsurvey']);
Route::get('/survey-images/{id}', [App\Http\Controllers\AssetsController::class, 'surveyimages']);
Route::get('/survey-generalinfo/{id}', [App\Http\Controllers\AssetsController::class, 'surveygeneralinfo']);
Route::get('/survey-editinfo/{id}', [App\Http\Controllers\AssetsController::class, 'surveyeditinfo']);
Route::get('/survey-assetinfo/{id}', [App\Http\Controllers\AssetsController::class, 'surveyassetinfo']);
Route::get('/getstatsall', [App\Http\Controllers\AssetsController::class, 'getstatsall']);
Route::get('/compressImage/{id}', [App\Http\Controllers\AssetsController::class, 'compressImage']);
Route::post('/storeAssetsByFar', [App\Http\Controllers\AssetsController::class, 'storeAssetsByFar']);
    // Route::get('/getstatsforadmin', [App\Http\Controllers\AssetsController::class, 'getstatsforadmin']);

Route::get('/users', [App\Http\Controllers\HomeController::class, 'users']);
Route::get('/updatetag', [App\Http\Controllers\HomeController::class, 'updatetag']);
Route::get('/statistics', [App\Http\Controllers\HomeController::class, 'statistics']);
Route::get('/user-create', [App\Http\Controllers\HomeController::class, 'userCreate']);
Route::get('/getImageCount/{id}', [App\Http\Controllers\AssetsController::class, 'getImageCount']);
//  image order 
Route::put('/updateOrder/{id}', [App\Http\Controllers\AssetsController::class, 'updateOrder']);
// end 

Route::get('/getLocationFromDatabase/{id}', [App\Http\Controllers\AssetsController::class, 'getLocationFromDatabase']);


Route::post('/completedJob/{id}', [App\Http\Controllers\AssetsController::class, 'completedJob']);
Route::post('/cancelledJob/{id}', [App\Http\Controllers\AssetsController::class, 'cancelledJob']);
// Route::get('/getlocation', [App\Http\Controllers\AssetsController::class, 'getlocation']);

Route::post('/signin',  [App\Http\Controllers\AssetAppController::class, 'login']);

