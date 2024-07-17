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

Route::get('/reset-number-file', function () {
    return Artisan::call('reset-number-file');
});

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

    #paypals
    Route::group(['prefix' => 'paypals', 'as' => 'paypals.'], function () {
        Route::get('/', 'PayPalController@index')->name('index');
        Route::get('createTransaction', 'PayPalController@createTransaction')->name('createTransaction');
        Route::get('processTransaction', 'PayPalController@processTransaction')->name('processTransaction');
        Route::get('successTransaction', 'PayPalController@successTransaction')->name('successTransaction');
        Route::get('cancelTransaction', 'PayPalController@cancelTransaction')->name('cancelTransaction');
    });

    #packages
    Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
        Route::get('/', 'PackageController@index')->name('index');
        Route::get('/{id}', 'PackageController@show')->name('show');
    });

    #downloadhistories
    Route::group(['prefix' => 'downloadhistories', 'as' => 'downloadhistories.'], function () {
        Route::get('/', 'DownloadHistoryController@index')->name('index');
    });

    #requests
    Route::group(['prefix' => 'requests', 'as' => 'requests.'], function () {
        Route::get('/', 'RequestController@index')->name('index');
    });

    #members
    Route::group(['prefix' => 'members', 'as' => 'members.'], function () {
        Route::get('/', 'MemberController@index')->name('index');
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

        #reports
        Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
            Route::get('/', 'ReportController@index')->name('index');
        });

        #settings
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('/', 'SettingController@index')->name('index');
            Route::post('update', 'SettingController@update')->name('update');
        });

        #discounts
        Route::group(['prefix' => 'discounts', 'as' => 'discounts.'], function () {
            Route::get('/', 'DiscountController@index')->name('index');
            Route::post('/create', 'DiscountController@store')->name('store');
            Route::get('/update/{id}', 'DiscountController@show')->name('show');
            Route::post('/update', 'DiscountController@update')->name('update');
        });

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

        #websites
        Route::group(['prefix' => 'websites', 'as' => 'websites.'], function () {
            Route::get('/', 'WebsiteController@index')->name('index');
            Route::post('/create', 'WebsiteController@store')->name('store');
            Route::get('/update/{id}', 'WebsiteController@show')->name('show');
            Route::post('/update', 'WebsiteController@update')->name('update');
        });

        #packagedetails
        Route::group(['prefix' => 'packagedetails', 'as' => 'packagedetails.'], function () {
            Route::get('/', 'PackageDetailController@index')->name('index');
            Route::post('/create', 'PackageDetailController@store')->name('store');
            Route::get('/update/{id}', 'PackageDetailController@show')->name('show');
            Route::post('/update', 'PackageDetailController@update')->name('update');
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
