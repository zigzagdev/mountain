<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LogoutController;




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

//Before Login action
Route::middleware('api')->group(function () {

  //RegisterUserController
  Route::controller(RegisterUserController::class)->group(function (){
      Route::post('/RegisterUser', 'post');
  });
  //LoginController
  Route::controller(LoginController::class)->group(function () {
      Route::post('/login', 'login');
  });

  //After Login action
    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(LogoutController::class)->group(function () {
            Route::get('/logout', 'get');
        });
    });

});
