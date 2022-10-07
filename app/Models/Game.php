<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank'
    ];

    public function winner() {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function questions() {
        return $this->hasMany(Question::class, 'game_id');
    }

    public function rounds() {
        return $this->hasMany(Round::class, 'game_id');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'game_user');
    }

    public function getNextUser(User $user) {
        foreach ($this->active_users as $key => $u) {
            if ($u->id == $user->id) $index = $key+1;
        }

        if ($index > $this->active_users->count()-1) {
            return $this->active_users->first();
        }

        return $this->active_users[$index];
    }

    public function getActiveUsersAttribute() {
        return $this->users()->where('is_active', true)->get();
    }

    public function getStatistics() {
        return $this->users->map(function ($user) {
            $rounds = $user->rounds()->where('game_id', $this->id);
            foreach (User::getStatisticable() as $field) {
                $user[$field] = $rounds->sum($field);
            }
            $user['rounds'] = $rounds->count();
            $user['coefficient'] = round($rounds->sum('right_answers')/$rounds->sum('answers'), 2) * 100;
            return $user;
        })->sortBy([
            fn ($a, $b) => $b['coefficient'] <=> $a['coefficient'],
            fn ($a, $b) => $b['money'] <=> $a['money'],
            fn ($a, $b) => $b['coefficient'] <=> $a['coefficient']
        ]);
    }

}
