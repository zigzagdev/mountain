<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterUserController;


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

  //After Login action
  Route::middleware('auth:sanctum')->group(function () {
  });

});
