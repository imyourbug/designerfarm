<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::post('/login', 'AuthController@login')->name('login');
    });
    Route::post('/sendMessage', 'BotController@sendMessage')->name('sendMessage');

    Route::post('/setCacheByEmail', 'Controller@setCacheByEmail')->name('setCacheByEmail');
    Route::post('/getCacheByEmail', 'Controller@getCacheByEmail')->name('getCacheByEmail');
    Route::post('/setCacheById', 'Controller@setCacheById')->name('setCacheById');
    Route::post('/getCacheById', 'Controller@getCacheById')->name('getCacheById');
    Route::post('/getCacheByKey', 'Controller@getCacheByKey')->name('getCacheByKey');
    Route::post('/deleteAllCache', 'Controller@deleteAllCache')->name('deleteAllCache');
});
