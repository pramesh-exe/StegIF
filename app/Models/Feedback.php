<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'participant_id',
            'game_improvements',
            'text_improvements',
            'other_improvements',
        ];

    public $timestamps = false;
}
