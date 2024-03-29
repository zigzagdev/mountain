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

  // SearchQueryController
  Route::controller(DisplayController::class)->group(function (){
      Route::get('/topSearch', 'ratingDisplay');
  });

  //CommentController
  Route::controller(CommentController::class)->group(function (){
      Route::post('/commentCreate', 'makeComment');
      Route::put('/changeComment', 'changeComment');
      Route::delete('/deleteComment', 'deleteComment');
  });

  //LoginController
  Route::controller(LoginController::class)->group(function () {
      Route::post('/login', 'login');
  });

  //After Login action
    Route::middleware('auth.adminToken')->group(function () {

        //LogoutController
        Route::controller(LogoutController::class)->group(function () {
            Route::get('/logout', 'logout');
        });

        //ArticleController
        Route::controller(ArticleController::class)->group(function () {
            Route::post('/articleWrite', 'articleWrite');
            Route::put('/articleReWrite', 'articleReWrite');
            Route::delete('/articleDelete', 'articleDelete');
        });
        //NewsController
        Route::controller(NewsMakingController::class)->group(function () {
            Route::post('/newsMake', 'newsMake');
            Route::put('/newsReWrite', 'newsReWrite');
            Route::delete('/newsDelete', 'newsDelete');
        });
        //AdminController_Relations(passwordChange, emailChange, nameChange)
        Route::controller(AdminColumnChangeController::class)->group(function () {
            Route::put('/emailChange', 'adminEmailChange');
            Route::put('/nameChange', 'adminNameChange');
            Route::put('/passwordChange', 'adminPasswordChange');
        });
    });
});

