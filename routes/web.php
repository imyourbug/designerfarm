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

    #task
    // Route::group(['prefix' => 'tasks', 'as' => 'tasks.', 'middleware' => 'auth'], function () {
    //     Route::get('/', 'TaskController@index')->name('index');
    //     Route::get('/today', 'TaskController@taskToday')->name('taskToday');
    //     Route::get('/{id}', 'TaskController@show')->name('show');
    // });
});
