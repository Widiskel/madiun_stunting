<?php

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

Route::group(['prefix' => '/', 'as' => 'puskesmas.'], function () {
    Route::get('/', 'DashboardController@index')->name('index');
    Route::get('/detail/{id}', 'DashboardController@show')->name('show');
    Route::get('/puskesmas/{id}', 'DashboardController@get_by_years')->name('get_years');
    Route::get('/get_years/{id_y}/{id}', 'DashboardController@show_by_years')->name('get_years_detil');
});
