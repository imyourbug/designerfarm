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
        Route::post('/register', 'AuthController@register')->name('register');
        Route::post('/changePassword', 'AuthController@changePassword')->name('changePassword');
        // Route::post('/update', 'AuthController@update')->name('update');
    });
    Route::post('/sendMessage', 'BotController@sendMessage')->name('sendMessage');

    Route::post('/setCacheByEmail', 'BotController@setCacheByEmail')->name('setCacheByEmail');
    Route::post('/getCacheByEmail', 'BotController@getCacheByEmail')->name('getCacheByEmail');
    Route::post('/setCacheById', 'BotController@setCacheById')->name('setCacheById');
    Route::post('/getCacheById', 'BotController@getCacheById')->name('getCacheById');
    Route::post('/getCacheByKey', 'BotController@getCacheByKey')->name('getCacheByKey');
    Route::post('/deleteAllCache', 'BotController@deleteAllCache')->name('deleteAllCache');
    #settings
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::post('delete', 'SettingController@delete')->name('delete');
        Route::post('/create', 'SettingController@store')->name('store');
        Route::get('getAll', 'SettingController@getAll')->name('getAll');
    });

    #upload
    Route::post('/upload', 'UploadController@upload')->name('upload');

    #accounts
    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
        Route::delete('/{id}/destroy', 'AccountController@destroy')->name('destroy');
        Route::get('/getAll', 'AccountController@getAll')->name('getAll');
        Route::post('/deleteAll', 'AccountController@deleteAll')->name('deleteAll');
    });

    #discounts
    Route::group(['prefix' => 'discounts', 'as' => 'discounts.'], function () {
        Route::delete('/{id}/destroy', 'DiscountController@destroy')->name('destroy');
        Route::get('/getAll', 'DiscountController@getAll')->name('getAll');
        Route::get('/getDiscountByCode', 'DiscountController@getDiscountByCode')->name('getDiscountByCode');
        Route::post('/deleteAll', 'DiscountController@deleteAll')->name('deleteAll');
    });

    #packages
    Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
        Route::delete('/{id}/destroy', 'PackageController@destroy')->name('destroy');
        Route::post('/create', 'PackageController@store')->name('store');
        Route::get('/getAll', 'PackageController@getAll')->name('getAll');
        Route::get('/getPackageById', 'PackageController@getPackageById')->name('getPackageById');
        Route::post('/deleteAll', 'PackageController@deleteAll')->name('deleteAll');
    });

    #websites
    Route::group(['prefix' => 'websites', 'as' => 'websites.'], function () {
        Route::delete('/{id}/destroy', 'WebsiteController@destroy')->name('destroy');
        Route::post('/update', 'WebsiteController@update')->name('update');
        Route::get('/getAll', 'WebsiteController@getAll')->name('getAll');
        Route::post('/deleteAll', 'WebsiteController@deleteAll')->name('deleteAll');
    });

    #packagedetails
    Route::group(['prefix' => 'packagedetails', 'as' => 'packagedetails.'], function () {
        Route::delete('/{id}/destroy', 'PackageDetailController@destroy')->name('destroy');
        Route::post('/create', 'PackageDetailController@store')->name('store');
        Route::get('/getAll', 'PackageDetailController@getAll')->name('getAll');
        Route::get('/searchOne', 'PackageDetailController@searchOne')->name('searchOne');
        Route::get('/getPackageById', 'PackageDetailController@getPackageById')->name('getPackageById');
        Route::post('/deleteAll', 'PackageDetailController@deleteAll')->name('deleteAll');
    });

    #downloadhistories
    Route::group(['prefix' => 'downloadhistories', 'as' => 'downloadhistories.'], function () {
        Route::get('/getAll', 'DownloadHistoryController@getAll')->name('getAll');
    });

    #requests
    Route::group(['prefix' => 'requests', 'as' => 'requests.'], function () {
        Route::post('/create', 'RequestController@store')->name('store');
        Route::post('/update', 'RequestController@update')->name('update');
        Route::get('/getAll', 'RequestController@getAll')->name('getAll');
        Route::post('/deleteAll', 'RequestController@deleteAll')->name('deleteAll');
        Route::delete('/{id}/destroy', 'RequestController@destroy')->name('destroy');
    });

    #members
    Route::group(['prefix' => 'members', 'as' => 'members.'], function () {
        Route::get('/getAll', 'MemberController@getAll')->name('getAll');
        Route::get('/getMembersByUserId', 'MemberController@getMembersByUserId')->name('getMembersByUserId');
        // Route::post('/deleteAll', 'MemberController@deleteAll')->name('deleteAll');
        Route::delete('/{id}/destroy', 'MemberController@destroy')->name('destroy');
    });

    Route::group(['namespace' => 'Admin'], function () {
        #accounts
        Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
            Route::delete('/{id}/destroy', 'AccountController@destroy')->name('destroy');
        });
    });
});
