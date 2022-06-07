<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklogController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberRoleController;
use App\Http\Controllers\RegisterForgetController;
use App\Http\Controllers\RegisterLeaveController;
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
    Route::post('/refresh-token', 'refresh');
    Route::patch('/change-password', 'changePassword');
});
Route::prefix('worksheet')
    ->controller(WorksheetController::class)
    ->group(function () {
    Route::get('', 'index');
    Route::get('/show-id', 'getById');
    Route::get('/show-date', 'getByDate');
});

Route::prefix('register-leave')
    ->controller(RegisterLeaveController::class)
    ->group(function () {
//        Route::get('', 'index');
        Route::post('/store', 'store');
    });
Route::apiResource('member-role', MemberRoleController::class);
Route::apiResource('time-log', ChecklogController::class);
Route::apiResource('register-forget', RegisterForgetController::class);
Route::apiResource('members', MemberController::class)->only('edit','update');
