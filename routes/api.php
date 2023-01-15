<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\NewsController;

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

Route::controller(UserController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('detail', 'detail')->middleware('auth:api');
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::prefix('news')->controller(NewsController::class)->group(function () {
        Route::post('/', 'create');
        Route::get('/{id}', 'getDetail');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::get('/', 'getList');

        Route::post('/{id}/comment', 'createComment');
    });
});
