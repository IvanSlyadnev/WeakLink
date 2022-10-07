<?php

namespace App\Http\Controllers;

use App\Http\Requests\NextRoundRequest;
use App\Models\Game;
use App\Models\Question;
use App\Models\Round;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function start() {
        Question::query()->update(['game_id' => null]);
        User::query()->update(['is_active' => true]);
        $users = User::where('is_active', true)->orderBy('name')->get();
        $game = Game::create();

        $game->users()->sync($users);

        return redirect()->route('game.play', [
            'game' => $game,
            'round_number' => 1
        ]);
    }

    public function play(Game $game, $round_number) {
        if (!User::where('is_active', true)->exists()) {
            return redirect()->route('users.index');
        }
        if (!($round = $game->rounds()->where('number', $round_number)->first())) {
            $round = $game->rounds()->create(['number' => $round_number]);
            $round->users()->attach($game->active_users);
            if ($round_number > 1) {
                $round->users()->syncWithoutDetaching([
                    $game->rounds()->where('number', $round_number-1)->first()->strong->id => ['current' => true]
                ]);
            }
            $round->updateCurrentQuestion();
        }

        return view('game.play', [
            'round' => $round,
            'game' => $game,
            'user' => $round->current_user
        ]);
    }


    public function control($result, Round $round) {
        $money = $round->getMoney();

        if ($result) {
            $round->update(['current_money' => $money]);
            if ($money == 50000) {
                $round->update(['bank' => $money]);
                return redirect()->route('round.stop', [
                    'round' => $round->id
                ]);
            }
        } else {
            $round->users()->syncWithoutDetaching([$round->current_user->id =>
                [
                    'money' => $round->current_user->pivot->money - $round->current_money
                ]
            ]);
            $round->downBank();
        }
        $round->users()->syncWithoutDetaching([$round->current_user->id => [
            'answers' => $round->current_user->pivot->answers+1,
            'right_answers' => $round->current_user->pivot->right_answers + (int)$result
        ]]);
        $round->updateCurrentUser();
        $round->updateCurrentQuestion();

        return redirect()->route('game.play', ['game' => $round->game->id, 'round_number' => $round->number]);
    }

    public function bank(Round $round) {
        $round->catchBank();
        if ($round->bank == 50000) {
            return redirect()->route('round.stop', [
                'round' => $round->id
            ]);
        }

        return redirect()->route('game.play', ['game' => $round->game->id, 'round_number' => $round->number]);
    }

    public function roundStop(Round $round) {
        if (!$round->finished) {
            $round->game->update(['bank' => $round->game->bank + $round->getBank()]);
            $round->update(['finished' => true]);
        }

        return view('round.statistics', [
            'round' => $round,
            'users' => $round->setStrongLink(),
            'strong' => $round->users()->where('strong', true)->first(),
            'weak' => $round->users()->where('weak', true)->first()
        ]);

        //return redirect()->route('game.play', ['game' => $round->game->id, 'round_number' => $round->number+1]);
    }

    public function roundNext(NextRoundRequest $request, Round $round) {
        $user = User::find($request->name);

        $user->update(['is_active' => false]);

        if ($round->last) {
            return redirect()->route('game.final', ['game' => $round->game->id]);
        }

        return redirect()->route('game.play', ['game' => $round->game->id, 'round_number' => $round->number+1]);
    }

    public function finalRound(Game $game) {
        $winner = $game->active_users->first();
        $game->winner()->associate($winner)->save();
        return view('game.final', [
            'winner' => $winner
        ]);
    }

    public function continueGame(Game $game) {
        $round = $game->rounds()->latest()->first();
        if ($round->finished) {
            return redirect()->route('round.stop', [
                'round' => $round
            ]);
        }
        return redirect()->route('game.play', [
            'game' => $game->id,
            'round_number' => $game->rounds()->latest('number')->first()->number
        ]);
    }

    public function statistics(Game $game) {
        return view('game.statistics', [
            'game' => $game
        ]);
    }
}
