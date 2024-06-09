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

    #upload
    Route::post('/upload', 'UploadController@upload')->name('upload');

    #packages
    Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
        Route::delete('/{id}/destroy', 'PackageController@destroy')->name('destroy');
        Route::post('/create', 'PackageController@store')->name('store');
        Route::get('/getAll', 'PackageController@getAll')->name('getAll');
        Route::post('/deleteAll', 'PackageController@deleteAll')->name('deleteAll');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Admin'], function () {
    #accounts
    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
        Route::delete('/{id}/destroy', 'AccountController@destroy')->name('destroy');
    });
});
