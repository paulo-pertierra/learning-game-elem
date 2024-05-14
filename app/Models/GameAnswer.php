<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameAnswer extends Model
{
    use HasFactory;
    protected $table = 'game_answers';
    protected $fillable = [
        'text',
        'is_correct'
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(GameQuestion::class, 'game_questions_id');
    }
}
