<?php

use App\User;
use App\Game;

Broadcast::channel('games', function ($game) {
  return true;
});

Broadcast::channel('game.event.{game_id}', function ($user, $game_id) {
  $game = Game::where('id', $game_id)->first();
  if ( ($game->opponent_id == $user->id) || ($game->creator_id == $user->id) ) {
    return true;
  }
});
