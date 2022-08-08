<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\AuthenticationController;

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

#Authenticate
#Route::post('authenticate/login', [AuthenticationController::class, 'login']);
#Route::post('authenticate/logout', [AuthenticationController::class, 'logout']);
#Route::post('authenticate/refresh', [AuthenticationController::class, 'refresh']);

Route::group(['middleware' => ['avature.auth']], function () {

    #jobs
    Route::get('jobs', [JobController::class, 'search']);
    Route::post('jobs', [JobController::class, 'create']);

    #alerts
    Route::get('alerts', [AlertController::class, 'search']);
    Route::post('alerts', [AlertController::class, 'create']);
});
