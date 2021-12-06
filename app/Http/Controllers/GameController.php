<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Question;
use App\Models\Round;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function start() {

        DB::statement('UPDATE questions SET game_id=null');
        $users = User::where('is_active', true)->orderBy('name')->get();
        $game = Game::create();

        $game->users()->sync($users);

        return redirect()->route('game.play', [
            'game' => $game,
            'round_number' => 1
        ]);
    }

    public function play(Request $request, Game $game, $round_number) {
        if (!($round = $game->rounds()->where('number', $round_number)->first())) {
            $round = $game->rounds()->create(['number' => $round_number]);
            $round->current_user()->associate($game->users()->where('is_active', true)->first())->save();
            $round->updateCurrentQuestion();
            $round->users()->attach($game->users);
        }

        return view('game.play', [
            'round' => $round,
            'game' => $game,
            'user' => $round->current_user
        ]);
    }


    public function control($result, Round $round) {
        if ($result) {
            $money = $round->getMoney();
            $round->update(['current_money' => $money]);
            $round->users()->syncWithPivotValues([$round->current_user->id], ['money' => $money, 'right_answers' => $round->users()->where('users.id', $round->current_user->id)->first()->pivot->right_answers+1]);
        } else {
            $round->downBank();
        }
        $round->updateCurrentUser();
        $round->updateCurrentQuestion();

        return redirect()->route('game.play', ['game' => $round->game->id, 'round_number' => $round->number]);
    }

    public function bank(Round $round) {
        $round->catchBank();

        return redirect()->route('game.play', ['game' => $round->game->id, 'round_number' => $round->number]);
    }

    public function roundStop(Round $round) {
        $round->game->update(['bank' => $round->bank]);

        return redirect()->route('game.play', ['game' => $round->game->id, 'round_number' => $round->number+1]);
    }
}
