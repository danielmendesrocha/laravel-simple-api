<?php

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


Route::post('/auth', [UserController::class, 'loginApi']); // generates token
Route::post('/users', [UserController::class, 'create']);
Route::get('/users', [UserController::class, 'getAll'])->middleware('auth:sanctum');
Route::get('/users/{id}', [UserController::class, 'getSingle'])->middleware('auth:sanctum');
Route::put('/users/{id}', [UserController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/users/{id}', [UserController::class, 'delete'])->middleware('auth:sanctum');