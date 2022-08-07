<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AlertController;

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

Route::group(['middleware' => []], function () {
    
    #jobs
    Route::get('jobs', [JobController::class, 'search']);
    Route::post('jobs', [JobController::class, 'create']);

    #alerts
    Route::get('alerts', [AlertController::class, 'search']);
    Route::post('alerts', [AlertController::class, 'create']);
});
