<?php

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
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

Route::group([
    'middleware'=>'guest',
    'prefix'=>'v1/auth'
], function(){
    Route::controller(ForgotPasswordController::class)->group(function(){
        Route::post('forgot-password','forgot');
    });
    Route::controller(ResetPasswordController::class)->group(function(){
        Route::put('reset-password','reset');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
