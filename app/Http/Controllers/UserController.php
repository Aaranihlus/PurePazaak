<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store (Request $request) {
      if ($request->username) {
        echo $request->username;
      }
    }

    public function deck () {
      return view('user.deck');
    }
}
