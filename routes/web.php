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
Route::resource('pl', 'PaletteController')->middleware('auth');
Route::resource('c', 'ColorController')->middleware('auth');
Route::resource('t', 'TypoController')->middleware('auth');

Route::view('in/code', 'getallcolors');

Route::post('updateColorPalette', 'ColorController@updateColorPalette')->middleware('auth');

Route::post('/switch_mode', 'ThemeController@switch_mode');

Auth::routes();