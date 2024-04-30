<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printable extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'title',
        'description',
        'grade_level',
        'quarter'
    ];
}
