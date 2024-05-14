<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'item_no'
    ];

    public function gameAnswer(): HasMany
    {
        return $this->hasMany(GameAnswer::class);
    }
}
