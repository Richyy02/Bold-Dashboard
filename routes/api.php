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

Route::get("updateOhDearTotalTimeHour/{api_location}", [\App\Http\Controllers\Api\ApiLocationController::class, "updateOhDearTotalTime"]);
Route::get("updateOhDearTotalTimeWeek/{api_location}", [\App\Http\Controllers\Api\ApiLocationController::class, "updateOhDearTotalTimeWeek"]);
Route::get("updateOhDearUpTimeWeek/{api_location}", [\App\Http\Controllers\Api\ApiLocationController::class, "updateOhDearUpTimeWeek"]);
Route::get("updateOhDearUpTimeMonth/{api_location}", [\App\Http\Controllers\Api\ApiLocationController::class, "updateOhDearUpTimeMonth"]);
Route::get("updatePostmarkSentCountWeek/{api_location}", [\App\Http\Controllers\Api\ApiLocationController::class, "updatePostmarkSentCountWeek"]);
Route::get("updatePostmarkSentCountMonth/{api_location}", [\App\Http\Controllers\Api\ApiLocationController::class, "updatePostmarkSentCountMonth"]);
