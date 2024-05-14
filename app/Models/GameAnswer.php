<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameAnswer extends Model
{
    use HasFactory;
    protected $table = 'game_answers';
    protected $fillable = [
        'text',
        'is_correct'
    ];
}
