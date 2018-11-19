<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;

class GameController extends Controller
{
    public function show($id) {
      return view('game.game');
    }

    public function index() {
      $games = Game::all();
      return view('game.index', $games);
    }
}
