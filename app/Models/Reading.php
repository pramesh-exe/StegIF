<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'participant_id',
            'time_since_start',
        ];

    public $timestamps = false;
}
