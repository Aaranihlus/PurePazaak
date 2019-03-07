<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    //Create a new user
    public function store (Request $request) {
      $user = User::create([
        'username' => $request->username,
        'credits' => 500,
        'games_played' => 0,
        'wins' => 0,
        'side_deck' => ''
      ]);
      $currentUser = Auth::check();
      if (!$currentUser) {
        Auth::loginUsingId($user->id);
      }
      return response()->json($user);
    }

    public function leaderboard(){

      $mostCredits = User::orderBy('credits', 'desc')->limit(10)->get();
      $mostWins = User::orderBy('games_played', 'desc')->limit(10)->get();
      $mostGamesPlayed = User::orderBy('wins', 'desc')->limit(10)->get();

      $data = [];
      $data['credits'] = $mostCredits;
      $data['games_played'] = $mostGamesPlayed;
      $data['wins'] = $mostWins;

      return $data;
    }

    // Show the deck builder
    public function deck () {
      return view('user.deck');
    }

    // Retrieve Data for a Specified User
    public function data ($id) {
      $user = User::where('id', $id)->first();
      $currentUser = Auth::check();
      if (!$currentUser) {
        Auth::loginUsingId($user->id);
      }
      return response()->json($user);
    }

    // Save the users chosen side deck
    public function save_deck (Request $request) {
      $user = User::where('id', $request->user_id)->first();
      $user->side_deck = $request->chosen_side_deck;
      $user->save();
    }

    // Retreive the users side deck
    public function get_deck ($id) {
      $user = User::where('id', $id)->pluck('side_deck')->first();
      return $user;
    }


}
