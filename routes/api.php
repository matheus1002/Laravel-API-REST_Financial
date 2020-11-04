<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['namespace' => 'API'], function(){

    Route::post('register', 'AuthController@register')->name('register');
    Route::post('login', 'AuthController@login')->name('login');

    Route::group(['middleware' => 'auth:api'], function (){

        Route::post('logout', 'AuthController@logout')->name('logout');
        Route::post('refresh', 'AuthController@refresh')->name('refresh');
        Route::post('me', 'AuthController@me')->name('me');

        Route::get('transactions/statistics', 'TransactionController@statistics');
        Route::apiResource('transactions', 'TransactionController');
    });

});;


