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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
/**
 * Calc
 */
Route::resource('/calc', 'CalcController');

/**
 * Admin Panel
 */
Route::get('/admin', 'AdminController@index');
Route::get('/admin/{user}', 'AdminController@show');

/**
 * Cezar decoder
 * */
Route::get('/cezar/learning', 'CezarController@index');
Route::post('/cezar/learning', 'CezarController@store')->name('cezarLearning.store');;


Route::get('/develop', 'DevelopController@index');

Route::get('/stripe', 'StripeController@index');
Route::post('/stripe', 'StripeController@store');