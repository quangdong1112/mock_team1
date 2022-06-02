<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklogController;
use App\Http\Controllers\MemberRoleController;
use App\Http\Controllers\WorksheetController;
use Illuminate\Http\Request;
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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::delete('/logout', 'logout');
    Route::patch('/change-password', 'changePassword');
});
Route::apiResource('worksheet', WorksheetController::class);
Route::apiResource('member-role', MemberRoleController::class);
Route::apiResource('time-log', ChecklogController::class);
Route::apiResource('members', \App\Http\Controllers\MemberController::class)->only('edit','update')->middleware('auth:api');
