<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        return view('index', [
            'current_game' => Game::whereNull('winner_id')->first()
        ]);
    }
}
