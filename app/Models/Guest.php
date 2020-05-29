<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Guest extends Model implements Participant
{
    use Notifiable;
    use CanParticipate;

    protected $fillable = [
        'name', 'email'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
