<?php

Route::get('/', function () {
    return view('home.home');
});

Route::post('/user/store', 'UserController@store');

Route::get('/user/data/{id}', 'UserController@data');

// Show Side Deck Builder
Route::get('/deck', 'UserController@deck');

// Save User Side Deck
Route::post('/user/update_sidedeck', 'UserController@save_deck');

// Retrieve User Side Deck
Route::get('/user/get_sidedeck/{id}', 'UserController@get_deck');

Route::get('/games', 'GameController@index');
Route::get('/games/all', 'GameController@all');
Route::get('/game/{id}', 'GameController@show');
Route::post('/game', 'GameController@store');

// Game Functions
// Get Game Data
Route::get('/game/data/{id}', 'GameController@data');
// Join Game
Route::post('/game/join/{id}', 'GameController@join');
// End Turn
Route::post('/game/{id}/endturn', 'GameController@endTurn');
// Play a SideDeck Card
Route::post('/game/{id}/playcard', 'GameController@playCard');
// Player Stands
Route::post('/game/{id}/setStand', 'GameController@setStand');
// Forfeit Game
Route::post('/game/{id}/forfeitGame', 'GameController@forfeitGame');
// Leave Game
Route::post('/game/{id}/leaveGame', 'GameController@leave');
