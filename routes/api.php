<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Api\Controllers\UserController;

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

Route::post('login', [UserController::class,'authenticate']);

Route::middleware(['jwt.verify'])->group( function () {
    /*User Routes*/
    Route::apiResource('users', UserController::class);
    Route::get('users-profile', [UserController::class,'profile']);
    Route::post('users/update', [UserController::class,'update']);

    Route::middleware(['check.admin'])->group( function () {
        Route::get('users', [UserController::class,'index']);
    });

    /*Hobby Routes*/
    Route::get('user-hobby', [UserController::class,'getUserHobby']);
    Route::post('user-hobby', [UserController::class,'addUserHobby']);
    Route::delete('user-hobby/{id}', [UserController::class,'deleteUserHobby']);
});