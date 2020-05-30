<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Participation extends MorphPivot
{
    protected $table = 'participations';

    protected $appends = ['participation_status', 'attend_status'];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'arrived_at' => 'datetime',
        'left_at' => 'datetime',
    ];

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
            return 'admitted';
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

    /**
     * Reject the participation request
     *
     * @throws \Exception
     */
    public function reject()
    {
        if ($this->participation_status != 'pending') {
            throw new \Exception('already admitted or rejected');
        }

        $this->rejected_at = Carbon::now();
        $this->save();
    }

    /**
     * Approve participation request
     *
     * @throws \Exception
     */
    public function admit()
    {
        if ($this->participation_status != 'pending') {
            throw new \Exception('already admitted or rejected');
        }

        $this->approved_at = Carbon::now();
        $this->save();
    }

    /**
     * Checkin the current participant
     *
     * @throws \Exception
     */
    public function checkIn()
    {
        if ($this->participation_status != 'admitted') {
            throw new \Exception('not admitted');
        }

        $this->arrived_at = Carbon::now();
        $this->save();
    }

    /**
     * Checkout the current participant
     *
     * @throws \Exception
     */
    public function checkOut()
    {
        if ($this->participation_status != 'admitted') {
            throw new \Exception('not admitted');
        }

        if ($this->attend_status != 'attended') {
            throw new \Exception('please attend first');
        }
        $this->left_at = Carbon::now();
        $this->save();
    }
}
