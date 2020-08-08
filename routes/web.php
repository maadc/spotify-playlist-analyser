<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', 'HomeController@index')->name('start');

Route::get('/statistics', 'StatisticController@index')->name('statistics');

Route::get('/playlist', 'RedirectController@home');
Route::post('/playlist', 'TrackController@trackAnalysis')->name('playlist.analyse');
