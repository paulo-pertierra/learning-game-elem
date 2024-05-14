<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'game_mode',
        'difficulty',
        'grade_level',
        'quarter',
        'total_questions',
        'added_by'
    ];

    public function gameQuestion(): HasMany
    {
        return $this->hasMany(GameQuestion::class);
    }
}
