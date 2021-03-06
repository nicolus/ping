<?php

use App\Http\Controllers\Api\ApiUrlController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\AuthenticateMobileApp;
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

Route::post('/sanctum/token', AuthenticateMobileApp::class);

Route::group(['middleware' => 'auth:sanctum'], function() {
  Route::get('/urls', [ApiUrlController::class, 'index']);
  Route::get('/urls/refresh', [ApiUrlController::class, 'refresh']);
  Route::post('/user', [ApiUserController::class, 'update']);
});



