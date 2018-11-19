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
    return view('home.home');
});

Route::post('/user/store', 'UserController@store');

Route::get('/deck', 'UserController@deck');

Route::get('/games', 'GameController@index');
Route::get('/game/{id}', 'GameController@show');
