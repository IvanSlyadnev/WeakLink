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
        return $this->belongsTo(User::class, 'winner');
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
        foreach ($this->users as $key => $u) {
            if ($u->id == $user->id) $index = $key+1;
        }
        if ($index >= $this->users->count()-1) {
            return $this->users()->first();
        }

        return $this->users[$index];
    }

}
