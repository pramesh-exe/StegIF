<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property string $participant_id
 * @property string $main_expertise
 * @property string $education
 * @property string $gaming_experience
 * @property string $cybersecurity
 * @property string $steganography
 * @property string $stego_explanation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCybersecurity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereGamingExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereMainExpertise($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereSteganography($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereStegoExplanation($value)
 * @mixin \Eloquent
 */
class Profile extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'participant_id',
            'age',
            'main_expertise',
            'education',
            'gaming_experience',
            'cybersecurity',
            'steganography',
            'stego_explanation',
        ];

    public $timestamps = false;
}
