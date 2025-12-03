<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'participant_id',
            'node',
            'time_since_start',
            'choice',
        ];

    public $timestamps = false;
}
