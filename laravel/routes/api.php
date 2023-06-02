<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

// generates token
Route::post('auth', [AuthController::class, 'loginApi']);
// create user
Route::post('users', [UserController::class, 'store']);
// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::apiResource('users', UserController::class)->except(['store']);
});