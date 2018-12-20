<?php

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

Route::get('/', 'MainController@index')->name('main');

Route::resource('p', 'ProjectController')->middleware('auth');
Route::resource('p.c', 'PaletteController')->middleware('auth');
Route::resource('p.t', 'TypoController')->middleware('auth');

Route::post('updateColorPalette', 'ColorController@updateColorPalette')->middleware('auth');

Auth::routes();