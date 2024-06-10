<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/schedule', function () {
    return Artisan::call('schedule:run');
});

Route::get('/link', function () {
    return Artisan::call('storage:link');
});

Route::get('/optimize', function () {
    return Artisan::call('optimize:clear');
});

Route::get('/migrate', function () {
    return Artisan::call('migrate:refresh --seed');
});

#user
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', 'HomeController@index')->name('home');

    #charge
    Route::group(['prefix' => 'charge', 'as' => 'charge.'], function () {
        Route::get('/', 'ChargeController@index')->name('index');
    });

    #packages
    Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
        Route::get('/', 'PackageController@index')->name('index');
    });
});

#admin
Route::group([
    'prefix' => '/admin', 'namespace' => 'App\Http\Controllers\Admin',
    'as' => 'admin.',
], function () {
    Route::get('login', 'AdminController@login')->name('login');
    Route::get('forgot', 'AdminController@forgot')->name('forgot');
    Route::post('recover', 'AdminController@recover')->name('recover');
    Route::post('login', 'AdminController@checkLogin')->name('checkLogin');
    Route::get('register', 'AdminController@register')->name('register');
    Route::post('register', 'AdminController@checkRegister')->name('checkRegister');
    // Route::post('change_password', 'AdminController@changePassword')->name('changePassword');
    Route::get('logout', 'AdminController@logout')->name('logout');

    #admin
    Route::group([
        'middleware' => 'admin'
    ], function () {
        Route::get('/', 'AdminController@index')->name('index');

        #accounts
        Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
            Route::get('/', 'AccountController@index')->name('index');
            Route::post('/create', 'AccountController@store')->name('store');
            Route::get('/update/{id}', 'AccountController@show')->name('show');
            Route::post('/update', 'AccountController@update')->name('update');
        });

        #settings
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('/', 'SettingController@index')->name('index');
            Route::post('update', 'SettingController@update')->name('update');
        });

        #packages
        Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
            Route::get('/', 'PackageController@index')->name('index');
            Route::post('/create', 'PackageController@store')->name('store');
            Route::get('/update/{id}', 'PackageController@show')->name('show');
            Route::post('/update', 'PackageController@update')->name('update');
        });

        #requests
        Route::group(['prefix' => 'requests', 'as' => 'requests.'], function () {
            Route::get('/', 'RequestController@index')->name('index');
            Route::post('/create', 'RequestController@store')->name('store');
            Route::get('/update/{id}', 'RequestController@show')->name('show');
            Route::post('/update', 'RequestController@update')->name('update');
        });

        #members
        Route::group(['prefix' => 'members', 'as' => 'members.'], function () {
            Route::get('/', 'MemberController@index')->name('index');
            Route::post('/create', 'MemberController@store')->name('store');
            Route::get('/update/{id}', 'MemberController@show')->name('show');
            Route::post('/update', 'MemberController@update')->name('update');
        });
    });
});
