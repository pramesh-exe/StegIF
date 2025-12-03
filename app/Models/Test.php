<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'participant_id',
            'question1',
            'question2',
            'question3',
            'question4',
            'question5',
            'question6',
            'question7',
            'question8',
            'question9',
            'time_since_start',
            'score',
            'question1_points',
            'question2_points',
            'question3_points',
            'question4_points',
            'question5_points',
            'question6_points',
            'question7_points',
            'question8_points',
            'question9_points',
        ];

    protected $casts = [
        'question1' => 'array',
        'question2' => 'array',
        'question3' => 'array',
        'question6' => 'array',
        'question7' => 'array',
    ];

    public $timestamps = false;
}
