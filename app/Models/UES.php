<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UES extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'participant_id',
            'fas1',
            'fas2',
            'fas3',
            'pus1',
            'pus2',
            'pus3',
            'aes1',
            'aes2',
            'aes3',
            'rws1',
            'rws2',
            'rws3',
        ];

    public $timestamps = false;
}
