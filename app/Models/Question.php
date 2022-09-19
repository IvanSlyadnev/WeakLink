<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'text', 'answer', 'final', 'game_id'
    ];

    protected $casts = [
        'final' => 'boolean'
    ];

    public function game() {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
