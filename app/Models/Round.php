<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'time', 'seria', 'bank', 'current_money', 'finished'
    ];

    public function game() {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'round_user')->withPivot(['money', 'right_answers', 'answers', 'current', 'strong', 'weak', 'coefficient']);
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
        if ($this->seria > 8) {
            return 5000;
        }
    }

    public function downBank() {
        $this->update(['seria' => 0]);
        $this->update(['current_money'=> 0]);
    }

    public function catchBank() {
        $this->update(['bank' => $this->bank + $this->current_money]);
        $this->users()->syncWithoutDetaching([$this->current_user->id =>
            [
                'money' => $this->current_user->pivot->money + $this->current_money
            ]
        ]);
        $this->downBank();
        $count = $this->game->users()->where('is_active', true)->count();
        $value = 50000;
        if ($count > 8) {
            $value = $value + ($count - 8) * 10000;
        }

        if ($this->bank >= $value) {
            $this->update(['bank' => $value]);
        }
    }

    public function updateCurrentUser () {
        $this->users()->syncWithoutDetaching([
            $this->current_user->id => ['current' => false],
            $this->game->getNextUser($this->current_user)->id => ['current' => true]
        ]);
    }

    public function updateCurrentQuestion() {
        $question = Question::whereNull('game_id')->inRandomOrder()->first();
        $question->update(['game_id' => $this->game->id]);

        $this->current_question()->associate($question)->save();
    }

    public function setStrongLink() {
        foreach ($this->users as $user) {
            if ($user->pivot->answers) {
                $this->users()->syncWithoutDetaching([
                    $user->id => ['coefficient' => (float)($user->pivot->right_answers/$user->pivot->answers)]
                ]);
            }
        }

        $this->users = $this->users()
            ->orderByDesc('coefficient')
            ->orderByDesc('right_answers')
            ->orderByDesc('money')
            ->get();


        $this->users()->syncWithoutDetaching([
           $this->users->first()->id => ['strong' => true],
           $this->users->last()->id => ['weak' => true]
        ]);

        return $this->users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'right_answers' => $user->pivot->right_answers,
                'answers' => $user->pivot->answers,
                'coefficient' => round($user->pivot->coefficient, 2) * 100,
                'money' => $user->pivot->money
            ];
        });
    }

    public function getCurrentUserAttribute() {
        if ($this->number > 1) {
            if ($user = $this->users()->where('is_active', true)->where('current', true)->first()) {
                return $user;
            }
        }
        return $this->users()->where('is_active', true)->orderBy('answers')->orderBy('name')->first();
    }

    public function getStrongAttribute() {
        return $this->users()->where('strong', true)->first();
    }

    public function getBank() {
        return $this->last ? $this->bank * 2 : $this->bank;
    }

    public function getLastAttribute() {
        return $this->number == $this->game->users()->count()-1;
    }
}
