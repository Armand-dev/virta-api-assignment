<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Group for some sort of authentication in the future.
 */
Route::middleware([])->group(function(){
    Route::apiResource('/companies', CompanyController::class);
    Route::apiResource('/stations', StationController::class);

    Route::post('getStationsInArea', [StationController::class, 'getStationsInArea'])->name('get-station-in-area');
});

Route::get('test', function (){
    return app()->version();
});
