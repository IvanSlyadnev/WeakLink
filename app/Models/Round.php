<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'time', 'seria', 'bank', 'current_money'
    ];

    public function game() {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'round_user')->withPivot(['money', 'right_answers', 'answers']);
    }

    public function strong_link() {
        return $this->belongsTo(User::class, 'strong_link');
    }

    public function weak_link() {
        return $this->belongsTo(User::class, 'weak_link');
    }

    public function dead() {
        return $this->belongsTo(User::class, 'dead');
    }

    public function current_user() {
        return $this->belongsTo(User::class, 'current_user_id');
    }

    public function current_question() {
        return $this->belongsTo(Question::class, 'current_question_id');
    }

    public function getMoney() {
        $this->seria++;
        $this->save();

        switch ($this->seria) {
            case 1:
                return 1000;
                break;
            case 2 :
                return 2000;
                break;
            case 3 :
                return 5000;
                break;
            case 4 :
                return 10000;
                break;
            case 5 :
                return 20000;
                break;
            case 6 :
                return 30000;
                break;
            case 7 :
                return 40000;
                break;
            case 8 :
                return 50000;
                break;
        }
    }

    public function downBank() {
        $this->update(['seria' => 0]);
        $this->update(['current_money'=> 0]);
    }

    public function catchBank() {
        $this->update(['bank' => $this->current_money]);
        $this->downBank();
    }

    public function updateCurrentUser () {
        //dd($this->game->getNextUser($this->current_user));
        $this->current_user()->associate($this->game->getNextUser($this->current_user))->save();
    }

    public function updateCurrentQuestion() {
        $question = Question::whereNull('game_id')->inRandomOrder()->first();
        $question->update(['game_id' => $this->game->id]);
        $this->current_question()->associate($question)->save();
    }
}
