<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Game;
use App\User;

use App\Events\NewGameCreated;

use App\Events\PlayerJoinedGame;
use App\Events\PlayerEndTurn;
use App\Events\PlayerPlayCard;
use App\Events\PlayerStand;
use App\Events\PlayerForfeit;
use App\Events\PlayerLeftGame;

class GameController extends Controller
{
    public function show ($id) {
      $game = Game::where('id', $id)->first();

      // If the user is authenticated and the opponent_id or creator_id do not equal the authenticated users id, redirect home
      if ( (auth()->user()->id) AND ($game->creator_id == auth()->user()->id OR $game->opponent_id == auth()->user()->id) ) {
        return view('game.game', compact(['game']));
      } else {
        return redirect('/');
      }

    }

    public function index () {
      $games = Game::where('status', 'open')->get();
      return view('game.index', compact('games'));
    }

    public function all () {
      return $games = Game::where('status', 'open')->where('opponent_id', '')->get();
    }

    public function data ($id) {
      $game = Game::where('id', $id)->first();
      return response()->json($game);
    }

    /*public function leave (Request $request, $id) {
      $game = Game::where('id', $id)->first();
      $game->opponent_id = 0;
      $game->status = "active";
      $game->save();
    }*/

    public function join (Request $request) {
      // Get game record and update opponent id
      $game = Game::where('id', $request->game_id)->first();
      $game->opponent_id = $request->user_id;
      $game->status = "active";
      $game->save();

      // Get the data for the user that has joined the game
      $opponent = User::where('id', $request->user_id)->first();

      // Dispatch a player joined game event with the data of the user and the game id
      PlayerJoinedGame::dispatch($opponent, $game->id);

      return response()->json('game/' . $game->id);
    }


    public function store (Request $request) {
      $game = Game::create([
        'creator_id' => $request->UserID,
        'opponent_id' => 0,
        'wager' => $request->Wager
      ]);

      NewGameCreated::dispatch($game);
      return response()->json('game/' . $game->id);
    }


    public function endTurn (Request $request) {
      $data = $request->all();
      $game_id = $request->game_id;
      // We generate the value of the next dealer card here, this is to synchronise the result between clients
      $random_dealer_card = mt_rand(1,10);
      PlayerEndTurn::dispatch($game_id, $data, $random_dealer_card, $request->player_index);
    }

    public function leaveGame (Request $request) {
      $data = $request->all();
      $game_id = $request->game_id;
      PlayerLeftGame::dispatch($game_id, $data);
    }

    public function playCard (Request $request) {
      $data = $request->all();
      $game_id = $request->game_id;
      PlayerPlayCard::dispatch($game_id, $data);
    }

    public function setStand (Request $request) {
      $data = $request->all();
      $game_id = $request->game_id;
      PlayerStand::dispatch($game_id, $data);
    }

    public function forfeitGame (Request $request) {
      $data = $request->all();
      $game_id = $request->game_id;
      PlayerForfeit::dispatch($game_id, $data);
    }



}
