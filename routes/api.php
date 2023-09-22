<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:api'], function () {

    Route::get('/getTypes', [App\Http\Controllers\ListingController::class, 'getTypes']);
    Route::get('/getRefId', [App\Http\Controllers\ListingController::class, 'getRefId']);
    Route::get('/getRoles', [App\Http\Controllers\HomeController::class, 'getRoles']);
    Route::post('/addUser', [App\Http\Controllers\HomeController::class, 'addUser']);
    Route::get('/getUsers', [App\Http\Controllers\ListingController::class, 'getUsers']);
    Route::get('/getUsersListing', [App\Http\Controllers\ListingController::class, 'getUsersListing']);
    Route::get('/getRegions', [App\Http\Controllers\ListingController::class, 'getRegions']);
    Route::get('/getCity', [App\Http\Controllers\ListingController::class, 'getCity']);
    Route::get('/getBottlers', [App\Http\Controllers\ListingController::class, 'getBottlers']);
    Route::get('/getDistricts', [App\Http\Controllers\ListingController::class, 'getDistricts']);
    Route::get('/getSiteDetails', [App\Http\Controllers\ListingController::class, 'getSiteDetails']);
    Route::get('/getSites', [App\Http\Controllers\ListingController::class, 'getSites']);
    Route::get('/getCityForDashboard', [App\Http\Controllers\ListingController::class, 'getCityForDashboard']);
    Route::get('/getDistrictsForDashboard', [App\Http\Controllers\ListingController::class, 'getDistrictsForDashboard']);
    Route::get('/getsitesforadmin', [App\Http\Controllers\AssetsController::class, 'getsitesforadmin']);
    Route::get('/getassetsforadmin', [App\Http\Controllers\AssetsController::class, 'getassetsforadmin']);
    Route::get('/getListingForSites', [App\Http\Controllers\AssetsController::class, 'getListingForSites']);
    Route::get('/getRegionsForListing', [App\Http\Controllers\AssetsController::class, 'getRegionsForListing']);
    Route::get('/getRegionsForListingForApp', [App\Http\Controllers\AssetsController::class, 'getRegionsForListingForApp']);
    Route::get('/getListingForAssets', [App\Http\Controllers\AssetsController::class, 'getListingForAssets']);

    Route::post('/storeAsset', [App\Http\Controllers\AssetsController::class, 'storeAsset']);
    Route::post('/updateAsset/{id}', [App\Http\Controllers\AssetsController::class, 'updateAsset']);
    Route::post('/updateUser/{id}', [App\Http\Controllers\AssetsController::class, 'updateUser']);
    Route::post('/updatePassword/{id}', [App\Http\Controllers\AssetsController::class, 'updatePassword']);
    Route::get('/getData', [App\Http\Controllers\AssetsController::class, 'getData']);
    // Route::get('/getSurveyStats', [App\Http\Controllers\AssetsController::class, 'getSurveyStats']);
    Route::get('/getImages/{id}', [App\Http\Controllers\AssetsController::class, 'getImages']);

    Route::get('/getDataForUpdate/{id}', [App\Http\Controllers\AssetsController::class, 'getDataForUpdate']);
    Route::get('/getDataforuser/{id}', [App\Http\Controllers\AssetsController::class, 'getDataforuser']);
    
    //App Api

Route::get('/getSurveyStats', [App\Http\Controllers\AssetsController::class, 'getSurveyStats']);
Route::get('/getSurveyStatsForSurveyor', [App\Http\Controllers\AssetsController::class, 'getSurveyStatsForSurveyor']);


    Route::get('/getSurveys/{id}', [App\Http\Controllers\AssetAppController::class, 'getSurveys']);
    Route::get('/getSurveysByStatus/{id}', [App\Http\Controllers\AssetAppController::class, 'getSurveysByStatus']);
    Route::get('/getappImages/{id}', [App\Http\Controllers\AssetAppController::class, 'getappImages']);
    Route::post('/addImages/{id}', [App\Http\Controllers\AssetAppController::class, 'addImages']);
    Route::post('/submitSurvey/{id}', [App\Http\Controllers\AssetAppController::class, 'submitSurvey']);
    Route::post('/submitSiteSurvey/{id}', [App\Http\Controllers\AssetAppController::class, 'submitSiteSurvey']);
    Route::post('/updateGPS/{id}', [App\Http\Controllers\AssetAppController::class, 'updategps']);

    Route::get('/getGeneralInfo/{id}', [App\Http\Controllers\AssetAppController::class, 'getGeneralInfo']);
    Route::post('/updateGeneralInfo/{id}', [App\Http\Controllers\AssetAppController::class, 'updateGeneralInfo']);

    Route::get('/getVehicleSurveyInfo/{id}', [App\Http\Controllers\AssetAppController::class, 'getVehicleSurveyInfo']);
    Route::post('/updateVehicleSurveyInfo/{id}', [App\Http\Controllers\AssetAppController::class, 'updateVehicleSurveyInfo']);

    Route::get('/getCoolerSurveyInfo/{id}', [App\Http\Controllers\AssetAppController::class, 'getCoolerSurveyInfo']);
    Route::post('/updateCoolerSurveyInfo/{id}', [App\Http\Controllers\AssetAppController::class, 'updateCoolerSurveyInfo']);

// surveyors name route 

Route::get('/getSurveyorsName/{id}', [App\Http\Controllers\AssetsController::class, 'getSurveyorName']);



});


