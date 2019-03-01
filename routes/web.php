<?php

Route::get('/', function () {
    return view('home.home');
});

// Create a new User
Route::post('/user/store', 'UserController@store');
// Retrieve data for a user
Route::get('/user/data/{id}', 'UserController@data');
// Save User Side Deck
Route::post('/user/update_sidedeck', 'UserController@save_deck');
// Retrieve User Side Deck
Route::get('/user/get_sidedeck/{id}', 'UserController@get_deck');
// Show the game list
Route::get('/games', 'GameController@index');
// Retrieve an array of all open games
Route::get('/games/all', 'GameController@all');
// Show a game
Route::get('/game/{id}', 'GameController@show');
// Create a new game
Route::post('/game', 'GameController@store');

// Game Routes
// Get Game Data
Route::get('/game/data/{id}', 'GameController@data');
// Join a Game
Route::post('/game/join/{id}', 'GameController@join');
// Player is ready
Route::post('/game/ready/{id}', 'GameController@readyUp');
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
// Start Game
Route::post('/game/start/{id}', 'GameController@startGame');
