<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Participation extends MorphPivot
{
    protected $table = 'participations';

    public $appends = ['participation_status', 'attend_status'];

    public function participant() {
        return $this->morphTo();
    }

    public function getParticipationStatusAttribute(): string
    {
        if ($this->cancelled_at) {
            return 'cancelled';
        }

        if ($this->rejected_at) {
            return 'rejected';
        }

        if ($this->approved_at) {
            return 'approved';
        }

        return 'pending';
    }

    public function getAttendStatusAttribute(): string
    {
        if ($this->left_at) {
            return 'left';
        }

        if ($this->arrived_at) {
           return 'attended';
        } else {
            return 'unattended';
        }
    }

    public function reject()
    {
        // TODO: validate, send message
        $this->rejected_at = Carbon::now();
        $this->save();
    }

    public function approve()
    {
        $this->approved_at = Carbon::now();
        $this->save();
    }

    public function checkIn()
    {
        $this->arrived_at = Carbon::now();
        $this->save();
    }

    public function checkOut()
    {
        $this->left_at = Carbon::now();
        $this->save();
    }
}
