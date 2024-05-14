<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameQuestion extends Model
{
    use HasFactory;

    protected $table = 'game_questions';
    protected $fillable = [
        'question',
        'item_no'
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function gameAnswer(): HasMany
    {
        return $this->hasMany(GameAnswer::class, 'game_question_id');
    }
}
