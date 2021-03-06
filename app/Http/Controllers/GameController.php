<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Game;
use App\User;
use Illuminate\Support\Facades\Auth;

use App\Events\NewGameCreated;
use App\Events\PlayerJoinedGame;
use App\Events\PlayerEndTurn;
use App\Events\PlayerPlayCard;
use App\Events\PlayerStand;
use App\Events\PlayerForfeit;
use App\Events\PlayerLeftGame;
use App\Events\StartGame;
use App\Events\ReadyUp;
use App\Events\GameIsFull;

class GameController extends Controller
{
    public function show ($id) {

      $game = Game::where('id', $id)->first();
      return view('game.game', compact(['game']));

      /*if (Auth::id()) {
        if (Auth::id() != $game->opponent_id OR Auth::id() != $game->creator_id) {
          return redirect('/');
        }
      }*/

    }

    public function readyUp (Request $request) {
      ReadyUp::dispatch($request);
    }

    public function startGame (Request $request) {
      $request['random_dealer_card'] = mt_rand(1,10);
      StartGame::dispatch($request);
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

    public function join (Request $request) {
      // Get game record and update opponent id
      $game = Game::where('id', $request->game_id)->first();

      if(isset($game->opponent_id)){
        return response()->json("This Game is Full");
      }

      $game->opponent_id = $request->user_id;
      $game->status = "active";
      $game->save();
      // Get the data for the user that has joined the game
      $opponent = User::where('id', $request->user_id)->first();

      GameIsFull::dispatch($game->id);

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
