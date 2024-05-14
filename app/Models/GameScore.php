<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GameScore extends Model
{
    use HasFactory;

    protected $table = 'game_scores';
    protected $fillable = [
        'score',
        'total_questions'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function game(): HasOne
    {
        return $this->hasOne(Game::class);
    }
}
