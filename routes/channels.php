<?php

use App\User;
use App\Game;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('games', function ($game) {
  return true;
});

Broadcast::channel('join.game.{game_id}', function ($user, $game_id) {
  $game = Game::where('id', $game_id)->first();
  if ( ($game->opponent_id == $user->id) || ($game->creator_id == $user->id) ) {
    return true;
  }
});

Broadcast::channel('player.endturn.game.{game_id}', function ($user, $game_id) {
  $game = Game::where('id', $game_id)->first();
  if ( ($game->opponent_id == $user->id) || ($game->creator_id == $user->id) ) {
    return true;
  }
});

Broadcast::channel('player.forfeit.game.{game_id}', function ($user, $game_id) {
  $game = Game::where('id', $game_id)->first();
  if ( ($game->opponent_id == $user->id) || ($game->creator_id == $user->id) ) {
    return true;
  }
});

Broadcast::channel('player.playcard.game.{game_id}', function ($user, $game_id) {
  $game = Game::where('id', $game_id)->first();
  if ( ($game->opponent_id == $user->id) || ($game->creator_id == $user->id) ) {
    return true;
  }
});
