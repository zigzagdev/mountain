<?php

namespace App\Http\Controllers\Api;


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

//Before Login action
Route::middleware('api')->group(function () {

  //RegisterUserController
  Route::controller(RegisterUserController::class)->group(function (){
      Route::post('/registerUser', 'post');
  });
  Route::controller(DisplayController::class)->group(function (){
      Route::get('/topSearch', 'ratingDisplay');
  });

  Route::controller(CommentController::class)->group(function (){
      Route::post('/commentC', 'makeComment');
  });

  //LoginController
  Route::controller(LoginController::class)->group(function () {
      Route::post('/login', 'login');
  });

  //After Login action
    Route::middleware('auth.adminToken')->group(function () {
        Route::controller(LogoutController::class)->group(function () {
            Route::get('/logout', 'get');
        });
        Route::controller(ArticleController::class)->group(function () {
            Route::post('/articleWrite', 'articleWrite');
            Route::put('/articleReWrite', 'articleReWrite');
        });
    });
});

