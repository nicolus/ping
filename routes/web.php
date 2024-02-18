<?php

use App\Http\Controllers\ProbeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'login');

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::resource('/probes', ProbeController::class);

    Route::get('/settings', [UserController::class, 'edit'])->name('settings');
    Route::post('/settings', [UserController::class, 'update'])->name('settings.update');
});
