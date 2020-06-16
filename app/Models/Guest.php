<?php

namespace App\Models;

use App\Notifications\GuestVerifyEmail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Guest extends Model implements Participant, MustVerifyEmail
{
    use Notifiable;
    use CanParticipate;
    use \Illuminate\Auth\MustVerifyEmail;

    protected $fillable = [
        'name', 'email'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the email verification notification.
     *
     * @param Activity $activity
     * @return void
     */
    public function sendEmailEnrollVerificationNotification(Activity $activity)
    {
        $this->notify(new GuestVerifyEmail($activity));
    }
}
